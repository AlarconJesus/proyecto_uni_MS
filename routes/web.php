<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SeccionController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\NotaController;
use App\Http\Controllers\CarreraController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\SedeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {
    Route::resource('micuenta', UsuarioController::class);
    Route::resource('estudiantes', UsuarioController::class);
    Route::resource('profesores', ProfesoresController::class);
    Route::resource('materias', MateriaController::class);
    Route::resource('notas', NotaController::class);
    Route::resource('roles', RolController::class);
    Route::resource('carreras', CarreraController::class);
    Route::resource('secciones', SeccionController::class);
    Route::resource('sedes', SedeController::class);
    Route::resource('carreras', CarreraController::class);
});
