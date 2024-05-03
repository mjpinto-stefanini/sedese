<?php

namespace App\Http\Controllers;

use App\Models\Professional;
use App\Models\User;
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
        try {
            $professional = Professional::where('user_id', $user_id)->firstOrFail();
            return response()->json($professional, self::HTTP_OK);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'error' => 'Dados profissionais não encontrados.',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro aconteceu!',
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function updateProfessionalDataByUser(Request $request)
    {
        // Extração dos dados da representação
        $representacao = $request['profession']['ceas_representacao'] ?? $request['profession']['representante'] ?? '';
        $representacaoTitularidade = $request['profession']['representacao_titularidade'] ?? $request['profession']['ceas_titularidade'] ?? '';
        $representacaoSegmento = $request['profession']['representacaoSegmento']['label'] ?? $request['profession']['seguimento_governo']['label'] ?? $request['profession']['ceas_segmento']['label'] ?? '';
        $areaRepresentada = $request['profession']['area_representada']['label'] ?? $request['areaRepresentada'];
        $representante = $request['profession']['representante']['label'] ?? '';

        // Dados profissionais recebidos na requisição
        $professionalData = [
            'regional' => $request['profession']['regional'] ?? '',
            'superintendencia' => $request['profession']['superintendencia'] ?? '',
            'lotacao' => $request['profession']['lotacao'] ?? '',
            'protecao_social_basica' => $request['profession']['protecao_social_basica'] ?? '',
            'protecao_social_especial' => $request['profession']['protecao_social_especial'] ?? '',
            'vigilancia_capacitacao' => $request['profession']['vigilancia_capacitacao'] ?? '',
            'vinculo_empregaticio' => $request['profession']['vinculo_empregaticio'] ?? '',
            'funcao' => $request['profession']['funcao'] ?? '',
            'diretoria_regional_des_social' => $request['profession']['diretoria_regional_des_social'] ?? '',
            'creas_regional' => $request['profession']['creas_regional'] ?? '',
            'exe_creas_funcao' => $request['profession']['exe_creas_funcao'] ?? '',
            'exe_creas_vinc_empreg' => $request['profession']['exe_creas_vinc_empreg'] ?? '',
            'outros_publicos' => $request['profession']['outros_publicos'] ?? '',
            'outros_publicos_others' => $request['profession']['outros_publicos_others'] ?? '',
            'parceiros' => $request['profession']['parceiros_insc_interna'] ?? '',
            'orgao' => $request['profession']['orgao'] ?? '',
            'area_de_atuacao' => $request['profession']['area_de_atuacao'] ?? '',
            'protecao_social_basica_municipal' => $request['profession']['protecao_social_basica_municipal'] ?? '',
            'beneficios_socioassistenciais' => $request['profession']['beneficios_socioassistenciais'] ?? '',
            'protecao_social_especial_municipal' => $request['profession']['protecao_social_especial_municipal'] ?? '',
            'social_especial_municipal_media_complexidade' => $request['profession']['social_especial_municipal_media_complexidade'] ?? '',
            'social_especial_municipal_alta_complexidade' => $request['profession']['social_especial_municipal_alta_complexidade'] ?? '',
            'representacao' => $representacao,
            'area_representada' => $areaRepresentada ?? '',
            'area_representada_outros' => $request['profession']['area_representada_outros'] ?? '',
            'cargo' => $request['profession']['cargo'] ?? '',
            'representante' => $representante,
            'representacao_titularidade' => $representacaoTitularidade,
            'representacao_segmento' => $representacaoSegmento,
            'representacao_representacao' => $request['profession']['representacao_representacao'] ?? '',
            'representacao_conselho' => $request['profession']['representacao_conselho'] ?? '',
            'representacao_area_representada_outros' => $request['profession']['representacao_area_representada_outros'] ?? '',
            'representacao_area_representada' => $request['profession']['representacao_area_representada'] ?? '',
            'funcao_outro' => $request['profession']['funcao_outro'] ?? '',
            'vinculo_empregaticio_outro' => $request['profession']['vinculo_empregaticio_outro'] ?? '',
            'municipio_id' => $request['profession']['municipio']['id'] ?? null,
            'servicos_programa_outro' => $request['profession']['servicos_programa_outro'] ?? '',
            'servicos_programa' => $request['profession']['servicos_programa'] ?? '',
            'beneficios_municipal_outro' => $request['profession']['beneficios_municipal_outro'] ?? '',
            'beneficios_municipal' => $request['profession']['beneficios_municipal'] ?? '',
        ];

        // Verifica se o registro já existe na tabela Professional
        $professional = Professional::where('user_id', $request['user_id'])->first();

        // Se o registro existir, atualiza os dados; caso contrário, cria um novo registro
        if ($professional) {
            $professional->update($professionalData);
        } else {
            Professional::create($professionalData);
        }

        // atualizando o usuário
        User::find($request['user_id'])->update([
            'secretary' => $request['secretary'],
            'service' => $request['service']
        ]);

        // Retorno de sucesso ou outra lógica necessária
        return response()->json(['message' => 'Dados profissionais atualizados com sucesso']);
    }
}
