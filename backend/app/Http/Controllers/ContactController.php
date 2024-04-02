<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\User;
use Illuminate\Http\Request;

class ContactController extends Controller
{

    public function __construct()
    {
        // $this->middleware('auth:api');
    }

    public function index()
    {
        $contact = Contact::all();
        return response()->json($contact, self::HTTP_OK);
    }


    public function store(Request $request)
    {
        $request -> validate([
            'user_id' => 'required|integer',
            'phone' => 'required|string|max:255',
            'cell_phone' => 'required|string|max:255',
            'cell_phone_whatsapp' => 'required|string|max:255',
            'institutional_phone' => 'required|string|max:255',
            'institutional_email' => 'required|string|max:255',
            'isWhatsapp' => 'required|boolean',
        ]);

        $contact = Contact::query()->create([
            'user_id' => $request->user_id,
            'phone' => $request->phone,
            'cell_phone' => $request->cell_phone,
            'cell_phone_whatsapp' => $request->cell_phone_whatsapp,
            'institutional_phone' => $request->institutional_phone,
            'institutional_email' => $request->institutional_email,
            'isWhatsapp' => $request->isWhatsapp,
        ]);

        return response()->json($contact, self::HTTP_CREATED);

    }

    public function show($id)
    {
        $contact = Contact::query()->find($id)->first();
        return response()->json($contact, self::HTTP_OK);
    }

    public function update(Request $request, $id)
    {
        $contact = Contact::query()->find($id)->first();

        foreach ($request->all() as $key => $value) {
            $contact->$key = $value;
        }

        $contact->save();

        return response()->json($contact, self::HTTP_OK);
    }

    public function destroy($id)
    {
        $contact = Contact::query()->find($id)->first();
        $contact->delete();
        return response()->json($contact, self::HTTP_OK);
    }

    public function contactUser($user_id)
    {
        $contact = Contact::query()->where('user_id', $user_id)->first();
        return response()->json($contact, self::HTTP_OK);
    }

    public function updateContactDataByUser(Request $request)
    {
        $isWhatsapp = false;
        if ($request['cell_phone_whatsapp'] == 'Sim') {
            $isWhatsapp = true;
        }
        if (isset($request['cell_phone_whatsapp'])) {
            $contactData['cell_phone_whatsapp'] = 'Não';
        }
        $contactData = [
            'user_id' => $request['user_id'],
            'phone' => $request['contact']['phone'] ?? null,
            'cell_phone' => $request['contact']['cell_phone'] ?? null,
            'cell_phone_whatsapp' => $request['contact']['cell_phone_whatsapp'] ?? null,
            'institutional_phone' => $request['contact']['institutional_phone'] ?? null,
            'institutional_email' => $request['contact']['institutional_email'] ?? null,
            'isWhatsapp' => $isWhatsapp ?? null,
        ];
        // Verifica se o registro já existe na tabela Personal
        $contact = Contact::query()->where('user_id', $request['user_id'])->first();

        // Se o registro existir, atualiza os dados; caso contrário, cria um novo registro
        if ($contact) {
            $contact->update($contactData);
            // caso seja necessário fazer a função de enviar email
            // para a pessoa desejada, caso tenha sido alterado
            User::find($contactData['user_id'])->update([
                'email' => $request['email'],
            ]);
        } else {
            Contact::create($contactData);
        }
        // Retorno de sucesso ou outra lógica necessária
        return response()->json(['message' => 'Dados de endereço atualizados com sucesso']);
    }
}
