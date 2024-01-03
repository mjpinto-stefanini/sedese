<?php

namespace App\Http\Controllers;

use App\Models\Respresentation;
use Illuminate\Http\Request;

class RespresentationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $respresentation = Respresentation::all();
        return response()->json($respresentation, self::HTTP_OK);
    }

    public function store(Request $request)
    {
        $respresentation = Respresentation::query()->create($request->all());
        return response()->json($respresentation, self::HTTP_CREATED);
    }

    public function show($id)
    {
        $respresentation = Respresentation::query()->find($id)->first();
        return response()->json($respresentation, self::HTTP_OK);
    }

    public function update(Request $request, $id)
    {
        $request -> validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'cell_phone' => 'required|string|max:255',
            'cell_phone_whatsapp' => 'required|string|max:255',
            'institutional_phone' => 'required|string|max:255',
            'institutional_email' => 'required|string|max:255',
            'isWhatsapp' => 'required|boolean',
        ]);

        $respresentation = Respresentation::query()->find($id)->first();

        foreach ($request->all() as $key => $value) {
            $respresentation->$key = $value;
        }

        $respresentation->save();

        return response()->json($respresentation, self::HTTP_OK);
    }

    public function destroy($id)
    {
        $respresentation = Respresentation::query()->find($id)->first();
        $respresentation->delete();
        return response()->json(null, self::HTTP_NO_CONTENT);
    }
}
