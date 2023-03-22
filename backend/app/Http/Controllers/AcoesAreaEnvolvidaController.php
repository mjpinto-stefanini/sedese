<?php

namespace App\Http\Controllers;

use App\Models\AcoesAreaEnvolvida;
use Illuminate\Http\Request;

class AcoesAreaEnvolvidaController extends Controller
{

    public function index()
    {
        $acoesAreaEnvolvida = AcoesAreaEnvolvida::all();
        return response()->json($acoesAreaEnvolvida, self::HTTP_OK);
    }

    public function store(Request $request)
    {
        $acoesAreaEnvolvida = AcoesAreaEnvolvida::query()->create($request->all());
        return response()->json($acoesAreaEnvolvida, self::HTTP_CREATED);
    }

    public function show($id)
    {
        $acoesAreaEnvolvida = AcoesAreaEnvolvida::query()->findOrFail($id);
        return response()->json($acoesAreaEnvolvida, self::HTTP_OK);
    }

    public function update(Request $request, $id)
    {
        $acoesAreaEnvolvida = AcoesAreaEnvolvida::query()->findOrFail($id);
        $acoesAreaEnvolvida->update($request->all());
        return response()->json($acoesAreaEnvolvida, self::HTTP_OK);
    }

    public function destroy($id)
    {
        $acoesAreaEnvolvida = AcoesAreaEnvolvida::query()->findOrFail($id);
        $acoesAreaEnvolvida->delete();
        return response()->json(['message'=>'Deletado'], self::HTTP_OK);
    }
}
