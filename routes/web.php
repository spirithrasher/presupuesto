<?php

use Illuminate\Support\Facades\Route;

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
    return view('auth/login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('admin/listado/users', [App\Http\Controllers\AdministracionController::class, 'listadousers'])->name('admin.listado.users');
Route::get('admin/registrar/user', [App\Http\Controllers\AdministracionController::class, 'registrarusers'])->name('admin.registrar.user');
Route::post('admin/registrar/user', [App\Http\Controllers\AdministracionController::class, 'registrarusers'])->name('admin.registrar.user');
Route::get('admin/editar/user/{id}', [App\Http\Controllers\AdministracionController::class, 'editaruser'])->name('admin.editar.user');
Route::post('admin/editar/user/{id}', [App\Http\Controllers\AdministracionController::class, 'editaruser'])->name('admin.editar.user');


