<?php

namespace App\Http\Controllers;

use App\Models\Colaboradores;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ColaboradoresController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Colaboradores $colaboradores)
    {
        //
    }


    public function update(Request $request, Colaboradores $colaboradores)
    {
        //
    }

    public function destroy(Colaboradores $colaboradores)
    {
        //
    }
}
