<?php

namespace App\Http\Controllers;

use App\Models\AcoesTematica;
use Illuminate\Http\Request;

class AcoesTematicaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $acoesTematica = AcoesTematica::all();
        return response()->json($acoesTematica, self::HTTP_OK);
    }

    public function store(Request $request)
    {
        $acoesTematica = AcoesTematica::query()->create($request->all());
        return response()->json($acoesTematica, self::HTTP_CREATED);
    }

    public function show($id)
    {
        $acoesTematica = AcoesTematica::query()->findOrFail($id);
        return response()->json($acoesTematica, self::HTTP_OK);
    }

    public function update(Request $request,$id)
    {
        $acoesTematica = AcoesTematica::query()->findOrFail($id);
        $acoesTematica->update($request->all());
        return response()->json($acoesTematica, self::HTTP_OK);
    }

    public function destroy($id)
    {
        $acoesTematica = AcoesTematica::query()->findOrFail($id);
        $acoesTematica->delete();
        return response()->json(['message'=>'Deletado'], self::HTTP_OK);
    }
}
