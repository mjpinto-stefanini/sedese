<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Contact;
use App\Models\Parceiros;
use App\Models\Colaboradores;
use App\Models\UserPerfilStatus;
use App\Models\TipoPerfil;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ColaboradoresController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        if (!$request->has('id')) {
            return response()->json(['message' => 'Erro ao buscar colaboradores e seus status'], 500);
        }
        $id = $request->input('id');
        $cpf = $request->input('cpf');
        $nome = $request->input('nome');

        try {
            $colaboradoresQuery = Colaboradores::where('parceiros_id', $id);
            $colaboradores = $colaboradoresQuery->pluck('user_id');
            $userIds = $colaboradores->toArray();
            $query = User::whereIn('id', $userIds);
            if ($cpf) {
                $query->where('cpf', $cpf);
            }

            if ($nome) {
                $query->where('name', 'like', "%$nome%");
            }

            $users = $query->get();

            $status = UserPerfilStatus::whereIn('user_id', $userIds)->get();
            $data = [];
            foreach ($users as $key => $user) {
                foreach ($status as $userStatus) {
                    if ($user->id === $userStatus->user_id) {
                        $data[$key]['user_id'] = $user->id;
                        $data[$key]['nome'] = $user->name;
                        $data[$key]['cpf'] = $user->cpf;
                        $data[$key]['email'] = $user->email;
                        $data[$key]['status'] = $userStatus->status;
                        break;
                    }
                }
            }
            return response()->json($data, 200);
        } catch (\Exception $exception) {
            return response()->json(['message' => 'Erro ao buscar colaboradores e seus status'], 500);
        }
    }

    public function store(Request $request)
    {
        $parceiro = Parceiros::where('uuid', $request->parceiro['uuid']);
        if ($parceiro->status !== 1) {
            return response()->json('Não é possivel cadastrar colaboradores com um parceiro inativo.', 200);
        }
    
        $userData = [
            'name' => $request->colaborador['nome'],
            'email' => $request->colaborador['email'],
            'cpf' => $request->colaborador['cpf'],
            'password' => bcrypt('qwe123'),
            'service' => null,
            'secretary' => null,
            'type_admin' => USER::USER_USUARIO,
            'is_active' => 1,
            'remember_token' => Str::uuid(),
            'second_stage' => false,
        ];

        $user = User::firstWhere('email', $userData['email']);
        if (!$user) {
            // cria novo usuário
            $user = User::create($userData);
            // criando o status do usuário
            UserPerfilStatus::create([
                'user_id' => $user->id,
                'tipo_perfil_id' => TipoPerfil::COLABORADOR,
                'status' => 1
            ]);
        }
        // cadastra um novo colaborador
        $dadosColaborador = [
            'uuid' => Str::uuid(),
            'parceiros_id' => $request->parceiro['uuid'],
            'user_id' => $user->id,
        ];
        Colaboradores::create($dadosColaborador);
        return response()->json('Salvo com sucesso', 200);
    }

    public function show(string $id)
    {
        try {
            $colaborador = Colaboradores::where('uuid', $id)->firstOrFail();
            $user = User::findOrFail($colaborador->user_id);
            return response()->json($user, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return response()->json(['message' => 'Colaborador não encontrado'], 404);
        } catch (\Exception $exception) {
            return response()->json(['message' => 'Erro ao buscar colaborador'], 500);
        }
    }

    public function update(Request $request, string $id)
    {
        try {
            $colaborador = Colaboradores::where('uuid', $id)->firstOrFail();
            $user = User::findOrFail($colaborador->user_id);

            $userData = [
                'name' => $request->colaborador['nome'],
                'email' => $request->colaborador['email'],
                'cpf' => $request->colaborador['cpf'],
            ];
            $user->update($userData);
            return response()->json('Atualizado com sucesso', 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return response()->json(['message' => 'Colaborador não encontrado'], 404);
        } catch (\Exception $exception) {
            return response()->json(['message' => 'Erro ao atualizar colaborador'], 500);
        }
    }

    public function destroy(string $id)
    {
        try {
            $colaborador = Colaboradores::where('uuid', $id)->firstOrFail();
            $user = User::findOrFail($colaborador->user_id);
            $user->delete();
            return response()->json('Colaborador excluído com sucesso', 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return response()->json(['message' => 'Colaborador não encontrado'], 404);
        } catch (\Exception $exception) {
            return response()->json(['message' => 'Erro ao excluir colaborador'], 500);
        }
    }

    private function verificaInstituicoesColaborador($user_id)
    {
        return Colaboradores::where('user_id', $user_id)->get()->toArray();
    }
}
