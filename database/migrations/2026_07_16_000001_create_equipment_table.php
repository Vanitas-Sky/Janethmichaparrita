<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('equipos', function (Blueprint $table) {
            $table->id();
            $table->string('numero_inventario')->unique()->comment('Número de inventario único');
            $table->string('nombre')->comment('Nombre del equipo (ej. Osciloscopio, Microscopio)');
            $table->string('laboratorio')->comment('Laboratorio asignado (ej. Electrónica, Biología)');
            $table->integer('cantidad')->default(0)->comment('Cantidad disponible del equipo');
            $table->enum('estado', ['Disponible', 'Mantenimiento', 'Dañado', 'Inactivo'])->default('Disponible')->comment('Estado del equipo');
            $table->timestamps();
            
            // Índices para búsquedas rápidas
            $table->index('laboratorio');
            $table->index('estado');
            $table->fullText(['nombre', 'numero_inventario']); // Para búsqueda full-text
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->unique()->comment('Stock Keeping Unit - Número de inventario');
            $table->string('name')->comment('Nombre del equipo');
            $table->string('laboratory')->comment('Laboratorio asignado');
            $table->integer('quantity_available')->default(0)->comment('Cantidad disponible');
            $table->integer('quantity_total')->comment('Cantidad total registrada');
            $table->enum('status', ['operational', 'maintenance', 'damaged', 'inactive'])->default('operational')->comment('Estado del equipo');
            $table->enum('category', ['electronics', 'microscopes', 'computing', 'chemicals', 'tools', 'other'])->comment('Categoría del equipo');
            $table->timestamp('last_maintenance')->nullable()->comment('Última fecha de mantenimiento');
            $table->text('notes')->nullable()->comment('Notas adicionales');
            $table->timestamps();
            
            // Índices para búsquedas rápidas
            $table->index('laboratory');
            $table->index('status');
            $table->index('category');
            $table->fullText(['name', 'sku']); // Para búsqueda full-text
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};
