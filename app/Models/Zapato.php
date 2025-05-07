<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zapato extends Model
{
    use HasFactory;
    
    /**
     * Los atributos que son asignables masivamente.
     * Esto es importante porque define qué campos se pueden llenar con el método create() o fill()
     * Si un campo no está aquí, no se podrá asignar masivamente (protección contra mass assignment)
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',        // El nombre del zapato (ej. "Air Max")
        'marca',         // La marca del zapato (ej. "Nike")
        'talla',         // La talla del zapato (ej. "42")
        'color',         // El color del zapato (ej. "Negro")
        'precio',        // El precio en euros (ej. 99.99)
        'stock',         // Cantidad disponible (ej. 10)
        'categoria_id',  // Clave foránea que relaciona con la tabla categorias
    ];

    /**
     * Obtiene la categoría a la que pertenece el zapato.
     * Esta es una relación de muchos a uno (many-to-one):
     * Muchos zapatos pueden pertenecer a una misma categoría
     * 
     * Esto permite usar $zapato->categoria para acceder a la categoría relacionada
     */
    public function categoria()
    {
        // belongsTo establece una relación inversa con el modelo Categoria
        // El primer parámetro es la clase del modelo relacionado
        return $this->belongsTo(Categoria::class);
    }
}
