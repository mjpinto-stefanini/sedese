<?php

namespace App\Http\Controllers;

use App\Models\Acoes;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AcoesController extends Controller
{


    /**
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $acoes = Acoes::all();
        return response()->json($acoes, self::HTTP_OK);
    }

    public function store(Request $request)
    {
        $request -> validate([
                'ano' => 'required',
                'nome' => 'required',
                'tipo' => 'required',
                'tematica' => 'required',
                'tipologia' => 'required',
                'modalidade' => 'required',
                'data_inicio' => 'required',
                'data_fim' => 'required',
                'num_vagas' => 'required',
                'acao_regionalizada' => 'required',
                'areas_envolvidas' => 'required',
            ]);

        $acao = Acoes::query()->create($request->all());
        return response()->json($acao, self::HTTP_CREATED);
    }

    public function show($id)
    {
        $acao = Acoes::query()->findOrFail($id);
        return response()->json($acao, self::HTTP_OK);
    }

    public function update(Request $request, $id)
    {
        $acao = Acoes::query()->findOrFail($id);

        foreach ($request->all() as $key => $value) {
            $acao->$key = $value;
        }

        $acao->save();

        return response()->json($acao, self::HTTP_OK);
    }

    public function destroy($id)
    {
        $acao = Acoes::query()->findOrFail($id);
        $acao->delete();
        return response()->json(['message'=>'Ação deletada'], self::HTTP_OK);
    }
}
