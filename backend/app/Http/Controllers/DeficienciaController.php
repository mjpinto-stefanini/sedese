<?php

namespace App\Http\Controllers;


use App\Models\Deficiencia;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class DeficienciaController extends Controller
{



    public function index()
    {
        $deficiencias = Deficiencia::all();
        return response()->json($deficiencias, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $request -> validate([
            'nome' => 'required|string|max:255',
            'outro' => 'boolean',
            'outro_nome' => 'string|max:255',
        ]);

        $deficiencia = Deficiencia::create([
            'nome' => $request->nome,
            'outro' => $request->outro,
            'outro_nome' => $request->outro_nome,
        ]);

        return response()->json($deficiencia, Response::HTTP_CREATED);
    }

    public function show($id)
    {
        $deficiencia = Deficiencia::find($id);
        return response()->json($deficiencia, Response::HTTP_OK);
    }

    public function update(Request $request, $id)
    {
        $deficiencia = Deficiencia::find($id);
        $deficiencia->nome = $request->nome;
        $deficiencia->outro = $request->outro;
        $deficiencia->outro_nome = $request->outro_nome;
        $deficiencia->save();

        return response()->json($deficiencia, Response::HTTP_OK);
    }

    public function destroy($id)
    {
        $deficiencia = Deficiencia::find($id);
        $deficiencia->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
