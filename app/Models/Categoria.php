<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    use HasFactory;
    
    /**
     * Los atributos que son asignables masivamente.
     * Sólo estos campos pueden ser llenados con create() o fill()
     * Es una medida de seguridad contra mass assignment
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',       // Nombre de la categoría (ej. "Deportivos", "Casuales", "Formales")
        'descripcion',  // Descripción opcional de la categoría
    ];

    /**
     * Obtiene los zapatos relacionados con esta categoría.
     * Esta es una relación de uno a muchos (one-to-many):
     * Una categoría puede tener muchos zapatos relacionados
     * 
     * Esto permite usar $categoria->zapatos para obtener todos los zapatos de esta categoría
     */
    public function zapatos()
    {
        // hasMany establece que esta categoría puede tener múltiples zapatos
        // El primer parámetro es la clase del modelo relacionado (Zapato)
        return $this->hasMany(Zapato::class);
    }
} 