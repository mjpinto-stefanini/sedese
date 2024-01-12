<?php

namespace App\Http\Controllers;

use App\Models\Personal;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PersonalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

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

    public function personalUser($user_id)
    {
        $personal = Personal::query()->where('user_id', $user_id)->first();
        return response()->json($personal, self::HTTP_OK);
    }

    public function updatePersonalDataByUser(Request $request)
    {
        // Dados pessoais recebidos na requisição
        $personalData = [
            'user_id' => $request['user_id'],
            'name' => $request['name'],
            'social_name' => $request['socialName'],
            'gender_identity' => $request['genderIdentity'],
            'gender_identity_others' => $request['genderIdentityOthers'],
            'rg' => $request['rg'] ?? '',
            'issuing_body' => $request['issuingBody'] ?? '',
            'uf' => $request['uf'] ?? '',
            'education' => $request['education'],
            'profession' => $request['profession'],
            'profession_others' => $request['professionOthers'],
            'is_deficiency' => $request['isDeficiency'],
            'deficiency' => $request['deficiency'],
            'deficiency_others' => $request['deficiencyOthers'],
            'deficiency_structure' => $request['deficiencyStructure'],
        ];

        // Verifica se o registro já existe na tabela Personal
        $personal = Personal::where('user_id', $personalData['user_id'])->first();

        // Se o registro existir, atualiza os dados; caso contrário, cria um novo registro
        if ($personal) {
            $personal->update($personalData);
        } else {
            Personal::create($personalData);
        }

        // Retorno de sucesso ou outra lógica necessária
        return response()->json(['message' => 'Dados pessoais atualizados com sucesso']);
    }
}
