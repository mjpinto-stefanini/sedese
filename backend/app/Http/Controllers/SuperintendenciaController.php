<?php

namespace App\Http\Controllers;

use App\Models\Superintendencia;
use Illuminate\Http\Request;

class SuperintendenciaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $superintendencias = Superintendencia::all();
        return response()->json($superintendencias, self::HTTP_OK);
    }

    public function store(Request $request)
    {
        $superintendencia = Superintendencia::create($request->all());
        return response()->json($superintendencia, self::HTTP_CREATED);
    }

    public function show($id)
    {
        $superintendencia = Superintendencia::query()->find($id)->first();
        if (!$superintendencia) {
            return response()->json([
                'status' => 'error',
                'message' => 'Superintendencia not found',
            ], self::HTTP_NOT_FOUND);
        }
        return response()->json($superintendencia, self::HTTP_OK);
    }

    public function update(Request $request, $id)
    {
        $superintendencia = self::show($id);
        if (!$superintendencia) {
            return response()->json([
                'status' => 'error',
                'message' => 'Superintendencia not found',
            ], self::HTTP_NOT_FOUND);
        }

        foreach ($request->all() as $key => $value) {
            $superintendencia->$key = $value;
        }

        return response()->json($superintendencia, self::HTTP_OK);
    }

    public function destroy($id)
    {
        $superintendencia = self::show($id);
        if (!$superintendencia) {
            return response()->json([
                'status' => 'error',
                'message' => 'Superintendencia not found',
            ], self::HTTP_NOT_FOUND);
        }
        $superintendencia->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Superintendencia deleted',
        ], self::HTTP_OK);
    }
}
