<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Este método añade el campo 'categoria_id' a la tabla 'zapatos'
     * para establecer la relación con la tabla 'categorias'.
     * 
     * Se ejecuta después de crear ambas tablas (zapatos y categorias).
     */
    public function up(): void
    {
        Schema::table('zapatos', function (Blueprint $table) {
            // Añadimos la clave foránea categoria_id con estas propiedades:
            // - nullable(): Puede ser NULL (un zapato puede no tener categoría)
            // - constrained('categorias'): Referencia a la tabla categorias
            // - onDelete('set null'): Si se elimina una categoría, se establece a NULL en los zapatos
            $table->foreignId('categoria_id')->nullable()->constrained('categorias')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     * 
     * Este método elimina la relación y el campo 'categoria_id' de la tabla 'zapatos'.
     * Se ejecuta cuando se hace rollback de la migración.
     */
    public function down(): void
    {
        Schema::table('zapatos', function (Blueprint $table) {
            $table->dropForeign(['categoria_id']);  // Elimina la restricción de clave foránea
            $table->dropColumn('categoria_id');     // Elimina la columna
        });
    }
};
