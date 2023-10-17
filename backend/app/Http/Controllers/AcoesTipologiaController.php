<?php

namespace App\Http\Controllers;

use App\Models\AcoesTipologia;
use Illuminate\Http\Request;

class AcoesTipologiaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $acoesTipologia = AcoesTipologia::all();
        return response()->json($acoesTipologia, self::HTTP_OK);
    }

    public function store(Request $request)
    {
        $acoesTipologia = AcoesTipologia::query()->create($request->all());
        return response()->json($acoesTipologia, self::HTTP_CREATED);
    }

    public function show($id)
    {
        $acoesTipologia = AcoesTipologia::query()->findOrFail($id);
        return response()->json($acoesTipologia, self::HTTP_OK);
    }

    public function update(Request $request, $id)
    {
        $acoesTipologia = AcoesTipologia::query()->findOrFail($id);
        $acoesTipologia->update($request->all());
        return response()->json($acoesTipologia, self::HTTP_OK);
    }

    public function destroy($id)
    {
        $acoesTipologia = AcoesTipologia::query()->findOrFail($id);
        $acoesTipologia->delete();
        return response()->json(['message'=>'Deletado'], self::HTTP_OK);
    }
}
