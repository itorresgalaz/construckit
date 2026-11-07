<?php

namespace Database\Factories;

use App\Http\Enums\EquipmentStatus;
use App\Http\Enums\FuelType;

use App\Models\Equipment;
use App\Models\FuelLoad;
use Illuminate\Database\Eloquent\Factories\Factory;

class FuelLoadFactory extends Factory
{
    protected $model = FuelLoad::class;

    public function definition(): array
    {
        return [
            'equipment_id' => Equipment::query()->inRandomOrder()->value('id'),
            'fuel_type' => fake()->randomElement(FuelType::cases()),
            'occurred_at' => fake()->optional(0.8)->dateTimeBetween('-1 year', 'now'),
            'liters' => fake()->randomFloat(2, 10, 500),
            'amount_clp' => fake()->numberBetween(10000, 500000),
            'hour_meter' => fake()->randomFloat(2, 0, 5000),
        ];
    }
}
