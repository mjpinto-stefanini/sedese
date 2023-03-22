<?php

namespace App\Http\Controllers;

use App\Models\Regional;
use Illuminate\Http\Request;

class RegionalController extends Controller
{

//    // TODO: Ativar o middleware de autenticação quando for implementar o PROD



    public function index()
    {
        $regionals = Regional::all();
        return response()->json($regionals, 200);
    }

    public function store(Request $request)
    {
        $regional = Regional::create($request->all());
        return response()->json($regional, 201);
    }

    public function show($id)
    {
        $regional = Regional::query()->find($id);
        if (!$regional) {
            return response()->json([
                'status' => 'error',
                'message' => 'Regional not found',
            ], self::HTTP_NOT_FOUND);
        }
        return response()->json($regional, 200);

    }

    public function update(Request $request, $id)
    {
        $regional = Regional::query()->find($id);
        if (!$regional) {
            return response()->json([
                'status' => 'error',
                'message' => 'Regional not found',
            ], self::HTTP_NOT_FOUND);
        }

        foreach ($request->all() as $key => $value) {
            $regional->$key = $value;
        }

        return response()->json($regional, 200);
    }

    public function destroy($id)
    {
        $regional = Regional::query()->find($id);
        if (!$regional) {
            return response()->json([
                'status' => 'error',
                'message' => 'Regional not found',
            ], self::HTTP_NOT_FOUND);
        }

        $regional->delete();

        return response()->json(null, 204);
    }
}
