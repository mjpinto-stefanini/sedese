<?php

namespace App\Http\Controllers;

use App\Mail\Bemvindo;
use App\Mail\RecoverPassword;
use App\Models\Address;
use App\Models\Contact;
use App\Models\Personal;
use App\Models\AmbitoAtuacao;
use App\Models\User;
use App\Models\Professional;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\NoReturn;

// TODO: Pemrissionamento no back.
// TODO: Consultas de permissão, via back.

class Users extends Controller
{

    // TODO: Ativar o middleware de autenticação quando for implementar o PROD

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
        $user = User::query()->find($id);
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

        $user = User::query()->find($id);
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

    /*
        {
            "personal":{
                "name":"Andre Abreu Cinquenta",
                "socialName":"Andre Abreu",
                "genderIdentity":"Homem (cis ou trans)",
                "genderIdentityOthers":"",
                "RG":"107022410",
                "issuingBody":"DETRAN",
                "uf":"RJ",
                "education":"Pós-Graduação Lato-Sensu Incompleta",
                "profession":"Outros",
                "profissionOthers":"",
                "isDeficiency":false,
                "deficiency":"Outros",
                "deficiencyOthers":"",
                "deficiencyStructure":"Letras maiores"
            },
            "address":{
                "zip_code":"21931-390",
                "street":"Rua Rui Vaz Pinto",
                "number":"15",
                "complement":"apto 302",
                "neighborhood":"Jardim Guanabara",
                "city":"Rio de Janeiro",
                "state":"RJ"
            },
            "contact":{
                "email":"andre.abreu+50@gmail.com",
                "phone":"(021) 9 9799-0964",
                "cell_phone":"(021) 9 9799-0964",
                "cell_phone_whatsapp":"",
                "institutional_phone":"",
                "institutional_email":"aabreu@stefanini.com",
                "isWhatsapp":true,
                "error":false
            },
            "professional":{
                "regional":{
                    "value":1,
                    "label":"Estadual"
                },
                "lotacao":{
                    "value":1,
                    "label":"Subsecretaria de Assistência Social"
                },
                "superintendencia":{
                    "value":2,
                    "label":"Superintendência de Proteção Social Especial"
                },
                "diretoriaRegionalDesSocial":"",
                "protecaoSocialBasica":"",
                "protecaoSocialEspecialEstadual":"Diretoria de Proteção Social Especial de Média Complexidade",
                "vigilanciaCapacitacao":"",
                "vinculoEmpregaticio":"Comissionado",
                "vinculoEmpregaticioOutro":"",
                "funcao":"Coordenação",
                "orgao":"",
                "areadeAtuacao":"",
                "beneficiosMunicipal":"",
                "beneficiosMunicipalOutro":"",
                "protecaoSocialEspecialMunicipal":"",
                "servicosPrograma":"",
                "servicosProgramaOutro":"",
                "representante":"",
                "areaRepresentada":"",
                "areaRepresentadaOutro":"",
                "cargo":""
            }
        }
     */

    public function secondStage(Request $request, string $id): JsonResponse
    {
        $errormsg = [];
        $user = User::query()->find($id);
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found 3',
            ], self::HTTP_NOT_FOUND);
        }

        $personalData = [
            'user_id' => $user['id'],
            'name' => $request['personal']['name'],
            'social_name' => $request['personal']['socialName'],
            'gender_identity' => $request['personal']['genderIdentity'],
            'gender_identity_others' => $request['personal']['genderIdentityOthers'],
            'rg' => $request['personal']['RG'],
            'issuing_body' => $request['personal']['issuingBody'] ?? '',
            'uf' => $request['personal']['uf'],
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
            'complement' => $request['address']['complement'],
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

        /*
             "professional":{
                "regional":{
                    "value":1,
                    "label":"Estadual"
                },
                "lotacao":{
                    "value":1,
                    "label":"Subsecretaria de Assistência Social"
                },
                "superintendencia":{
                    "value":2,
                    "label":"Superintendência de Proteção Social Especial"
                },
                "diretoriaRegionalDesSocial":"",
                "protecaoSocialBasica":"",
                "protecaoSocialEspecialEstadual":"Diretoria de Proteção Social Especial de Média Complexidade",
                "vigilanciaCapacitacao":"",
                "vinculoEmpregaticio":"Comissionado",
                "vinculoEmpregaticioOutro":"",
                "funcao":"Coordenação",
                "orgao":"",
                "areadeAtuacao":"",
                "beneficiosMunicipal":"",
                "beneficiosMunicipalOutro":"",
                "protecaoSocialEspecialMunicipal":"",
                "servicosPrograma":"",
                "servicosProgramaOutro":"",
                "representante":"",
                "areaRepresentada":"",
                "areaRepresentadaOutro":"",
                "cargo":""
            }

            php artisan make:migration add_lotacao_to_professionals_table --table=professionals


 */
        $professionalData = [
            'user_id' => $user['id'],
            'regional' => $request['professional']['regional']['label'],
            'lotacao' => $request['professional']['lotacao']['label'],
            'superintendencia' => $request['professional']['superintendencia']['label'] ?? '',
            'diretoria_regional_des_social' => $request['professional']['diretoriaRegionalDesSocial'],
            'protecao_social_basica' => $request['professional']['protecaoSocialBasica'],
            'protecao_social_especial_estadual' => $request['professional']['protecaoSocialEspecialEstadual'],
            'vigilancia_capacitacao' => $request['professional']['vigilanciaCapacitacao'],
            'vinculo_empregaticio' => $request['professional']['vinculoEmpregaticio'],
            'vinculo_empregaticio_outro' => $request['professional']['vinculoEmpregaticioOutro'],
            'funcao' => $request['professional']['funcao'],
            'orgao' => $request['professional']['orgao'],
            'area_de_atuacao' => $request['professional']['areadeAtuacao'],
            'beneficios_municipal' => $request['professional']['beneficiosMunicipal'],
            'beneficios_municipal_outro' => $request['professional']['beneficiosMunicipalOutro'],
            'protecao_social_especial_municipal' => $request['professional']['protecaoSocialEspecialMunicipal'],
            'servicos_programa' => $request['professional']['servicosPrograma'],
            'servicos_programa_outro' => $request['professional']['servicosProgramaOutro'],
            'representante' => $request['professional']['representante'],
            'area_representada' => $request['professional']['areaRepresentada'],
            'area_representada_outro' => $request['professional']['areaRepresentadaOutro'],
            'cargo' => $request['professional']['cargo'],
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

        $user['second_stage'] = true;
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Second Stage done'
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
}
