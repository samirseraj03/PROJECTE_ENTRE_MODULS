<?php

namespace App\Http\Controllers;

use App\Models\empresa;

class WelcomeController extends Controller
{
    public function mostrarEmpresa()
    {
        try {
            $empresas = empresa::all();
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
