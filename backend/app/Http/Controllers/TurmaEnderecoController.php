<?php

namespace App\Http\Controllers;

use App\Models\TurmaEndereco;
use Illuminate\Http\Request;

class TurmaEnderecoController extends Controller
{

//    // TODO: Ativar o middleware de autenticação quando for implementar o PROD


    public function index()
    {
        $turmaEnderecos = TurmaEndereco::all();
        return response()->json($turmaEnderecos, self::HTTP_OK);
    }

    public function store(Request $request)
    {
        $turmaEndereco = TurmaEndereco::query()->create($request->all());
        return response()->json($turmaEndereco, self::HTTP_CREATED);
    }

    public function show($id)
    {
        $turmaEndereco = TurmaEndereco::query()->find($id);
        return response()->json($turmaEndereco, self::HTTP_OK);
    }

    public function update(Request $request, $id)
    {
        $turmaEndereco = TurmaEndereco::query()->find($id)->first();

        foreach ($request->all() as $key => $value) {
            $turmaEndereco->$key = $value;
        }

        $turmaEndereco->save();
        return response()->json($turmaEndereco, self::HTTP_OK);
    }

    public function destroy($id)
    {
        $turmaEndereco = TurmaEndereco::query()->find($id)->first();
        $turmaEndereco->delete();
        return response()->json(['message'=>'Deleted'], self::HTTP_OK);
    }
}
