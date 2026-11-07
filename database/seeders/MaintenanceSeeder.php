<?php

namespace Database\Seeders;

use App\Http\Enums\MaintenanceType;
use App\Models\Equipment;
use App\Models\Maintenance;
use Illuminate\Database\Seeder;

class MaintenanceSeeder extends Seeder
{
    public function run(): void
    {
        Equipment::all()->each(function (Equipment $equipment) {
            $hourMeter = (float) $equipment->current_hour_meter;
            $occurredAt = now();
            $count = fake()->numberBetween(1, 2);

            for ($i = 0; $i < $count; $i++) {
                $hourMeter += fake()->randomFloat(2, 10, 100);
                $occurredAt = now();
                Maintenance::create([
                    'equipment_id' => $equipment->id,
                    'type' => fake()->randomElement(MaintenanceType::cases()),
                    'occurred_at' => $occurredAt,
                    'hour_meter' => $hourMeter,
                    'cost_clp' => fake()->numberBetween(50000, 800000),
                    'description' => fake()->sentence(),
                ]);
            }

            $equipment->current_hour_meter = $hourMeter;
            $equipment->save();
        });
    }
}
