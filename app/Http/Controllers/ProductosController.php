<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class ProductosController extends Controller
{
    // Vista principal que carga la tabla
    public function index()
    {
        $productos = Producto::all();
        return view('productos.index', compact('productos'));
    }

    // Vista para crear
    public function create()
    {
        return view('productos.create');
    }

    // Método store adaptado para recibir el formulario por AJAX y validar correctamente
    public function store(Request $request)
    {
        $request->validate([
            'producto' => 'required',
            'categoria' => 'required', // Coincide con el input 'categoria' del formulario
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        Producto::create($request->all());

        return response()->json(['mensaje' => 'Producto creado con éxito']);
    }

    // Vista para editar un registro específico
    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        return view('productos.edit', compact('producto'));
    }

    // Método AJAX para obtener todos los productos en JSON
    public function obtenerProductos()
    {
        $productos = Producto::all();
        return response()->json(['productos' => $productos]);
    }

    // Método AJAX para guardar (por compatibilidad)
    public function guardar(Request $request)
    {
        return $this->store($request);
    }

    // Método AJAX para actualizar un producto existente
    public function actualizar(Request $request, $id)
    {
        $request->validate([
            'producto' => 'required',
            'categoria' => 'required',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        $producto = Producto::findOrFail($id);
        $producto->update($request->all());

        return response()->json(['mensaje' => 'Producto actualizado con éxito']);
    }

    // Método AJAX para eliminar un producto
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();

        return response()->json(['mensaje' => 'Producto eliminado con éxito']);
    }
}