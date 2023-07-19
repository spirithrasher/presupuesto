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
Route::get('carga/presupuesto', [App\Http\Controllers\AdministracionController::class, 'cargarpresupuesto'])->name('carga.presupuesto');
Route::post('carga/presupuesto', [App\Http\Controllers\AdministracionController::class, 'cargarpresupuesto'])->name('carga.presupuesto');  
Route::get('listado/carga/presupuesto', [App\Http\Controllers\AdministracionController::class, 'listadocargapresupuesto'])->name('admin.listadocargapresupuesto');    
Route::get('cargar/costos', [App\Http\Controllers\AdministracionController::class, 'cargarcostos'])->name('cargar.costos');
Route::post('cargar/costos', [App\Http\Controllers\AdministracionController::class, 'cargarcostos'])->name('cargar.costos');  
Route::get('listado/empresas', [App\Http\Controllers\AdministracionController::class, 'listadoempresas'])->name('admin.listadoempresas');    
Route::get('nueva/empresa', [App\Http\Controllers\AdministracionController::class, 'nuevaempresa'])->name('admin.nuevaempresa');    
Route::post('nueva/empresa', [App\Http\Controllers\AdministracionController::class, 'nuevaempresa'])->name('admin.nuevaempresa');    
Route::get('editar/empresa/{id}', [App\Http\Controllers\AdministracionController::class, 'editarempresa'])->name('admin.editarempresa');    
Route::post('editar/empresa/{id}', [App\Http\Controllers\AdministracionController::class, 'editarempresa'])->name('admin.editarempresa');    
Route::get('listado/centroscostos', [App\Http\Controllers\AdministracionController::class, 'listadocentroscostos'])->name('admin.listadocentroscostos');    
Route::get('nuevo/centrocosto', [App\Http\Controllers\AdministracionController::class, 'nuevocentrocosto'])->name('admin.nuevocentrocosto');    
Route::post('nuevo/centrocosto', [App\Http\Controllers\AdministracionController::class, 'nuevocentrocosto'])->name('admin.nuevocentrocosto');    
Route::get('editar/centrocosto/{id}', [App\Http\Controllers\AdministracionController::class, 'editarcentrocosto'])->name('admin.editarcentrocosto');    
Route::post('editar/centrocosto/{id}', [App\Http\Controllers\AdministracionController::class, 'editarcentrocosto'])->name('admin.editarcentrocosto');    


Route::get('costosempresa', [App\Http\Controllers\CostosController::class, 'costosempresa'])->name('costosempresa');    
Route::post('costosempresa', [App\Http\Controllers\CostosController::class, 'costosempresa'])->name('costosempresa');    