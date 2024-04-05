<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HelloController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EnquestaController;
use App\Mail\MyEmail;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::get('/hello', [HelloController::class, 'index']);
Route::get('/home', [HomeController::class, 'mostrarEmpresa']);
Route::get('/enquesta', [EnquestaController::class,'mostrarEnquesta'])->name('enquesta');


// apis 
Route::get('/enquestas', [EnquestaController::class,'GetALLEnquestas'])->name('enquesta');

Route::get('/enquestas/{id}', [HomeController::class,'getEncuestasPorEmpresaWithid']);

Route::get('/enquestas/{id}/{preguntas}', [HomeController::class,'getEncuestasPorEmpresaWithid']);

/*
//Email: Es temporal, per realitzar proves :D
Route::get('/testroute', function(){
    $name = "Sample";
    Mail::to('sergi200000000@gmail.com')->send(new MyEmail($name));
});
*/
//Email: Es temporal, per realitzar proves :D
Route::get('/testroute/{correu}', function(Request $request , $correu){
    $name = "Sample";
    Mail::to($correu)->send(new MyEmail($name, "Registre exitos"));
});