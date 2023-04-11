<?php

namespace App\Http\Controllers;


use App\Models\AmbitoAtuacao;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use \Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AmbitoAtuacaoController extends Controller
{



    public function index(): JsonResponse
    {
        $ambitoAtuacaos = AmbitoAtuacao::query()->where("ativo", 1)->orderBy('nome')->get();
        return response()->json($ambitoAtuacaos, Controller::HTTP_OK);
    }

    public function store(Request $request): JsonResponse
    {
        $request -> validate([
            'nome' => 'required|string|max:255',
            'regiao_administrativa' => 'required|boolean',
        ]);

        $ambitoAtuacao = AmbitoAtuacao::query()->create([
            'nome' => $request->nome,
            'regiao_administrativa' => $request->regiao_administrativa,
        ]);

        return response()->json($ambitoAtuacao, Response::HTTP_CREATED);
    }

    public function show($id)
    {
        $ambitoAtuacao = AmbitoAtuacao::query()->find($id);
        return response()->json($ambitoAtuacao, Response::HTTP_OK);
    }

    public function update(Request $request, $id)
    {

        $request -> validate([
            'nome' => 'required|string|max:255',
            'regiao_administrativa' => 'required|boolean',
        ]);

        $ambitoAtuacao = AmbitoAtuacao::query()->find($id);
        $ambitoAtuacao->nome = $request->nome;
        $ambitoAtuacao->regiao_administrativa = $request->regiao_administrativa;
        $ambitoAtuacao->save();

        return response()->json($ambitoAtuacao, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $ambitoAtuacao = AmbitoAtuacao::query()->find($id);
        $ambitoAtuacao->delete();

        return response()->json('Ambito de Atuação deletado com sucesso!', Response::HTTP_OK);
    }

    public function ShowRegiaoAdministrativa($id): JsonResponse
    {

        $ambitoAtuacaos = AmbitoAtuacao::query()
            ->where('regiao_administrativa', '=', 2)->orderBy('nome')->get();

        if ($id == "1") {
            $ambitoAtuacaos = AmbitoAtuacao::query()
                ->where('regiao_administrativa', '=', 1)->orderBy('nome')->get();
        }

        return response()->json($ambitoAtuacaos, ResponseAlias::HTTP_OK);
    }
}
