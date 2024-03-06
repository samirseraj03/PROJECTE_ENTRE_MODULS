<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\HelloController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InformesController;
use App\Http\Controllers\EnquestaController;
use App\Http\Controllers\DishchargeController;





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
    Route::get('/home', [HomeController::class, 'mostrarEmpresa'])->name('home');


    Route::get('/enquesta', [EnquestaController::class,'getEnquesta']);

});



Route::get('/informes' , [InformesController::class , 'getInformes']);

Route::get('/hello', [HelloController::class, 'index']);

Route::get('/home', [HomeController::class, 'mostrarEmpresa'])->name('home');

Route::get('/get-encuestas-por-empresa/{id_empresa}', [HomeController::class, 'getEncuestasPorEmpresa']);


//Rutas Survey
Route::get('/survey', function () {
    return view('survey');
});

//Rutas discarch
Route::get('/new-company', function () {
    return view('discharge.new-company');
})->name('new_company');

Route::post('/submit-localitzacio', [DishchargeController::class, 'DischargeCompany'])->name('submit-localitzacio');





// Otras rutas
Route::get('/', function () {
    return view('welcome');
});
