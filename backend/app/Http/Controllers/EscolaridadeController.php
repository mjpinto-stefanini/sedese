<?php

namespace App\Http\Controllers;

use App\Models\Escolaridade;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;


class EscolaridadeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(): JsonResponse
    {
        $escolaridades = Escolaridade::all();
        return response()->json($escolaridades, Response::HTTP_OK);
    }

    public function show($id): JsonResponse
    {
        $escolaridade = Escolaridade::find($id);
        return response()->json($escolaridade, Response::HTTP_OK);
    }

    public function store(Request $request): JsonResponse
    {
        $request -> validate([
            'nome' => 'required|string|max:255',
            'ativo' => 'boolean',
            'outro' => 'boolean',
            'outro_nome' => 'string|max:255',
        ]);

        $escolaridade = Escolaridade::create([
            'nome' => $request->nome,
            'ativo' => $request->ativo,
            'outro' => $request->outro,
            'outro_nome' => $request->outro_nome,
        ]);

        return response()->json($escolaridade, Response::HTTP_CREATED);
    }

    public function update(Request $request, $id)
    {
        $escolaridade = Escolaridade::find($id);
        $escolaridade->nome = $request->nome;
        $escolaridade->ativo = $request->ativo;
        $escolaridade->outro = $request->outro;
        $escolaridade->outro_nome = $request->outro_nome;
        $escolaridade->save();

        return response()->json($escolaridade, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $escolaridade = Escolaridade::find($id);
        $escolaridade->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
