<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MovimientoInventarioController;
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
    Route::resource('items', ItemController::class);

    Route::prefix('movimientos')->name('movimientos.')->middleware('permission:movimientos.ver')->group(function () {
        Route::get('/', [MovimientoInventarioController::class, 'index'])->name('index');
        Route::get('/entrada', [MovimientoInventarioController::class, 'entrada'])->name('entrada');
        Route::post('/entrada', [MovimientoInventarioController::class, 'guardarEntrada'])->name('entrada.store');
        Route::get('/salida', [MovimientoInventarioController::class, 'salida'])->name('salida');
        Route::post('/salida', [MovimientoInventarioController::class, 'guardarSalida'])->name('salida.store');
        Route::get('/traslado', [MovimientoInventarioController::class, 'traslado'])->name('traslado');
        Route::post('/traslado', [MovimientoInventarioController::class, 'guardarTraslado'])->name('traslado.store');
        Route::get('/ajuste', [MovimientoInventarioController::class, 'ajuste'])->name('ajuste');
        Route::post('/ajuste', [MovimientoInventarioController::class, 'guardarAjuste'])->name('ajuste.store');
        Route::get('/stock-por-area/{area}', [MovimientoInventarioController::class, 'stockPorArea'])->name('stock-por-area');
    });
});

require __DIR__.'/auth.php';
