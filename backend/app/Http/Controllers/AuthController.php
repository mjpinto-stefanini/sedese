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

        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'type' => 'negative',
                'message' => 'O Usuário não foi encontrado. Verifique seu email e senha.',
            ], self::HTTP_UNAUTHORIZED);
        }

        $isActivated = User::where('email', $request->email)->first()->is_active;
        if ($isActivated == 0) {
            return response()->json([
                'status' => 'error',
                'type' => 'negative',
                'message' => 'Sua conta ainda não foi ativada, verifique seu e-mail.'
            ], self::HTTP_METHOD_NOT_ALLOWED);
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

    /*
    {
        "secretary":{
            "id":"f56fac17-ee1e-4adf-aa03-1c030073687e",
            "nome":"CREAS Regional",
            "regiao_administrativa":"1",
            "ativo":1,
            "outro":0,
            "outro_nome":null,
            "created_at":"2023-02-02T00:06:23.000000Z",
            "updated_at":"2023-02-02T00:06:23.000000Z",
            "label":"CREAS Regional",
            "value":"f56fac17-ee1e-4adf-aa03-1c030073687e"
        },
        "service":{
            "label":"Estado",
            "value":1
        },
        "name":"Andre Abreu Quarenta e Nove",
        "email":"andre.abreu+49@gmail.com",
        "email_confirmation":"andre.abreu+49@gmail.com",
        "password":"1q2w3e4r",
        "cpf":"123.456.789-49"
    }
     */

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'cpf' => 'required|string|max:255|unique:users',
        ]);

        $service = null;
        $isActive = 1;
        $secretary = null;
        if (isset($request->service['value'])) {
            $service = $request->service['value'];
        }
        if (isset($request->secretary['value'])) {
            $secretary = $request->secretary['value'];
        }

        if (!$this->checkEmail($request->email, $request->email_confirmation)) {
            return response()->json([
                'status' => 'error',
                'type' => 'negative',
                'message' => 'O e-mail informado já está cadastrado.',
            ], self::HTTP_NOT_ACCEPTABLE);
        }

        if (!$this->checkCPF($request->cpf)) {
            return response()->json([
                'status' => 'error',
                'type' => 'negative',
                'message' => 'O CPF informado já está cadastrado.',
            ], self::HTTP_NOT_ACCEPTABLE);
        }

        $rememberToken = Str::uuid();
        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'cpf' => $request->cpf,
            'service' => $service,
            'secretary' => $secretary,
            'type_admin' => User::USER_USUARIO,
            'is_active' => $isActive,
            'remember_token' => $rememberToken
        ];

        $user = User::query()->create($userData);

        $token = Auth::login($user);

        try {

            $mailData = [
                'name' => $user['name'],
                'email' => $user['email'],
                'token' => $rememberToken,
            ];

            Mail::to($user['email'])->send(new Confirmation($mailData));

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'type' => 'negative',
                'message' => 'Erro ao enviar e-mail de confirmação. ' . $e->getMessage(),
            ], self::HTTP_REQUEST_TIMEOUT);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
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

        $user->password = Hash::make($request['password']);
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
