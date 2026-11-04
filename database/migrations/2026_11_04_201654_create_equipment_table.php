<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Http\Enums\EquipmentType;
use App\Http\Enums\EquipmentStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->string('internal_code', 50)->unique();
            $table->string('type', 30)->default(EquipmentType::Other->value);
            $table->string('license_plate', 100)->nullable();
            $table->string('brand', 100);
            $table->string('model', 100);
            $table->decimal('current_hour_meter', 12, 2)->default(0);
            $table->string('status', 30)->default(EquipmentStatus::Operational->value);
            $table->timestamps();
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
