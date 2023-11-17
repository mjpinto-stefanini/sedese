<?php

namespace App\Http\Controllers;

use App\Models\Parceiros;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ParceirosController extends Controller
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
        return $request;
    }

    public function show(Parceiros $parceiros)
    {
        //
    }


    public function update(Request $request, Parceiros $parceiros)
    {
        //
    }

    public function destroy(Parceiros $parceiros)
    {
        //
    }
}
