<?php

namespace App\Http\Controllers;

use App\Models\Turma;
use Illuminate\Http\Request;

class TurmaController extends Controller
{

//    // TODO: Ativar o middleware de autenticação quando for implementar o PROD


    public function index()
    {
        $turmas = Turma::all();
        return response()->json($turmas, self::HTTP_OK);
    }

    public function store(Request $request)
    {
        $turma = Turma::query()->create($request->all());
        return response()->json($turma, self::HTTP_CREATED);
    }

    public function show($id)
    {
        $turma = Turma::query()->find($id);
        return response()->json($turma, self::HTTP_OK);
    }

    public function update(Request $request, $id)
    {
        $turma = Turma::query()->find($id)->first();

        foreach ($request->all() as $key => $value) {
            $turma->$key = $value;
        }

        $turma->save();
        return response()->json($turma, self::HTTP_OK);
    }

    public function destroy($id)
    {
        $turma = Turma::query()->find($id)->first();
        $turma->delete();
        return response()->json(['message'=>'Deleted'], self::HTTP_OK);
    }
}
