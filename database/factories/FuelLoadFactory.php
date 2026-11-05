<?php

namespace Database\Factories;

use App\Http\Enums\FuelType;

use App\Models\FuelLoad;
use Illuminate\Database\Eloquent\Factories\Factory;

class FuelLoadFactory extends Factory
{
    protected $model = FuelLoad::class;

    public function definition(): array
    {
        return [
            'internal_code' => strtoupper(fake()->unique()->bothify('EQ-####')),
            'type' => fake()->randomElement(FuelType::cases()),
            'license_plate' => fake()->optional()->bothify('??-??-##'),
            'brand' => fake()->randomElement(['Volvo', 'Caterpillar', 'Komatsu', 'Mercedes-Benz']),
            'model' => fake()->bothify('??-###'),
            'current_hour_meter' => fake()->randomFloat(2, 0, 5000),
            'status' => fake()->randomElement(EquipmentStatus::cases()),
        ];
    }
}
