<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductosController;

Route::get('/', function () {
    return view('welcome');
});

// Rutas completas para el CRUD de productos
Route::resource('productos', ProductosController::class);