<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{



    public function index()
    {
        $address = Address::all();
        return response()->json($address, self::HTTP_OK);
    }

    public function store(Request $request)
    {
        $address = Address::query()->create($request->all());
        return response()->json($address, self::HTTP_CREATED);
    }

    public function show(Request $id)
    {
        $address = Address::query()->find($id)->first();
        return response()->json($address, self::HTTP_OK);
    }

    public function update(Request $request, address $address)
    {
        $request -> validate([
            'zip_code' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'number' => 'required|string|max:255',
            'complement' => 'required|string|max:255',
            'neighborhood' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
        ]);

        foreach ($request->all() as $key => $value) {
            $address->$key = $value;
        }

        $address->save();

        return response()->json($address, self::HTTP_OK);
    }

    public function destroy(address $address)
    {
        $address->delete();
        return response()->json(null, self::HTTP_NO_CONTENT);
    }
}
