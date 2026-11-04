<?php

namespace Database\Factories;

use App\Http\Enums\EquipmentStatus;
use App\Http\Enums\EquipmentType;
use App\Models\Equipment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Equipment>
 */
class EquipmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'internal_code' => strtoupper(fake()->unique()->bothify('EQ-####')),
            'type' => fake()->randomElement(EquipmentType::cases()),
            'license_plate' => fake()->optional()->bothify('??-??-##'),
            'brand' => fake()->randomElement(['Volvo', 'Caterpillar', 'Komatsu', 'Mercedes-Benz']),
            'model' => fake()->bothify('??-###'),
            'current_hour_meter' => fake()->randomFloat(2, 0, 5000),
            'status' => fake()->randomElement(EquipmentStatus::cases()),
        ];
    }
}
