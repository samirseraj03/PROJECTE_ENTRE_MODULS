<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Models\User; // Asegúrate de importar el modelo de usuario si lo estás utilizando
use Illuminate\Support\Facades\Hash;


class LoginController extends Controller
{
    
    /**
     * Show the login form.
     *
     * @return \Illuminate\View\View
     */

    public function showLoginForm()
    {
        try {
             
            return view('auth.fortify.login'); // Asegúrate de tener una vista llamada 'auth.login'

        } catch(\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => 'Credenciales inválidas'
            ], 500);
        }
    }
    
     /**
     * Handle an incoming authentication request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */


     public function login(Request $request)
     {
        try {
            $credentials = $request->validate([
                'correo' => 'required|email',
                'contrasenya' => 'required',
            ]);
        
            // Busca el usuario por correo
            $user = user::where('correo', $credentials['correo'])->first();


            // comprobar el password si esta ben posat o no
            if ($user && password_verify($credentials['contrasenya'], $user->contrasenya)) {

                if ($user->id_enquestadores != null){
                    Auth::login($user); // Inicia sesión en el sistema
                    session(['id_enquestadores' => $user->id_enquestadores]);
                      // Autenticación exitosa
                    return redirect('/home')->with('success', '¡Registro exitoso!');
                }else{
                    Auth::login($user); // Inicia sesión en el sistema
                    return redirect('/home')->with('success', '¡Registro exitoso!');
                }

              
            } else {
                // Autenticación fallida 
                return redirect('/login')->with('error', 'Las credenciales proporcionadas son incorrectas');
          
            }

        } catch(\Exception $e)
        {
            return redirect('/login')->with('error', 'ha pasado algo inesperado');
        }
    }

     /**
     * Handle an incoming logout request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */


     public function logout(Request $request)
     {
        try {
            Auth::logout();
 
            $request->session()->invalidate();
    
            $request->session()->regenerateToken();
    
            return redirect('/');

        } catch(\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => 'Credenciales inválidas'
            ], 500);
        }
     }
}
