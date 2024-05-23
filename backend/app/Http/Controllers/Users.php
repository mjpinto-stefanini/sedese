<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use App\Mail\Bemvindo;
use App\Models\Address;
use App\Models\Contact;
use App\Models\Personal;
use App\Models\AmbitoAtuacao;
use App\Models\User;
use App\Models\TipoPerfil;
use App\Models\Professional;
use App\Models\UserPerfilStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\Confirmation;
use Illuminate\Support\Facades\Log;

class Users extends Controller
{
    const MAX_LENGHT_PASSWORD = 6;

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['secondStage', 'confirmEmail']]);
    }

    public function list(Request $request): JsonResponse
    {
        try {
            $queryParams = $request->only([
                'status', 'perfil', 'secretary', 'service', 'name', 'cpf', 'email'
            ]);

            $users = $this->filterUsers($queryParams);
            $this->modifyUsers($users);
            return response()->json($users, 200);
        } catch (\Exception $e) {
            throw new \Exception ($e);
        }
    }

    private function filterUsers(array $queryParams)
    {
        $query = User::query();
        if (isset($queryParams['secretary'])) {
            $query->where('secretary', $queryParams['secretary']);
        }
        if (isset($queryParams['service'])) {
            $query->where('service', $queryParams['service']);
        }
        if (isset($queryParams['name'])) {
            $query->where('name', 'like', '%'. $queryParams['name'] . '%');
        }
        if (isset($queryParams['cpf'])) {
            $query->where('cpf', $queryParams['cpf']);
        }
        if (isset($queryParams['email'])) {
            $query->where('email', $queryParams['email']);
        }
        if (isset($queryParams['status'])) {
            $userIds = UserPerfilStatus::where('status', $queryParams['status'])->pluck('user_id')->toArray();
            $query->whereIn('id', $userIds);
        } else {
            $query->orderByRaw("FIELD((SELECT status FROM users_perfil_status WHERE users_perfil_status.user_id = users.id), 3, 1, 2, 4)");
        }
        if (isset($queryParams['perfil'])) {
            $userIds = UserPerfilStatus::where('tipo_perfil_id', $queryParams['perfil'])->pluck('user_id')->toArray();
            $query->whereIn('id', $userIds);
        }
        return $query->get();
    }

    private function modifyUsers($users)
    {
        $users->each(function ($user) {
            if (isset($user->secretary)) {
                $userSecretary = AmbitoAtuacao::query()->find($user->secretary);

                if ($userSecretary) {
                    $user->secretary = $userSecretary['nome'];
                }
            }
            $user->status = UserPerfilStatus::firstWhere('user_id', $user->id)['status'];
            $user->perfil = UserPerfilStatus::firstWhere('user_id', $user->id)['tipo_perfil_id'];
        });
    }

    public function get($id)
    {
        $dateFormat = '%d/%m/%Y';
        $user = User::with(['userPerfilStatus.tipoPerfil'])
            ->selectRaw("*, DATE_FORMAT(birthday, ?) as birthday", [$dateFormat])
            ->findOrFail($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
            ], self::HTTP_NOT_FOUND);
        }

        $tipoPerfilId = $user->userPerfilStatus->tipo_perfil_id ?? null;
        $tipoPerfil = $tipoPerfilId ? TipoPerfil::find($tipoPerfilId)->nome : null;
        $personal = Personal::where('user_id', $user->id)->first();

        $statusId = $user->userPerfilStatus->status ?? null;
        $status = match ($statusId) {
            UserPerfilStatus::STATUS_ATIVO => 'Ativo',
            UserPerfilStatus::STATUS_INATIVO => 'Inativo',
            UserPerfilStatus::STATUS_PENDENTE => 'Pendente',
            UserPerfilStatus::STATUS_REJEITADO => 'Rejeitado',
            default => null,
        };

        $admin = match ($user->type_admin) {
            User::USER_ADMINISTRADOR => 'Administrador',
            User::USER_OPERADOR => 'Operador',
            User::USER_USUARIO => 'Usuário',
            default => 'Usuário'
        };

        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'birthday' => $user->birthday,
            'type_admin' => $admin,
            'cpf' => $user->cpf,
            'email_verified_at' => $user->email_verified_at,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at,
            'is_active' => $user->is_active,
            'is_admin' => $user->is_admin,
            'is_superuser' => $user->is_superuser,
            'secretary' => $user->secretary,
            'service' => $user->service,
            'second_stage' => $user->second_stage,
            'tipo_perfil_id' => $tipoPerfilId,
            'tipo_perfil' => $tipoPerfil,
            'status_id' => $statusId,
            'status' => $status,
            'social_name' => $personal->social_name ?? null,
            'gender_identity' => $personal->gender_identity ?? null,
            'gender_identity_others' => $personal->gender_identity_others ?? null,
            'rg' => $personal->rg ?? null,
            'issuing_body' => $personal->issuing_body ?? null,
            'uf' => $personal->uf ?? null,
            'education' => $personal->education ?? null,
            'profission' => $personal->profission ?? null,
            'profission_others' => $personal->profission_others ?? null,
            'is_deficiency' => $personal->is_deficiency ?? null,
            'deficiency' => $personal->deficiency ?? null,
            'deficiency_others' => $personal->deficiency_others ?? null,
            'deficiency_structure' => $personal->deficiency_structure ?? null,
        ], 200);
    }

    public function updateuser(Request $request, string $id): JsonResponse
    {
        $user = User::findOrFail($id);
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found 2',
            ], self::HTTP_NOT_FOUND);
        }

        foreach ($request->all() as $key => $value) {
            $user->$key = $value;
        }

        $user->save();

        return response()->json($user, self::HTTP_OK);
    }

    public function secondStage(Request $request, string $id): JsonResponse
    {
        $errormsg = [];
        $user = User::findOrFail($id);
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
            ], self::HTTP_NOT_FOUND);
        }

        $personalData = [
            'user_id' => $user['id'],
            'name' => $request['personal']['name'],
            'social_name' => $request['personal']['socialName'],
            'gender_identity' => $request['personal']['genderIdentity'],
            'gender_identity_others' => $request['personal']['genderIdentityOthers'],
            'rg' => $request['personal']['RG']?? '',
            'issuing_body' => $request['personal']['issuingBody'] ?? '',
            'uf' => $request['personal']['uf']?? '',
            'education' => $request['personal']['education'],
            'profission' => $request['personal']['profession'],
            'profission_others' => $request['personal']['profissionOthers'],
            'is_deficiency' => $request['personal']['isDeficiency'],
            'deficiency' => $request['personal']['deficiency'],
            'deficiency_others' => $request['personal']['deficiencyOthers'],
            'deficiency_structure' => $request['personal']['deficiencyStructure'],
            //'birthday' => date('Y-m-d', strtotime($request['personal']['birthday'])),
        ];

        $personalResult = Personal::query()->create($personalData);
        if (!$personalResult) {
            $errormsg = [
                'status' => 'error',
                'message' => 'Error creating personal data',
                'code' => self::HTTP_INTERNAL_SERVER_ERROR,
            ];
        }

        $addressData = [
            'user_id' => $user['id'],
            'zip_code' => $request['address']['zip_code'],
            'street' => $request['address']['street'],
            'number' => $request['address']['number'],
            'complement' => $request['address']['complement'] ?? '',
            'neighborhood' => $request['address']['neighborhood'],
            'city' => $request['address']['city'],
            'state' => $request['address']['state'],
        ];

        $addressResult = Address::query()->create($addressData);
        if (!$addressResult) {
            $errormsg = [
                'status' => 'error',
                'message' => 'Error creating address data',
                'code' => self::HTTP_INTERNAL_SERVER_ERROR,
            ];
        }

        $isWhatsapp = false;

        if ($request['contact']['cell_phone_whatsapp'] == 'Sim') {
            $isWhatsapp = true;
        }

        if (isset($request['contact']['cell_phone_whatsapp'])) {
            $contactData['cell_phone_whatsapp'] = 'Não';
        }

        $contactData = [
            'user_id' => $user['id'],
            'phone' => $request['contact']['phone'],
            'cell_phone' => $request['contact']['cell_phone'],
            'cell_phone_whatsapp' => $request['contact']['cell_phone_whatsapp'],
            'institutional_phone' => $request['contact']['institutional_phone'],
            'institutional_email' => $request['contact']['institutional_email'],
            'isWhatsapp' => $isWhatsapp,
        ];

        $contactResult = Contact::query()->create($contactData);
        if (!$contactResult) {
            $errormsg = [
                'status' => 'error',
                'message' => 'Error creating contact data',
                'code' => self::HTTP_INTERNAL_SERVER_ERROR,
            ];
        }

        $representacao =  '';
        if (isset($request['professional']['ceas_representacao'])) {
            $representacao = $request['professional']['ceas_representacao'];
        } elseif (isset($request['professional']['representante']['label'])) {
            $representacao = $request['professional']['representante']['label'];
        }

        $representante = '';
        if (isset($request['professional']['representante']['label'])) {
            $representante = $request['professional']['representante']['label'];
        }

        $representacaoTitularidade = '';
        if (isset($request['professional']['representacaoTitularidade'])) {
            $representacaoTitularidade = $request['professional']['representacaoTitularidade'];
        } elseif(isset($request['professional']['ceas_titularidade'])) {
            $representacaoTitularidade = $request['professional']['ceas_titularidade'];
        }

        $representacaoSegmento = '';
        if (isset($request['professional']['representacaoSegmento']['label'])) {
            $representacaoSegmento = $request['professional']['representacaoSegmento']['label'];
        } elseif (isset($request['professional']['seguimento_governo']['label'])) {
            $representacaoSegmento = $request['professional']['seguimento_governo']['label'];
        } elseif (isset($request['professional']['ceas_segmento']['label'])) {
            $representacaoSegmento = $request['professional']['ceas_segmento']['label'];
        }
        $areaRepresentada = $request['professional']['areaRepresentada']['label'] ?? $request['professional']['areaRepresentada'];

        $professionalData = [
            'user_id' => $user['id'],
            'regional' => $request['professional']['regional']['label'] ?? '',
            'superintendencia' => $request['professional']['superintendencia']['label'] ?? '',
            'lotacao' => $request['professional']['lotacao']['label'] ?? '',
            'protecao_social_basica' => $request['professional']['protecaoSocialBasica'] ?? '',
            'protecao_social_especial' => $request['professional']['protecaoSocialEspecialEstadual'] ?? '',
            'vigilancia_capacitacao' => $request['professional']['vigilanciaCapacitacao'] ?? '',
            'vinculo_empregaticio' => $request['professional']['vinculoEmpregaticio'] ?? '',
            'funcao' => $request['professional']['funcao'] ?? '',
            'diretoria_regional_des_social' => $request['professional']['diretoriaRegionalDesSocial'] ?? '',
            'creas_regional' => $request['professional']['creasRegional']['label'] ?? '',
            'exe_creas_funcao' => '',
            'exe_creas_vinc_empreg' => '',
            'outros_publicos' => $request['professional']['outrosPublicos']['label'] ?? '',
            'outros_publicos_others' => $request['professional']['outrosPublicosOutro'] ?? '',
            'parceiros' => $request['professional']['parceirosInscInterna']['label'] ?? '',
            'orgao' => $request['professional']['orgao']['label'] ?? '',
            'area_de_atuacao' => $request['professional']['areadeAtuacao']['label'] ?? '',
            'protecao_social_basica_municipal' => '',
            'beneficios_socioassistenciais' => '',
            'protecao_social_especial_municipal' => $request['professional']['protecaoSocialEspecialMunicipal']['label'] ?? '',
            'social_especial_municipal_media_complexidade' => $request['professional']['socialEspecialMunicipalMediaComplexidade'] ?? '',
            'social_especial_municipal_alta_complexidade' => $request['professional']['socialEspecialMunicipalAltaComplexidade'] ?? '',
            'representacao' => $representacao,
            'area_representada' => $areaRepresentada ?? '',
            'area_representada_outros' => $request['professional']['areaRepresentadaOutro'] ?? '',
            'cargo' => $request['professional']['cargo']['label'] ?? '',
            'representante' => $representante,
            'representacao_titularidade' => $representacaoTitularidade,
            'representacao_segmento' => $representacaoSegmento,
            'representacao_representacao' => $request['professional']['representacaoRepresentacao']['label'] ?? '',
            'representacao_conselho' => $request['professional']['representacaoConselho']['label'] ?? '',
            'representacao_area_representada_outros' => $request['professional']['outrosRepresentacaoAreaRepresentada'] ?? '',
            'representacao_area_representada' => $request['professional']['representacaoAreaRepresentada'] ?? '',
            'funcao_outro' => $request['professional']['funcaoOutro'] ?? '',
            'vinculo_empregaticio_outro' => $request['professional']['vinculoEmpregaticioOutro'] ?? '',
            'municipio_id' => $request['professional']['municipio']['id'] ?? null,
            'servicos_programa_outro' => $request['professional']['servicosProgramaOutro'] ?? '',
            'servicos_programa' => $request['professional']['servicosPrograma']['label'] ?? '',
            'beneficios_municipal_outro' => $request['professional']['beneficiosMunicipalOutro'] ?? '',
            'beneficios_municipal' => $request['professional']['beneficiosMunicipal'] ?? '',
        ];

        User::find($user['id'])->update([
            'birthday' => date('Y-m-d', strtotime(date('Y-m-d', strtotime($request['personal']['birthday']))))
        ]);

        $professionalResult = Professional::query()->create($professionalData);
        if (!$professionalResult) {
            $errormsg = [
                'status' => 'error',
                'message' => 'Error creating professional data',
                'code' => self::HTTP_INTERNAL_SERVER_ERROR,
            ];
        }

        if ($errormsg) {
            return response()->json($errormsg, $errormsg['code']);
        }

        $user['second_stage'] = true;
        $user->save();

        $msg = [];
        // enviando email de confirmação para o usuário
        try {
            $mailData = [
                'name' => $user['name'],
                'email' => $user['email'],
                'token' => $user['remember_token'],
            ];
            Mail::to($user['email'])->send(new Confirmation($mailData));
        } catch (\Exception $e) {
            $msg = response()->json($e->getMessage(), $e->getCode());
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Second Stage done',
            'personal' => $request['personal'],
            'contact' => $request['contact'],
            'address' => $request['address'],
            'professional' => $request['professional'],
        ], self::HTTP_CREATED);
    }

    /**
     * @param string $token
     * @return JsonResponse
     */
    public function confirmEmail(string $token): JsonResponse
    {
        $user = User::query()->where('remember_token', $token)->first();
        if ($user) {
            $user->email_verified_at = Carbon::now();
            $user->is_active = 1;
            $user->save();

            try {
                $mailData = [
                    'name' => $user['name'],
                    'email' => $user['email'],
                ];

                Mail::to($user['email'])->send(new Bemvindo($mailData));

                return response()->json([
                    'status' => 'success',
                    'type' => 'positive',
                    'message' => 'E-mail confirmado com sucesso. Pode fechar esta janela',
                ], Controller::HTTP_OK);

            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'type' => 'negative',
                    'message' => 'Erro ao enviar e-mail de bem vindo. '.$e->getMessage(),
                ], Controller::HTTP_INTERNAL_SERVER_ERROR);
            }

        }
        return response()->json([
            'status' => 'error',
            'type' => 'negative',
            'message' => 'Token inválido.',
        ], Controller::HTTP_UNAUTHORIZED);
    }

    public function generateRandomPassword()
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $password = '';

        for ($i = 0; $i < self::MAX_LENGHT_PASSWORD; $i++) {
            $password .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $password;
    }

    public function sendPasswordByEmail($id)
    {
        $user = User::findOrFail($id);
        $newPassword = $this->generateRandomPassword();
        $user->password = bcrypt($newPassword);
        $user->save();

        Mail::send('emails.new_password', ['password' => $newPassword], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Nova Senha Gerada');
        });
    }

    public function changeStatus(Request $request)
    {
        $userId = $request->input('user_id');
        $status = intval($request->input('status'));
        UserPerfilStatus::where('user_id', $userId)->update(['status' => $status]);
        return response()->json([
            'status' => 'success',
            'type' => 'positive',
            'message' => 'Status Atualizado com sucesso.',
        ], self::HTTP_OK);
    }

    public function changePerfil(Request $request): JsonResponse
    {
        $userId = $request->input('user_id');
        $perfil = intval($request->input('perfil'));

        $updateDataUser['tipo_perfil_id'] = $perfil;
        if ($perfil === 1) {
            $updateDataUser['status'] = 3;
        }
        UserPerfilStatus::where('user_id', $userId)->update($updateDataUser);
        return response()->json([
            'status' => 'success',
            'type' => 'positive',
            'message' => 'Perfil atualizado com sucesso.',
        ], self::HTTP_OK);
    }

    public function changeAdmin(Request $request)
    {
        $userId = $request->input('user_id');
        $admin = intval($request->input('admin'));
        User::where('id', $userId)->update(['type_admin' => $admin]);
        if ($admin === User::USER_ADMINISTRADOR) {
            User::where('id', $userId)->update(['is_admin' => 1]);
        }
        return response()->json([
            'status' => 'success',
            'type' => 'positive',
            'message' => 'Perfil atualizado com sucesso.',
        ], self::HTTP_OK);
    }
}
