<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Asegúrate de importar el modelo de usuario si lo estás utilizando
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\HomeController;
use App\Models\enquestadores;

class RegisterController extends Controller
{
    // Método para mostrar el formulario de registro
    public function showRegistrationForm()
    {
        try {
            $homeController = new HomeController();
            // Llama al método mostrarEmpresaSinRedirecion
            $empresas = $homeController->mostrarEmpresaSinRedirecion();

            return view('auth.fortify.register', ['empresas' => $empresas]);// Nombre de la vista del formulario de registro

        } catch(\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => 'Credenciales inválidas'
            ], 500);
        }
    }

    public function register(Request $request)
    {
        try {
            $request->validate([
                'nombre' => 'required|string|max:255',
                'correo' => 'required|string|email|max:255',
                'contrasenya' => 'required|string|min:2',
            ]);

            $usuarios = User::select('correo')
                ->where('correo', $request->correo)
                ->get();

            if ($usuarios->isEmpty()){
                if ($request->enquestador == 'si'){

                    $enquestador = new enquestadores();
                    $enquestador->id_empresa = $request->idEmpresa;
                    $enquestador->localizacion = $request->idEmpresa;
                    $enquestador->save();
                    $nueva_id = $enquestador->id_enquestadores;  


                    User::create([
                        'nombre' => $request->nombre,
                        'correo' => $request->correo,
                        'contrasenya' => $request->contrasenya, 
                        'id_enquestadores' => $nueva_id,
            
                    ]);      
                }
                else{
                    User::create([
                        'nombre' => $request->nombre,
                        'correo' => $request->correo,
                        'contrasenya' => $request->contrasenya, 
                    ]);
                }
            
                // return 'hola';
                return redirect('/login')->with('success', '¡Registro exitoso!');
        
            }
            else{
                return redirect('/register')->with('error', '¡Cuenta utilizada!');
            }       
        } catch(\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => $e
            ], 500);
        }
        
    }

}