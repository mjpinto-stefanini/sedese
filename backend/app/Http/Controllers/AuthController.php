<?php

namespace App\Http\Controllers;
use App\Mail\NewPasswordConfirmation;
use App\Mail\RecoverPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use \Illuminate\Http\JsonResponse;
use App\Models\User;
use App\Models\TipoPerfil;
use App\Models\UserPerfilStatus;
use App\Mail\Confirmation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'reset', 'forgot']]);
    }

    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'type' => 'negative',
                'message' => 'Usuário não encontrado. Por favor, verifique o e-email se está correto.'
            ], self::HTTP_METHOD_NOT_ALLOWED);
        }
        if ($user->is_active === 0) {
            return response()->json([
                'status' => 'error',
                'type' => 'negative',
                'message' => 'Seu e-mail não foi confirmado. Verifique a caixa de entrada ou spam, do e-mail cadastrado. Caso não tenha recebido, entre em contato conosco, através do e-mail “dgtep@social.mg.gov.br“.'
            ], self::HTTP_METHOD_NOT_ALLOWED);
        }

        $userPerfilStatus = UserPerfilStatus::where('user_id', $user->id)->first();
        if (!$userPerfilStatus) {
            if ($user->is_active === 0) {
                return response()->json([
                    'status' => 'error',
                    'type' => 'negative',
                    'message' => 'Falha ao verificar seu Perfil. Entre em contato conosco, através do e-mail “dgtep@social.mg.gov.br“.'
                ], self::HTTP_METHOD_NOT_ALLOWED);
            }
        }
        
        if ($userPerfilStatus->status !== UserPerfilStatus::STATUS_ATIVO) {
            return response()->json([
                'status' => 'error',
                'type' => 'negative',
                'message' => 'Seu cadastro está pendente de confirmação. Quando for aprovado, você receberá um e-mail, caso tenha dúvidas, entre em contato, através do e-mail “dgtep@social.mg.gov.br“'
            ], self::HTTP_METHOD_NOT_ALLOWED);
        }

        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'type' => 'negative',
                'message' => 'O Usuário não foi encontrado. Verifique seu email e senha.',
            ], self::HTTP_UNAUTHORIZED);
        }

        $user = Auth::user();
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);

    }

    /**
     * @param $email
     * @param $emailConfirmation
     * @return bool
     */
    public function checkEmail($email, $emailConfirmation): bool
    {

        if ($emailConfirmation == $email) {
            $user = User::query()->where('email', $email)->first();
            if ($user) {
                return false;
            }
            return true;
        }
        return false;
    }

    /**
     * @param $cpf
     * @return bool
     */
    public function checkCPF($cpf): bool
    {
        $user = User::query()->where('cpf', $cpf)->first();
        if ($user) {
            return false;
        }
        return true;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'cpf' => 'required|string|max:20|unique:users',
        ]);

        if (User::where('email', $request->email)->exists()) {
            return $this->errorResponse('O e-mail informado já está cadastrado.');
        }

        if (User::where('cpf', $request->cpf)->exists()) {
            return $this->errorResponse('O CPF informado já está cadastrado.');
        }

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'cpf' => $request->cpf,
            'service' => $request->input('service.value'),
            'secretary' => $request->input('secretary.value'),
            'type_admin' => User::USER_USUARIO,
            'is_active' => 1,
            'remember_token' => Str::uuid(),
            'second_stage' => false,
        ];

        // Obtenha os dados necessários para aplicar as regras
        $ambitoAtuacao = strtolower($request->input('service.label'));
        $lotacaoTipo = strtolower($request->input('secretary.nome'));

        // Defina os perfis com base nas regras
        $perfil = null;
        $participanteList = ['ceas', 'creas regional', 'outros públicos'];
        $respTecnico = ['subsecretaria de assistência social', 'diretoria regional de desenvolvimento social'];

        $perfil = ($ambitoAtuacao === 'estado' && in_array($lotacaoTipo, $respTecnico)) ? TipoPerfil::RESPONSAVEL_TECNICO : (in_array($lotacaoTipo, $participanteList) ? TipoPerfil::PARTICIPANTE : TipoPerfil::PARTICIPANTE);
        $statusPerfil = ($perfil === TipoPerfil::PARTICIPANTE) ? UserPerfilStatus::STATUS_ATIVO : UserPerfilStatus::STATUS_PENDENTE;
        $user = User::create($userData);
        // criando o tipo de usuário por perfil deixando ele ativo
        UserPerfilStatus::create([
            'user_id' => $user->id,
            'tipo_perfil_id' => $perfil,
            'status'  => $statusPerfil,
        ]);

        $token = Auth::login($user);

        return response()->json([
            'status' => 'success',
            'message' => 'Usuário cadastrado com sucesso',
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    /**
     * @return JsonResponse
     */
    private function errorResponse($message): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'type' => 'negative',
            'message' => $message,
        ], self::HTTP_NOT_ACCEPTABLE);
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ], self::HTTP_OK);
    }

    /**
     * @return JsonResponse
     */
    public function refresh(): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorization' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function forgot(Request $request): JsonResponse
    {
        if(!$request['email'] && !$request['cpf']){
            return response()->json([
                'status' => 'error',
                'type' => 'negative',
                'message' => 'Informe o email ou o CPF.',
            ], self::HTTP_NOT_ACCEPTABLE);
        }

        $user = User::query()->where('cpf', $request['cpf'])->first();

        if ($request['email']) {
            $user = User::query()->where('email', $request['email'])->first();
        }

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'type' => 'negative',
                'message' => 'O Email ou CPF não foi encontrado. Por favor, verifique',
            ], self::HTTP_NOT_FOUND);
        }

        $rememberToken = Str::uuid();
        $user->remember_token = $rememberToken;
        $user->save();

        try {

            $mailData = [
                'name' => $user['name'],
                'email' => $user['email'],
                'cpf' => $user['cpf'],
                'token' => $rememberToken,
            ];

            Mail::to($user['email'])->send(new RecoverPassword($mailData));

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'type' => 'negative',
                'message' => 'Erro ao enviar e-mail de recuperação de senha. ' . $e->getMessage(),
            ], self::HTTP_REQUEST_TIMEOUT);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Em instantes você receberá um email com link para gerar uma nova senha. Obrigado.',
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function reset(Request $request): JsonResponse
    {

        if (!$request['token']) {
            return response()->json([
                'status' => 'error',
                'type' => 'negative',
                'message' => 'Informe o token.',
            ], self::HTTP_NOT_ACCEPTABLE);
        }

        if (!$request['password']) {
            return response()->json([
                'status' => 'error',
                'type' => 'negative',
                'message' => 'Informe a senha.',
            ], self::HTTP_NOT_ACCEPTABLE);
        }

        if (!$request['confirmPassword']) {
            return response()->json([
                'status' => 'error',
                'type' => 'negative',
                'message' => 'Informe a confirmação da senha.',
            ], self::HTTP_NOT_ACCEPTABLE);
        }

        if ($request['password'] != $request['confirmPassword']) {
            return response()->json([
                'status' => 'error',
                'type' => 'negative',
                'message' => 'As senhas não conferem.',
            ], self::HTTP_NOT_ACCEPTABLE);
        }

        $user = User::query()->where('remember_token', $request['token'])->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'type' => 'negative',
                'message' => 'Token inválido.',
            ], self::HTTP_NOT_FOUND);
        }

        $user->password = bcrypt($request['password']);
        $user->remember_token = null;
        $user->save();

        try {

            $mailData = [
                'name' => $user['name'],
                'email' => $user['email'],
            ];

            Mail::to($user['email'])->send(new NewPasswordConfirmation($mailData));

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'type' => 'negative',
                'message' => 'Erro ao enviar e-mail de confirmação de senha. ' . $e->getMessage(),
            ], self::HTTP_REQUEST_TIMEOUT);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Senha alterada com sucesso.',
            'temp' => $user->password
        ]);

    }
}
