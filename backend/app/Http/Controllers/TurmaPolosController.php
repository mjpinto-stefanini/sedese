<?php

namespace App\Http\Controllers;

use App\Models\TurmaPolos;
use Illuminate\Http\Request;

class TurmaPolosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $turmaPolos = TurmaPolos::all();
        return response()->json($turmaPolos, self::HTTP_OK);
    }

    public function store(Request $request)
    {
        $turmaPolo = TurmaPolos::query()->create($request->all());
        return response()->json($turmaPolo, self::HTTP_CREATED);
    }

    public function show($id)
    {
        $turmaPolo = TurmaPolos::query()->find($id);
        return response()->json($turmaPolo, self::HTTP_OK);
    }

    public function update(Request $request, $id)
    {
        $turmaPolo = TurmaPolos::query()->find($id)->first();

        foreach ($request->all() as $key => $value) {
            $turmaPolo->$key = $value;
        }

        $turmaPolo->save();
        return response()->json($turmaPolo, self::HTTP_OK);
    }

    public function destroy($id)
    {
        $turmaPolo = TurmaPolos::query()->find($id)->first();
        $turmaPolo->delete();
        return response()->json(['message'=>'Deleted'], self::HTTP_OK);
    }
}
