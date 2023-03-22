<?php

namespace App\Http\Controllers;

use App\Models\Personal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PersonalController extends Controller
{



    public function index()
    {
        $personals = Personal::all();
        return response()->json($personals, self::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $request -> validate([
            'user_id' => 'required|integer',
            'social_name' => 'required|string|max:255',
            'gender_identity' => 'required|string|max:255',
            'rg' => 'required|string|max:255',
            'issuing_department' => 'required|string|max:255',
            'uf' => 'required|string|max:255',
            'escolaridade_id' => 'required|integer',
            'profission_id' => 'required|integer',
            'is_deficiency' => 'required|boolean',
        ]);

        $personal = Personal::query()->create([
            'user_id' => $request->user_id,
            'social_name' => $request->social_name,
            'gender_identity' => $request->gender_identity,
            'rg' => $request->rg,
            'issuing_department' => $request->issuing_department,
            'uf' => $request->uf,
            'escolaridade_id' => $request->escolaridade_id,
            'profission_id' => $request->profission_id,
            'is_deficiency' => $request->is_deficiency,
        ]);

        return response()->json($personal, self::HTTP_CREATED);

    }

    public function show(Request $id)
    {
        $personal = Personal::query()->find($id);
        return response()->json($personal, self::HTTP_OK);
    }

    public function update(Request $request, Request $id)
    {
        $personal = Personal::query()->find($id);

        foreach ($request->all() as $key => $value) {
            $personal->$key = $value;
        }

        $personal->save();

        return response()->json($personal, self::HTTP_OK);
    }

    public function destroy(Request $id)
    {
        $personal = Personal::query()->find($id);
        $personal->delete();

        return response()->json(null, self::HTTP_OK);
    }
}
