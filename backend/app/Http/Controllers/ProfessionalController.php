<?php

namespace App\Http\Controllers;

use App\Models\Professional;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfessionalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @return JsonResponse
     */
    public function index()
    {
        $professionals = Professional::all();
        return response()->json($professionals, self::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $professional = Professional::create($request->all());
        return response()->json($professional, self::HTTP_CREATED);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $professional = Professional::query()->find($id)->first();
        if (!$professional) {
            return response()->json([
                'status' => 'error',
                'message' => 'Professional not found',
            ], self::HTTP_NOT_FOUND);
        }
        return response()->json($professional, self::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $professional = self::show($id);
        if ($professional['status'] == 'error') {
            return response()->json([
                'status' => 'error',
                'message' => 'Professional not found',
            ], self::HTTP_NOT_FOUND);
        }

        foreach ($request->all() as $key => $value) {
            $professional->$key = $value;
        }

        return response()->json($professional, self::HTTP_OK);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $professional = self::show($id);
        if ($professional['status'] == 'error') {
            return response()->json([
                'status' => 'error',
                'message' => 'Professional not found',
            ], self::HTTP_NOT_FOUND);
        }
        $professional->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Professional deleted',
        ], self::HTTP_OK);
    }

    public function professionalsUser($user_id)
    {
        $personal = Professional::query()->where('user_id', $user_id)->first();
        return response()->json($personal, self::HTTP_OK);
    }

    public function updateProfessionalDataByUser(Request $request)
    {
        // Extração dos dados da representação
        $representacao = $request['ceas_representacao'] ?? $request['representante']['label'] ?? '';
        $representacaoTitularidade = $request['representacaoTitularidade'] ?? $request['ceas_titularidade'] ?? '';
        $representacaoSegmento = $request['representacaoSegmento']['label'] ?? $request['seguimento_governo']['label'] ?? $request['ceas_segmento']['label'] ?? '';
        $areaRepresentada = $request['areaRepresentada']['label'] ?? $request['areaRepresentada'];
        $representante = $request['representante']['label'] ?? '';

        // Dados profissionais recebidos na requisição
        $professionalData = [
            'user_id' => $request['user_id'],
            'regional' => $request['regional']['label'] ?? '',
            'superintendencia' => $request['superintendencia']['label'] ?? '',
            'lotacao' => $request['lotacao']['label'] ?? '',
            'protecao_social_basica' => $request['protecaoSocialBasica'] ?? '',
            'protecao_social_especial' => $request['protecaoSocialEspecialEstadual'] ?? '',
            'vigilancia_capacitacao' => $request['vigilanciaCapacitacao'] ?? '',
            'vinculo_empregaticio' => $request['vinculoEmpregaticio'] ?? '',
            'funcao' => $request['funcao'] ?? '',
            'diretoria_regional_des_social' => $request['diretoriaRegionalDesSocial'] ?? '',
            'creas_regional' => $request['creasRegional'] ?? '',
            'exe_creas_funcao' => '',
            'exe_creas_vinc_empreg' => '',
            'outros_publicos' => $request['outrosPublicos']['label'] ?? '',
            'outros_publicos_others' => $request['outrosPublicosOutro'] ?? '',
            'parceiros' => $request['parceirosInscInterna']['label'] ?? '',
            'orgao' => $request['orgao']['label'] ?? '',
            'area_de_atuacao' => $request['areadeAtuacao']['label'] ?? '',
            'protecao_social_basica_municipal' => '',
            'beneficios_socioassistenciais' => '',
            'protecao_social_especial_municipal' => $request['protecaoSocialEspecialMunicipal']['label'] ?? '',
            'social_especial_municipal_media_complexidade' => $request['socialEspecialMunicipalMediaComplexidade'] ?? '',
            'social_especial_municipal_alta_complexidade' => $request['socialEspecialMunicipalAltaComplexidade'] ?? '',
            'representacao' => $representacao,
            'area_representada' => $areaRepresentada ?? '',
            'area_representada_outros' => $request['areaRepresentadaOutro'] ?? '',
            'cargo' => $request['cargo']['label'] ?? '',
            'representante' => $representante,
            'representacao_titularidade' => $representacaoTitularidade,
            'representacao_segmento' => $representacaoSegmento,
            'representacao_representacao' => $request['representacaoRepresentacao']['label'] ?? '',
            'representacao_conselho' => $request['representacaoConselho']['label'] ?? '',
            'representacao_area_representada_outros' => $request['outrosRepresentacaoAreaRepresentada'] ?? '',
            'representacao_area_representada' => $request['representacaoAreaRepresentada'] ?? '',
            'funcao_outro' => $request['funcaoOutro'] ?? '',
            'vinculo_empregaticio_outro' => $request['vinculoEmpregaticioOutro'] ?? '',
            'municipio_id' => $request['municipio']['id'] ?? null,
            'servicos_programa_outro' => $request['servicosProgramaOutro'] ?? '',
            'servicos_programa' => $request['servicosPrograma']['label'] ?? '',
            'beneficios_municipal_outro' => $request['beneficiosMunicipalOutro'] ?? '',
            'beneficios_municipal' => $request['beneficiosMunicipal'] ?? '',
        ];

        // Verifica se o registro já existe na tabela Professional
        $professional = Professional::where('user_id', $professionalData['user_id'])->first();

        // Se o registro existir, atualiza os dados; caso contrário, cria um novo registro
        if ($professional) {
            $professional->update($professionalData);
        } else {
            Professional::create($professionalData);
        }

        // Retorno de sucesso ou outra lógica necessária
        return response()->json(['message' => 'Dados profissionais atualizados com sucesso']);
    }
}
