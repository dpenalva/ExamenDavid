<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Este método crea la tabla 'zapatos' en la base de datos
     * con todos los campos necesarios para almacenar la información de los zapatos.
     */
    public function up(): void
    {
        Schema::create('zapatos', function (Blueprint $table) {
            $table->id();                           // Campo ID autoincremental (clave primaria)
            $table->string('nombre');               // Nombre del zapato (VARCHAR)
            $table->string('marca');                // Marca del zapato (VARCHAR)
            $table->string('talla');                // Talla del zapato (VARCHAR para admitir formatos como '42', '42.5', 'XL', etc.)
            $table->string('color');                // Color del zapato (VARCHAR)
            $table->decimal('precio', 8, 2);        // Precio con 8 dígitos en total y 2 decimales
            $table->integer('stock')->default(0);   // Cantidad en stock (entero), por defecto 0
            $table->timestamps();                   // Crea los campos created_at y updated_at automáticamente
        });
    }

    /**
     * Reverse the migrations.
     * 
     * Este método revierte la migración eliminando la tabla 'zapatos'.
     * Se usa cuando ejecutamos un rollback de migraciones.
     */
    public function down(): void
    {
        Schema::dropIfExists('zapatos');
    }
};
