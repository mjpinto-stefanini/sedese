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

class Users extends Controller
{
    const MAX_LENGHT_PASSWORD = 6;

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['secondStage']]);
    }

    public function list(): JsonResponse
    {
        $users = User::all();
        foreach ($users as $user) {
            if (isset($user->secretary)) {
                $user->secretary = AmbitoAtuacao::query()->find($user->secretary)['nome'];
            }
        }
        return response()->json($users, 200);
    }

    public function get(string $id): JsonResponse
    {
        $dateFormat = '%d/%m/%Y'; 
        $user = User::selectRaw("*, DATE_FORMAT(birthday, ?) as birthday_txt", [$dateFormat])
        ->findOrFail($id);
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found 1',
            ], self::HTTP_NOT_FOUND);
        }
        return response()->json($user, 200);
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
        } elseif(isset($request['profissional']['ceas_titularidade'])) {
            $representacaoTitularidade = $request['profissional']['ceas_titularidade'];
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
            'creas_regional' => $request['professional']['creasRegional'] ?? '',
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

        $user['birthday'] = $request['personal']['dataNascimento'];
        $user['second_stage'] = true;
        $user->save();

        $msg = [];
        // enviando email de confirmação para o usuário
        try {
            $mailData = [
                'name' => $user['name'],
                'email' => $user['email'],
                'token' => $user['rememberToken'],
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

            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'type' => 'negative',
                    'message' => 'Erro ao enviar e-mail de bem vindo. '.$e->getMessage(),
                ], self::HTTP_INTERNAL_SERVER_ERROR);
            }

            return response()->json([
                'status' => 'success',
                'type' => 'positive',
                'message' => 'E-mail confirmado com sucesso. Pode fechar esta janela',
            ], self::HTTP_OK);

        }
        return response()->json([
            'status' => 'error',
            'type' => 'negative',
            'message' => 'Token inválido.',
        ], self::HTTP_UNAUTHORIZED);
    }

    public function generateRandomPassword() {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $password = '';
    
        for ($i = 0; $i < self::MAX_LENGHT_PASSWORD; $i++) {
            $password .= $characters[rand(0, strlen($characters) - 1)];
        }
    
        return $password;
    }

    public function sendPasswordByEmail($id) {
        $user = User::findOrFail($id);
        $newPassword = $this->generateRandomPassword();
        $user->password = bcrypt($newPassword);
        $user->save();

        // Se estiver no ambiente local ou de desenvolvimento, não envie o e-mail
        if (App::environment('local', 'development')) {
            return;
        }
    
        Mail::send('emails.new_password', ['password' => $newPassword], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Nova Senha Gerada');
        });
    }
    
}
