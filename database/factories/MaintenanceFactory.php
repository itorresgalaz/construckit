<?php

namespace Database\Factories;

use App\Http\Enums\MaintenanceType;
use App\Models\Equipment;
use App\Models\Maintenance;
use Illuminate\Database\Eloquent\Factories\Factory;

class MaintenanceFactory extends Factory
{
    protected $model = Maintenance::class;

    public function definition(): array
    {
        return [
            'equipment_id' => Equipment::query()->inRandomOrder()->value('id') ?? Equipment::factory(),
            'type' => fake()->randomElement(MaintenanceType::cases()),
            'occurred_at' => now(),
            'hour_meter' => fake()->randomFloat(2, 0, 5000),
            'cost_clp' => fake()->numberBetween(10000, 1000000),
            'description' => fake()->sentence(),
        ];
    }
}
