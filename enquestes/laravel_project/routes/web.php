<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AuthenticatedSessionController;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aquí es donde puedes registrar las rutas web para tu aplicación. Estas
| rutas son cargadas por RouteServiceProvider y todas serán asignadas al
| grupo de middleware "web". ¡Haz algo grandioso!
|
*/

// Rutas de Fortify
Route::group(['prefix' => config('fortify.routes.prefix')], function () {
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

      // Logout route with POST method for CSRF protection
   //   Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
      Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

});







// Otras rutas
Route::get('/', function () {
    return view('welcome');
});
