<?php

namespace Database\Seeders;

use App\Http\Enums\FuelType;
use App\Models\Equipment;
use App\Models\FuelLoad;
use Illuminate\Database\Seeder;

class FuelLoadSeeder extends Seeder
{
    public function run(): void
    {
        Equipment::all()->each(function (Equipment $equipment) {
            $fuelType = $equipment->fuelLoads()->orderBy('id')->first()?->fuel_type
                ?? fake()->randomElement(FuelType::cases());
            $hourMeter = (float) $equipment->current_hour_meter;

            $count = fake()->numberBetween(2, 4);
            for ($i = 0; $i < $count; $i++) {
                $hourMeter += fake()->randomFloat(2, 20, 150);
                FuelLoad::create([
                    'equipment_id' => $equipment->id,
                    'fuel_type' => $fuelType,
                    'occurred_at' => now(),
                    'liters' => fake()->randomFloat(2, 30, 200),
                    'amount_clp' => fake()->numberBetween(40000, 300000),
                    'hour_meter' => $hourMeter,
                ]);
            }

            $equipment->current_hour_meter = $hourMeter;
            $equipment->save();
        });
    }
}
