<?php

namespace App\Http\Controllers;

use App\Models\Profissao;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class ProfissaoController extends Controller
{

//    // TODO: Ativar o middleware de autenticação quando for implementar o PROD


    public function index(): JsonResponse
    {
        $profissaos = Profissao::all();
        return response()->json($profissaos, Response::HTTP_OK);
    }

    public function store(Request $request): JsonResponse
    {
        $request -> validate([
            'nome' => 'required|string|max:255',
            'ativo' => 'boolean',
            'outro' => 'boolean',
            'outro_nome' => 'string|max:255',
        ]);

        $profissao = Profissao::create([
            'nome' => $request->nome,
            'ativo' => $request->ativo,
            'outro' => $request->outro,
            'outro_nome' => $request->outro_nome,
        ]);

        return response()->json($profissao, Response::HTTP_CREATED);
    }


    public function show($id)
    {
        $profissao = Profissao::find($id);
        return response()->json($profissao, Response::HTTP_OK);
    }

    public function update(Request $request, $id)
    {
        $profissao = Profissao::find($id);
        $profissao->nome = $request->nome;
        $profissao->ativo = $request->ativo;
        $profissao->outro = $request->outro;
        $profissao->outro_nome = $request->outro_nome;
        $profissao->save();

        return response()->json($profissao, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $profissao = Profissao::find($id);
        $profissao->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
