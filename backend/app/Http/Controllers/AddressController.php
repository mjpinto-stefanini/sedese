<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AddressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

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
        Validator::make($request->all(), [
            'user_id' => 'required',
            'zip_code' => 'required',
            'street' => 'required',
            'number' => 'required',
            'neighborhood' => 'required',
            'city' => 'required',
            'state' => 'required',
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

    public function addressUser($user_id)
    {
        $personal = Address::query()->where('user_id', $user_id)->first();
        return response()->json($personal, self::HTTP_OK);
    }

    public function updateAddressDataByUser(Request $request)
    {
        // Validar os campos obrigatórios
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'zip_code' => 'required',
            'street' => 'required',
            'number' => 'required',
            'neighborhood' => 'required',
            'city' => 'required',
            'state' => 'required',
        ]);

        // Se a validação falhar, retornar mensagem de erro
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }

        // Dados de endereço recebidos na requisição
        $addressData = [
            'user_id' => $request['user_id'],
            'zip_code' => $request['zip_code'],
            'street' => $request['street'],
            'number' => $request['number'],
            'complement' => $request['complement'] ?? '',
            'neighborhood' => $request['neighborhood'],
            'city' => $request['city'],
            'state' => $request['state'],
        ];

        // Verifica se o registro já existe na tabela Address
        $address = Address::where('user_id', $addressData['user_id'])->first();

        // Se o registro existir, atualiza os dados; caso contrário, cria um novo registro
        if ($address) {
            $address->update($addressData);
        } else {
            Address::create($addressData);
        }

        // Retorno de sucesso ou outra lógica necessária
        return response()->json(['message' => 'Dados de endereço atualizados com sucesso']);
    }
}
