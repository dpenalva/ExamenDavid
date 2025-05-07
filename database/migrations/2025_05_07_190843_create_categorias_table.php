<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Este método crea la tabla 'categorias' en la base de datos
     * con los campos necesarios para almacenar información sobre las categorías de zapatos.
     */
    public function up(): void
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();                           // Campo ID autoincremental (clave primaria)
            $table->string('nombre');               // Nombre de la categoría (VARCHAR, ej. "Deportivos")
            $table->text('descripcion')->nullable(); // Descripción de la categoría (TEXT, puede ser null)
            $table->timestamps();                   // Crea los campos created_at y updated_at automáticamente
        });
    }

    /**
     * Reverse the migrations.
     * 
     * Este método revierte la migración eliminando la tabla 'categorias'.
     * Se usa cuando ejecutamos un rollback de migraciones.
     */
    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};
