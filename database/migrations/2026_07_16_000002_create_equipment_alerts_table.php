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
        Schema::create('equipment_alerts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_id')->constrained('equipment')->onDelete('cascade');
            $table->enum('alert_type', ['low_stock', 'maintenance_due', 'missing_item', 'damage_report']);
            $table->string('message');
            $table->boolean('is_resolved')->default(false);
            $table->timestamps();
            
            $table->index('equipment_id');
            $table->index('alert_type');
            $table->index('is_resolved');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('equipment_alerts');
    }
};
