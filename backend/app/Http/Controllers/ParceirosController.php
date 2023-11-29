<?php

namespace App\Http\Controllers;

use App\Models\Parceiros;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class ParceirosController extends Controller
{
    const STATUS_ATIVO = 1;
    const STATUS_INATIVO = 0;
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        $parceiros = Parceiros::where('status', 1)->orderBy('status', 'asc')->get();
        return response()->json($parceiros, 200);
    }

    public function consultar(Request $request)
    {
        $dados = [
            'status' => $request->input('status'),
            'nomeResponsavel' => $request->input('nomeParceiro'),
            'nomeInstituicao' => $request->input('nomeEmpresa'),
            'cpf_cnpj' => $request->input('cpf_cnpj'),
            'email' => $request->input('email'),
        ];
        $parceiro = Parceiros::where(function ($query) use ($dados) {
            if ($dados['status']) {
                $query->where('status', $dados['status']);
            }
        
            if ($dados['nomeResponsavel']) {
                $query->orWhere('nomeResponsavel', 'LIKE', '%' . $dados['nomeResponsavel'] . '%');
            }
        
            if ($dados['nomeInstituicao']) {
                $query->orWhere('nomeInstituicao', 'LIKE', '%' . $dados['nomeInstituicao'] . '%');
            }
        
            if ($dados['cpf_cnpj']) {
                $query->orWhere('cpf_cnpj', $dados['cpf_cnpj']);
            }
        
            if ($dados['email']) {
                $query->orWhere('email', $dados['email']);
            }
        })->get();
        return response()->json($parceiro, 200);
    }

    public function store(Request $request)
    {
        $dados = [
            'uuid' => str::uuid(),
            'nome_instituicao'=> $request->input('nomeInstituicao'),
            'CNPJ'=> $request->input('cnpj'),
            'status'=> self::STATUS_ATIVO,
            'responsavel_legal'=> $request->input('nomeResponsavel'),
            'CPF'=> $request->input('cpf'),
            'telefone'=> $request->input('telefone'),
            'email'=> $request->input('email'),
            'observacao'=> $request->input('observacoes'),
        ];
        $parceiros = Parceiros::create($dados);
        return response()->json($parceiros, 200);
    }

    public function show(string $uuid)
    {
        try {
            $parceiro = Parceiros::where('uuid', $uuid)->firstOrFail();
            return response()->json($parceiro, 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $exception) {
            return response()->json(['message' => 'Parceiro não encontrado'], 404);
        } catch (\Exception $exception) {
            return response()->json(['message' => 'Ocorreu um erro ao buscar o parceiro'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $parceiro = Parceiros::find($id);
        $dados = [
            'nome_instituicao'=> $request->input('nomeInstituicao'),
            'CNPJ'=> $request->input('cnpj'),
            'responsavel_legal'=> $request->input('nomeResponsavel'),
            'CPF'=> $request->input('cpf'),
            'telefone'=> $request->input('telefone'),
            'email'=> $request->input('email'),
            'observacao'=> $request->input('observacoes') ?? null,
        ];
        $parceiro->update($dados);
        return response()->json($parceiro, 200);
    }

    public function destroy(Parceiros $parceiros)
    {
        $parceiros->delete();
        return response()->json(null, 204);
    }
}
