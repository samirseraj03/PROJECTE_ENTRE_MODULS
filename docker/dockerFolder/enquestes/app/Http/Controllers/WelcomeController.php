<?php

namespace App\Http\Controllers;

use App\Models\Empresa;

class WelcomeController extends Controller
{
    public function mostrarEmpresa()
    {
        try {
            $empresas = Empresa::all();
            return view('welcome', compact('empresas'));

        } catch(\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => 'Error en mostrar la Empresa'
            ], 500);
        }
    }

   
}
