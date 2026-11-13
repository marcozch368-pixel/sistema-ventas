<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Producto extends Model
{
    use HasFactory;
    protected $table = 'productos'; // O el nombre de tu tabla
    protected $guarded = []; // Esto permite guardar todos los campos sin restricciones
} 