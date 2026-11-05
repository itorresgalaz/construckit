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
        Schema::create('fuel_loads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_id')->constrained('equipment')->restrictOnDelete();
            $table->string('fuel_type', 20);
            $table->dateTime('occurred_at')->useCurrent(); // Se agrega Current, si el usuario esta apurado y no ingresa fecha ni hora
            $table->decimal('liters', 12, 3);
            $table->unsignedBigInteger('amount_clp');
            $table->decimal('hour_meter', 12, 2);
            $table->timestamps();

            $table->index(['equipment_id', 'occurred_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fuel_loads');
    }
};
