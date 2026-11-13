<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductosController;
Route::get('/', function () {
    return view('welcome');
});
// Rutas completas para el módulo de productos
Route::get('/productos', [ProductosController::class, 'index'])->name('productos.index');
Route::get('/productos/create', [ProductosController::class, 'create'])->name('productos.create');
Route::post('/productos', [ProductosController::class, 'store'])->name('productos.store');
Route::get('/productos/{id}/edit', [ProductosController::class, 'edit'])->name('productos.edit');
Route::get('/productos/obtenerProductos', [ProductosController::class, 'obtenerProductos']);
Route::post('/productos/guardar', [ProductosController::class, 'guardar']);
Route::put('/productos/actualizar/{id}', [ProductosController::class, 'actualizar']);
Route::delete('/productos/{id}', [ProductosController::class, 'destroy'])->name('productos.destroy'); 