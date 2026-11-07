<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_id')->constrained('equipment')->restrictOnDelete();
            $table->string('type', 20);
            $table->dateTime('occurred_at')->useCurrent();
            $table->decimal('hour_meter', 12, 2);
            $table->unsignedBigInteger('cost_clp');
            $table->text('description');
            $table->timestamps();

            $table->index(['equipment_id', 'occurred_at']);
            $table->index('type');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenance');
    }
};
