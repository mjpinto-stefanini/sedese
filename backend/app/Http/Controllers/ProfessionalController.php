<?php

namespace App\Http\Controllers;

use App\Models\Professional;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfessionalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @return JsonResponse
     */
    public function index()
    {
        $professionals = Professional::all();
        return response()->json($professionals, self::HTTP_OK);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $professional = Professional::create($request->all());
        return response()->json($professional, self::HTTP_CREATED);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        $professional = Professional::query()->find($id)->first();
        if (!$professional) {
            return response()->json([
                'status' => 'error',
                'message' => 'Professional not found',
            ], self::HTTP_NOT_FOUND);
        }
        return response()->json($professional, self::HTTP_OK);
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $professional = self::show($id);
        if ($professional['status'] == 'error') {
            return response()->json([
                'status' => 'error',
                'message' => 'Professional not found',
            ], self::HTTP_NOT_FOUND);
        }

        foreach ($request->all() as $key => $value) {
            $professional->$key = $value;
        }

        return response()->json($professional, self::HTTP_OK);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $professional = self::show($id);
        if ($professional['status'] == 'error') {
            return response()->json([
                'status' => 'error',
                'message' => 'Professional not found',
            ], self::HTTP_NOT_FOUND);
        }
        $professional->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Professional deleted',
        ], self::HTTP_OK);
    }

    public function professionalsUser($user_id)
    {
        $personal = Professional::query()->where('user_id', $user_id)->first();
        return response()->json($personal, self::HTTP_OK);
    }

}
