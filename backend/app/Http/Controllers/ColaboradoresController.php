<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Contact;
use App\Models\Parceiros;
use App\Models\Colaboradores;
use App\Models\UserPerfilStatus;
use App\Models\TipoPerfil;
use App\Http\Controllers\Users as UserController;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

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
            $colaboradoresQuery = Colaboradores::where('parceiros_id', $id)->get();
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
                        $data[$key]['uuid'] = $colaboradoresQuery[$key]['uuid'];
                        $data[$key]['user_id'] = $user->id;
                        $data[$key]['nome'] = $user->name;
                        $data[$key]['cpf'] = $user->cpf;
                        $data[$key]['email'] = $user->email;
                        $data[$key]['status'] = $colaboradoresQuery[$key]['status'];
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
        $userController = new UserController;
        try {
            $parceiro = Parceiros::firstWhere('uuid', (string) $request->parceiro['uuid']);
            if ($parceiro->status !== '1') {
                return response()->json('Não é possivel cadastrar colaboradores com um parceiro inativo.', 200);
            }
        
            $userData = [
                'name' => $request->colaborador['nome'],
                'email' => $request->colaborador['email'],
                'cpf' => $request->colaborador['cpf'],
                'password' => bcrypt(Str::random()), // gerá uma senha que será trocada
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
                // caso um novo usuário foi criado, vamos enviar a senha dele por email
                $userController->sendPasswordByEmail($user->id);
            }
            // cadastra um novo colaborador
            $dadosColaborador = [
                'uuid' => Str::uuid(),
                'parceiros_id' => $request->parceiro['uuid'],
                'user_id' => $user->id,
                'status' => Colaboradores::STATUS_ATIVO,
                'email' => $request->colaborador['email']
            ];
            Colaboradores::create($dadosColaborador);
            return response()->json('Salvo com sucesso', 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Falha ao cadastrar novo Colaborador.'], 500);
        }
    }

    public function show(string $id)
    {
        try {
            $colaborador = Colaboradores::where('uuid', $id)->firstOrFail();
            $user = User::findOrFail($colaborador->user_id);
            return response()->json($user, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return response()->json(['message' => 'Colaborador não encontrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao buscar colaborador'], 500);
        }
    }

    public function checkar(Request $request)
    {
        $dados = [
            'nome' => $request->input('nome'),
            'cpf' => $request->input('cpf'),
            'email' => $request->input('email')
        ];
        $user = User::firstWhere('cpf', $dados['cpf']);
        if (!$user) {
            return null;
        }
        return $this->verificaInstituicoesColaborador($user->id);
    }

    public function verificaInstituicoesColaborador($user_id)
    {
        $data = [];
        $user = User::findOrFail($user_id);
        $colaborador = Colaboradores::where('user_id', $user->id)->get()->toArray();
        foreach($colaborador as $key => $colab):
            $parceiros = Parceiros::where('uuid', $colab['parceiros_id'])->get()->toArray();
            foreach($parceiros as $parca):
                $data[$key] = [
                    'instituicao' => $parca['nome_instituicao'],
                ];
            endforeach;
        endforeach;
        return $data;
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nomeResponsavel' => 'required|string',
            'cpf' => 'required|string',
            'email' => 'required|email',
            'nomeInstituicao' => 'required|string',
            'cnpj' => 'required|string|', // Verifica se o CNPJ é único na tabela de parceiros
            'telefone' => 'required|string',
            'observacoes' => 'nullable|string',
            'mudarResponsavelLegal' => 'nullable|boolean', // Campo adicional para atualizar o responsável legal
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        try {
            $parceiro = Parceiros::where('uuid', $id)->firstOrFail();
            if ($request->has('mudarResponsavelLegal') && $request->input('mudarResponsavelLegal') === true) {
                $user = $this->verificaUsuario($request->input('cpf'), $request->input('email'));

                if (!$user) {
                    // cria novo usuário
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

                    $user = User::create($userData);
                    // criando o status do usuário
                    UserPerfilStatus::create([
                        'user_id' => $user->id,
                        'tipo_perfil_id' => TipoPerfil::COLABORADOR,
                        'status' => 1
                    ]);
                }
                $parceiro->user_id = $user->id;
                $parceiro->save();
            }

            // Atualiza os detalhes do parceiro conforme necessário
            $parceiro->update([
                'nome_instituicao' => $request->input('nomeInstituicao'),
                'CNPJ' => $request->input('cnpj'),
                'observacao' => $request->input('observacao'),
                'phone' => $request->input('telefone')
            ]);

            return response()->json($parceiro, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['error' => 'Parceiro não encontrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocorreu um erro durante a atualização'], 500);
        }
    }

    public function trocarStatus(Request $request)
    {
        $uuid = $request->query('uuid');
        if ($uuid) {
            $colaborador = Colaboradores::firstWhere('uuid', $uuid);
            if ($colaborador) {
                $novoStatus = $colaborador->status == 1 ? 0 : 1;
                $colaborador->status = $novoStatus;
                $colaborador->save();
                return response()->json(['message' => 'Status do colaborador alterado com sucesso'], 200);
            } else {
                return response()->json(['message' => 'Colaborador não encontrado'], 404);
            }
        } else {
            return response()->json(['message' => 'UUID não fornecido'], 400);
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
}
