<?php

namespace App\Http\Controllers;

use App\Models\TurmaPolosMunicipios;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TurmaPolosMunicipiosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(): JsonResponse
    {
        $turmaPolosMunicipios = TurmaPolosMunicipios::all();
        return response()->json($turmaPolosMunicipios, self::HTTP_OK);
    }

    public function store(Request $request): JsonResponse
    {
        $turmaPolosMunicipio = TurmaPolosMunicipios::query()->create($request->all());
        return response()->json($turmaPolosMunicipio, self::HTTP_CREATED);
    }

    public function show($id): JsonResponse
    {
        $turmaPolosMunicipio = TurmaPolosMunicipios::query()->find($id);
        return response()->json($turmaPolosMunicipio, self::HTTP_OK);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $turmaPolosMunicipio = TurmaPolosMunicipios::query()->find($id)->first();

        foreach ($request->all() as $key => $value) {
            $turmaPolosMunicipio->$key = $value;
        }

        $turmaPolosMunicipio->save();
        return response()->json($turmaPolosMunicipio, self::HTTP_OK);
    }

    public function destroy($id): JsonResponse
    {
        $turmaPolosMunicipio = TurmaPolosMunicipios::query()->find($id)->first();
        $turmaPolosMunicipio->delete();
        return response()->json(['message'=>'Deleted'], self::HTTP_OK);
    }

    public function listByPolo($id): JsonResponse
    {
        $turmaPolosMunicipio = TurmaPolosMunicipios::query()->where('turma_polo_id', $id)->get();
        return response()->json($turmaPolosMunicipio, self::HTTP_OK);
    }

    public function listByAmbitoAtuacao($id): JsonResponse
    {
        $turmaPolosMunicipio = TurmaPolosMunicipios::query()->where('ambito_atuacaos_id', $id)->get();
        return response()->json($turmaPolosMunicipio, self::HTTP_OK);
    }
}
