<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\SucursalController;
use App\Http\Controllers\UnidadMedidaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('empresas', EmpresaController::class)->except('show');
    Route::resource('sucursales', SucursalController::class)->except('show');
    Route::resource('areas', AreaController::class)->except('show');

    Route::resource('categorias', CategoriaController::class)->except('show')->middleware('permission:categorias.ver');
    Route::resource('unidades-medida', UnidadMedidaController::class)->except('show')->middleware('permission:unidades_medida.ver');
    Route::resource('proveedores', ProveedorController::class)->except('show')->middleware('permission:proveedores.ver');
});

require __DIR__.'/auth.php';
