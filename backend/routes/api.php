<?php

use App\Http\Controllers\AmbitoAtuacaoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Users;
use App\Http\Controllers\DeficienciaController;
use App\Http\Controllers\EscolaridadeController;
use App\Http\Controllers\ProfissaoController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\RespresentationController;
use App\Http\Controllers\TodoController;
use App\Http\Controllers\ProfessionalController;
use App\Http\Controllers\RegionalController;
use App\Http\Controllers\SuperintendenciaController;
use App\Http\Controllers\AcoesController;
use App\Http\Controllers\AcoesAreaEnvolvidaController;
use App\Http\Controllers\AcoesTematicaController;
use App\Http\Controllers\AcoesTipologiaController;
use App\Http\Controllers\TurmaController;
use App\Http\Controllers\TurmaEnderecoController;
use App\Http\Controllers\TurmaPolosController;
use App\Http\Controllers\TurmaPolosMunicipiosController;
use App\Http\Controllers\ParceirosController;
use App\Http\Controllers\ColaboradoresController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {
    Route::get('/', function () {
        return response()->json([
            'status' => 'success',
            'message' => 'Welcome to SISCAP API',
        ]);
    });

    Route::prefix('users')->group(function () {
        Route::get('/', [Users::class, 'list']);
        Route::get('/{id}/user', [Users::class, 'get']);
        Route::get('/confirm-email/{token}', [Users::class, 'confirmEmail']);
        Route::patch('/{id}/user', [Users::class, 'updateuser']);
        Route::patch('/{id}/secondstage', [Users::class, 'secondStage']);
        Route::get('/reset-password/{id}', [Users::class, 'sendPasswordByEmail']);
        Route::post('/change-status', [Users::class, 'changeStatus']);
        Route::post('/change-perfil', [Users::class, 'changePerfil']);
        Route::post('/change-admin', [Users::class, 'changeAdmin']);
    });

    Route::prefix('auth')->group(function () {
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::post('/forgot', [AuthController::class, 'forgot']);
        Route::post('/reset', [AuthController::class, 'reset']);
    });

    Route::prefix('ambitoatuacao')->group(function () {
        Route::get('/', [AmbitoAtuacaoController::class, 'index']);
        Route::get('/regiaoadm/{id}', [AmbitoAtuacaoController::class, 'ShowRegiaoAdministrativa']);
        Route::post('/store', [AmbitoAtuacaoController::class, 'store']);
        Route::get('/show/{id}', [AmbitoAtuacaoController::class, 'show']);
        Route::put('/update/{id}', [AmbitoAtuacaoController::class, 'update']);
        Route::delete('/destroy/{id}', [AmbitoAtuacaoController::class, 'destroy']);
    });

    Route::prefix('escolaridade')->group(function () {
        Route::get('/', [EscolaridadeController::class, 'index']);
        Route::post('/store', [EscolaridadeController::class, 'store']);
        Route::get('/show/{id}', [EscolaridadeController::class, 'show']);
        Route::put('/update/{id}', [EscolaridadeController::class, 'update']);
        Route::delete('/destroy/{id}', [EscolaridadeController::class, 'destroy']);
    });

    Route::prefix('profissao')->group(function () {
        Route::get('/', [ProfissaoController::class, 'index']);
        Route::post('/store', [ProfissaoController::class, 'store']);
        Route::get('/show/{id}', [ProfissaoController::class, 'show']);
        Route::put('/update/{id}', [ProfissaoController::class, 'update']);
        Route::delete('/destroy/{id}', [ProfissaoController::class, 'destroy']);
    });

    Route::prefix('deficiencia')->group(function () {
        Route::get('/', [DeficienciaController::class, 'index']);
        Route::post('/store', [DeficienciaController::class, 'store']);
        Route::get('/show/{id}', [DeficienciaController::class, 'show']);
        Route::put('/update/{id}', [DeficienciaController::class, 'update']);
        Route::delete('/destroy/{id}', [DeficienciaController::class, 'destroy']);
    });

    Route::prefix('personal')->group(function () {
        Route::get('/', [PersonalController::class, 'index']);
        Route::post('/store', [PersonalController::class, 'store']);
        Route::get('/show/{id}', [PersonalController::class, 'show']);
        Route::put('/update/{id}', [PersonalController::class, 'update']);
        Route::delete('/destroy/{id}', [PersonalController::class, 'destroy']);
        Route::get('/{id}/user', [PersonalController::class, 'personalUser']);
        Route::post('/updatebyuser', [PersonalController::class, 'updatePersonalDataByUser']);
    });

    Route::prefix('address')->group(function () {
        Route::get('/', [AddressController::class, 'index']);
        Route::post('/store', [AddressController::class, 'store']);
        Route::get('/show/{id}', [AddressController::class, 'show']);
        Route::put('/update/{id}', [AddressController::class, 'update']);
        Route::delete('/destroy/{id}', [AddressController::class, 'destroy']);
        Route::get('/{id}/user', [AddressController::class, 'addressUser']);
        Route::post('/updatebyuser',[AddressController::class, 'updateAddressDataByUser']);
    });

    Route::prefix('contact')->group(function () {
        Route::get('/', [ContactController::class, 'index']);
        Route::post('/store', [ContactController::class, 'store']);
        Route::get('/show/{id}', [ContactController::class, 'show']);
        Route::put('/update/{id}', [ContactController::class, 'update']);
        Route::delete('/destroy/{id}', [ContactController::class, 'destroy']);
        Route::get('/{id}/user', [ContactController::class, 'contactUser']);
        Route::post('/updatebyuser', [ContactController::class, 'updateContactDataByUser']);
    });

    Route::prefix('respresentation')->group(function () {
        Route::get('/', [RespresentationController::class, 'index']);
        Route::post('/store', [RespresentationController::class, 'store']);
        Route::get('/show/{id}', [RespresentationController::class, 'show']);
        Route::put('/update/{id}', [RespresentationController::class, 'update']);
        Route::delete('/destroy/{id}', [RespresentationController::class, 'destroy']);
    });

    Route::prefix('regionals')->group(function () {
        Route::get('/', [RegionalController::class, 'index']);
        Route::post('/store', [RegionalController::class, 'store']);
        Route::get('/show/{id}', [RegionalController::class, 'show']);
        Route::put('/update/{id}', [RegionalController::class, 'update']);
        Route::delete('/destroy/{id}', [RegionalController::class, 'destroy']);
    });

    Route::prefix('superintendencia')->group(function () {
        Route::get('/', [SuperintendenciaController::class, 'index']);
        Route::post('/store', [SuperintendenciaController::class, 'store']);
        Route::get('/show/{id}', [SuperintendenciaController::class, 'show']);
        Route::put('/update/{id}', [SuperintendenciaController::class, 'update']);
        Route::delete('/destroy/{id}', [SuperintendenciaController::class, 'destroy']);
    });

    Route::prefix('professionals')->group(function () {
        Route::get('/', [ProfessionalController::class, 'index']);
        Route::post('/store', [ProfessionalController::class, 'store']);
        Route::get('/show/{id}', [ProfessionalController::class, 'show']);
        Route::put('/update/{id}', [ProfessionalController::class, 'update']);
        Route::delete('/destroy/{id}', [ProfessionalController::class, 'destroy']);
        Route::get('/{id}/user', [ProfessionalController::class, 'professionalsUser']);
        Route::post('/updatebyuser', [ProfessionalController::class, 'updateProfessionalDataByUser']);
    });

    Route::prefix('acoes')->group(function () {
        Route::get('/', [AcoesController::class, 'index']);
        Route::post('/store', [AcoesController::class, 'store']);
        Route::get('/show/{id}', [AcoesController::class, 'show']);
        Route::put('/update/{id}', [AcoesController::class, 'update']);
        Route::delete('/destroy/{id}', [AcoesController::class, 'destroy']);
    });

    Route::prefix('tematicas')->group(function () {
        Route::get('/', [AcoesTematicaController::class, 'index']);
        Route::post('/store', [AcoesTematicaController::class, 'store']);
        Route::get('/show/{id}', [AcoesTematicaController::class, 'show']);
        Route::put('/update/{id}', [AcoesTematicaController::class, 'update']);
        Route::delete('/destroy/{id}', [AcoesTematicaController::class, 'destroy']);
    });

    Route::prefix('tipologias')->group(function () {
        Route::get('/', [AcoesTipologiaController::class, 'index']);
        Route::post('/store', [AcoesTipologiaController::class, 'store']);
        Route::get('/show/{id}', [AcoesTipologiaController::class, 'show']);
        Route::put('/update/{id}', [AcoesTipologiaController::class, 'update']);
        Route::delete('/destroy/{id}', [AcoesTipologiaController::class, 'destroy']);
    });

    Route::prefix('areaenvolvida')->group(function () {
        Route::get('/', [AcoesAreaEnvolvidaController::class, 'index']);
        Route::post('/store', [AcoesAreaEnvolvidaController::class, 'store']);
        Route::get('/show/{id}', [AcoesTipologiaController::class, 'show']);
        Route::put('/update/{id}', [AcoesAreaEnvolvidaController::class, 'update']);
        Route::delete('/destroy/{id}', [AcoesAreaEnvolvidaController::class, 'destroy']);
    });

    Route::prefix('turma')->group(function () {
        Route::get('/', [TurmaController::class, 'index']);
        Route::post('/store', [TurmaController::class, 'store']);
        Route::get('/show/{id}', [TurmaController::class, 'show']);
        Route::put('/update/{id}', [TurmaController::class, 'update']);
        Route::delete('/destroy/{id}', [TurmaController::class, 'destroy']);
    });

    Route::prefix('polos')->group(function () {
        Route::get('/', [TurmaPolosController::class, 'index']);
        Route::post('/store', [TurmaPolosController::class, 'store']);
        Route::get('/show/{id}', [TurmaPolosController::class, 'show']);
        Route::put('/update/{id}', [TurmaPolosController::class, 'update']);
        Route::delete('/destroy/{id}', [TurmaPolosController::class, 'destroy']);
    });

    Route::prefix('enderecos')->group(function () {
        Route::get('/', [TurmaEnderecoController::class, 'index']);
        Route::post('/store', [TurmaEnderecoController::class, 'store']);
        Route::get('/show/{id}', [TurmaEnderecoController::class, 'show']);
        Route::put('/update/{id}', [TurmaEnderecoController::class, 'update']);
        Route::delete('/destroy/{id}', [TurmaEnderecoController::class, 'destroy']);
    });

    Route::prefix('polosmunicipios')->group(function () {
        Route::get('/', [TurmaPolosMunicipiosController::class, 'index']);
        Route::post('/store', [TurmaPolosMunicipiosController::class, 'store']);
        Route::get('/show/{id}', [TurmaPolosMunicipiosController::class, 'show']);
        Route::put('/update/{id}', [TurmaPolosMunicipiosController::class, 'update']);
        Route::delete('/destroy/{id}', [TurmaPolosMunicipiosController::class, 'destroy']);
    });

    Route::prefix('parceiros')->group(function () {
        Route::get('/', [ParceirosController::class, 'index']);
        Route::post('/store', [ParceirosController::class, 'store']);
        Route::get('/show/{id}', [ParceirosController::class, 'show']);
        Route::get('consultar', [ParceirosController::class, 'consultar']);
        Route::put('/update/{id}', [ParceirosController::class, 'update']);
        Route::post('/updateStatus', [ParceirosController::class, 'updateStatus']);
        Route::delete('/destroy/{id}', [ParceirosController::class, 'destroy']);
    });

    Route::prefix('colaboradores')->group(function () {
        Route::get('/', [ColaboradoresController::class, 'index']);
        Route::post('/store', [ColaboradoresController::class, 'store']);
        Route::get('/show/{id}', [ColaboradoresController::class, 'show']);
        Route::put('/update/{id}', [ColaboradoresController::class, 'update']);
        Route::get('/checkar', [ColaboradoresController::class, 'checkar']);
        Route::delete('/destroy/{id}', [ColaboradoresController::class, 'destroy']);
        Route::get('/trocarStatus', [ColaboradoresController::class, 'trocarStatus']);
    });

});
