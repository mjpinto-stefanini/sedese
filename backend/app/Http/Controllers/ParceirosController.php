<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Contact;
use App\Models\Parceiros;
use App\Models\Colaboradores;
use App\Models\UserPerfilStatus;
use App\Models\TipoPerfil;
use App\Http\Controllers\Users as UserController;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class ParceirosController extends Controller
{
    const STATUS_ATIVO = 1;
    const STATUS_INATIVO = 0;
    public function __construct()
    {
        // $this->middleware('auth:api');
    }

    public function index()
    {
        $data = [];
        $parceiros = Parceiros::where('status', self::STATUS_ATIVO)->orderBy('status', 'asc')->get();
        foreach($parceiros as $key => $parceiro):
            $user = User::findOrFail($parceiro->user_id);
            $data[$key] = [
                'status' => $parceiro->status,
                'nome_instituicao' => $parceiro->nome_instituicao,
                'email' => $user->email,
                'telefone' => $parceiro->phone,
                'id' => $parceiro->id,
                'uuid' => $parceiro->uuid
            ];
        endforeach;
        return response()->json($data, 200);
    }

    public function consultar(Request $request)
    {
        try {
            $dados = [
                'status' => $request->input('status'),
                'nomeResponsavel' => $request->input('nomeParceiro'),
                'nomeInstituicao' => $request->input('nomeEmpresa'),
                'cpf_cnpj' => $request->input('cpf_cnpj'),
                'email' => $request->input('email'),
            ];

            $userQuery = User::query();

            if ($dados['nomeResponsavel']) {
                $userQuery->where('name', $dados['nomeResponsavel']);
            }

            if ($dados['email']) {
                $userQuery->where('email', $dados['email']);
            }

            $users = $userQuery->get();

            $parceiroQuery = Parceiros::query()->with('user');

            if ($dados['status']) {
                $parceiroQuery->where('status', $dados['status']);
            }

            if ($dados['nomeInstituicao']) {
                $parceiroQuery->where('nome_instituicao', $dados['nomeInstituicao']);
            }

            if ($dados['cpf_cnpj']) {
                $cpf_cnpj = $dados['cpf_cnpj'];
                $parceiroQuery->where('cnpj', $cpf_cnpj)->orWhereHas('user', function ($query) use ($cpf_cnpj) {
                    $query->where('cpf', $cpf_cnpj);
                });
            }

            $parceiros = $parceiroQuery->get();

            $data = [];

            foreach ($parceiros as $parceiro) {
                $parceiroData = [
                    'status' => $parceiro->status,
                    'nome_instituicao' => $parceiro->nome_instituicao,
                    'telefones' => $parceiro->phone,
                    'id' => $parceiro->id,
                    'uuid' => $parceiro->uuid,
                    'email' => $parceiro->user ? $parceiro->user->email : null, // Acessando o email do usuário associado ao parceiro
                ];
                $data[] = $parceiroData;
            }

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocorreu um erro durante a consulta'], 500);
        }
    }

    public function store(Request $request)
    {
        $userController = new UserController;
        $validator = Validator::make($request->all(), [
            'nomeResponsavel' => 'required|string',
            'cpf' => 'required|string',
            'email' => 'required|email',
            'nomeInstituicao' => 'required|string',
            'cnpj' => 'required|string|', // Verifica se o CNPJ é único na tabela de parceiros
            'telefone' => 'required|string',
            'observacoes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        try {
            // verifica existencia do usuário
            $user = $this->verificaUsuario($request->input('cpf'), $request->input('email'));
            if (!$user) {
                $dadosResponsavel = [
                    'name'=> $request->input('nomeResponsavel'),
                    'cpf'=> $request->input('cpf'),
                    'email'=> $request->input('email'),
                    'password' => bcrypt(str::random()),
                    'service' => null,
                    'secretary' => null,
                    'type_admin' => USER::USER_USUARIO,
                    'is_active' => 1,
                    'remember_token' => Str::uuid(),
                    'second_stage' => false,
                ];
                $user = User::create($dadosResponsavel);

                UserPerfilStatus::create([
                    'user_id' => $user->id,
                    'tipo_perfil_id' => TipoPerfil::COLABORADOR,
                    'status' => 1
                ]);
                // caso um novo usuário foi criado, vamos enviar a senha dele por email
                $userController->sendPasswordByEmail($user->id);
            }
            // caso não haja usuário existente, ele irá cadastrar um novo usuário
            $existingContact = Contact::where('user_id', $user['id'])->first();
            if (!$existingContact) {
                $contactData = [
                    'user_id' => $user['id'],
                    'phone' => $request->input('telefone'),
                    'cell_phone' => $request->input('telefone'),
                    'cell_phone_whatsapp' => $request->input('telefone'),
                    'institutional_phone' => $request->input('telefone'),
                    'institutional_email' => $request->input('email'),
                    'isWhatsapp' => false,
                ];
                Contact::create($contactData);
            }
            // cadastrando os dados do parceiro
            $dadosParceiro = [
                'uuid' => str::uuid(),
                'nome_instituicao'=> $request->input('nomeInstituicao'),
                'CNPJ'=> $request->input('cnpj'),
                'status'=> self::STATUS_ATIVO,
                'observacao' => $request->input('observacao'),
                'phone' => $request->input('telefone'),
                'user_id' => $user['id']
            ];
            $parceiros = Parceiros::create($dadosParceiro);
            // Salvando responsavel legal na lista de colaborador
            Colaboradores::create([
                'uuid' => Str::uuid(),
                'parceiros_id' => $parceiros->uuid,
                'user_id' => $user->id,
                'status' => Colaboradores::STATUS_ATIVO,
                'email' => $request->input('email'),
            ]);
            
            return response()->json($parceiros, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocorreu um erro durante a criação'], 500);
        }
    }

    public function show(string $uuid)
    {
        try {
            $parceiro = Parceiros::where('uuid', $uuid)->firstOrFail();
            $responsavel = User::firstWhere('id', $parceiro->user_id);
            $contato = Contact::firstWhere('user_id', $parceiro->user_id);
            $dados = [
                'uuid' => $parceiro->uuid,
                'nome_instituicao' => $parceiro->nome_instituicao,
                'cnpj' => $parceiro->cnpj,
                'status' => $parceiro->status,
                'responsavel_legal' => $responsavel->name,
                'cpf' => $responsavel->cpf,
                'email' => $responsavel->email,
                'telefone' => $contato->phone,
                'observacao' => $parceiro->observacao
            ];
            return response()->json($dados, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Parceiro não encontrado'], 404);
        } catch (\Exception $e) {
            throw new \Exception($e);
            return response()->json(['message' => 'Ocorreu um erro ao buscar o parceiro'], 500);
        }
    }

    public function update(Request $request, $uuid)
    {
        $validator = Validator::make($request->all(), [
            'nomeResponsavel' => 'required|string',
            'cpf' => 'required|string',
            'email' => 'required|email',
            'nomeInstituicao' => 'required|string',
            'cnpj' => 'required|string|',
            'telefone' => 'required|string',
            'observacao' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        try {
            $partner = Parceiros::where('uuid', $uuid)->first();

            if (!$partner) {
                return response()->json(['error' => 'Parceiro não encontrado'], 404);
            }

            $user = User::find($partner->responsavel_legal);
            if ($user) {
                $user->update([
                    'name' => $request->input('nomeResponsavel'),
                    'cpf' => $request->input('cpf'),
                    'email' => $request->input('email'),
                ]);
            }

            $contact = Contact::where('user_id', $partner->responsavel_legal)->first();
            if ($contact) {
                $contact->update([
                    'phone' => $request->input('telefone'),
                ]);
            }

            $partner->update([
                'nome_instituicao' => $request->input('nomeInstituicao'),
                'CNPJ' => $request->input('cnpj'),
                'observacao' => $request->input('observacao'),
                'responsavel_legal' => $user->id
            ]);

            return response()->json($partner, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocorreu um erro durante a atualização'], 500);
        }
    }

    public function updateStatus(Request $request) 
    {
        try {
            $parceiro = Parceiros::where('uuid', $request->input('id'))->firstOrFail();
            $newStatus = $request->input('status');
            if ($parceiro->status === $newStatus) {
                return response()->json('O status já está atualizado.', 200);
            }

            // verifica antes o status do parceiro, caso seja desativado ou inativo
            // os colaboradores se manteram inativos
            if ($parceiro->status === 0) {
                Colaboradores::where('parceiros_id', $parceiro->uuid)->update([
                    'status' => 0
                ]);
            }

            // atualiza o status do parceiro
            $parceiro->update([
                'status' => $newStatus
            ]);
            return response()->json('Status alterado com sucesso.', 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Parceiro não encontrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocorreu um erro durante a atualização'], 500);
        }
    }

    public function destroy($id)
    {
        $parceiro = Parceiros::find($id);
        $parceiro->delete();
        return response()->json(null, 204);
    }

    private function verificaUsuario($cpf, $email)
    {
        $user = User::where('cpf', $cpf)->orWhere('email', $email)->first();
        return $user ?? [];
    }
}
