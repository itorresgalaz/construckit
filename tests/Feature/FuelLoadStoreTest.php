<?php

namespace Tests\Feature;

use App\Http\Enums\FuelType;
use App\Models\Equipment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class FuelLoadStoreTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_requires_authentication(): void
    {
        $response = $this->postJson('/api/v1/fuel_loads', []);

        $response->assertUnauthorized();
    }

    public function test_creates_fuel_load_and_updates_equipment_hour_meter(): void
    {
        Sanctum::actingAs($this->user);

        $equipment = Equipment::factory()->create(['current_hour_meter' => 100]);

        $payload = [
            'equipment_id' => $equipment->id,
            'fuel_type' => FuelType::Diesel->value,
            'occurred_at' => now()->toDateTimeString(),
            'liters' => 50.5,
            'amount_clp' => 60000,
            'hour_meter' => 150.25,
        ];

        $response = $this->postJson('/api/v1/fuel_loads', $payload);

        $response->assertCreated()
            ->assertJsonPath('data.equipment_id', $equipment->id)
            ->assertJsonPath('data.amount_clp', 60000);

        $this->assertDatabaseHas('fuel_loads', [
            'equipment_id' => $equipment->id,
            'amount_clp' => 60000,
        ]);

        $this->assertEquals(150.25, $equipment->fresh()->current_hour_meter);
    }

    public function test_accepts_equal_hour_meter_without_increment(): void
    {
        Sanctum::actingAs($this->user);

        $equipment = Equipment::factory()->create(['current_hour_meter' => 100]);

        $payload = [
            'equipment_id' => $equipment->id,
            'fuel_type' => FuelType::Diesel->value,
            'liters' => 20,
            'amount_clp' => 25000,
            'hour_meter' => 100,
        ];

        $response = $this->postJson('/api/v1/fuel_loads', $payload);

        $response->assertCreated();
        $this->assertEquals(100, $equipment->fresh()->current_hour_meter);
    }

    public function test_rejects_lower_hour_meter_with_validation_error(): void
    {
        Sanctum::actingAs($this->user);

        $equipment = Equipment::factory()->create(['current_hour_meter' => 100]);

        $payload = [
            'equipment_id' => $equipment->id,
            'fuel_type' => FuelType::Diesel->value,
            'liters' => 20,
            'amount_clp' => 25000,
            'hour_meter' => 80,
        ];

        $response = $this->postJson('/api/v1/fuel_loads', $payload);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['hour_meter']);

        $this->assertDatabaseCount('fuel_loads', 0);
        $this->assertEquals(100, $equipment->fresh()->current_hour_meter);
    }

    public function test_accepts_same_fuel_type_for_equipment(): void
    {
        Sanctum::actingAs($this->user);

        $equipment = Equipment::factory()->create(['current_hour_meter' => 100]);
        $payload = [
            'equipment_id' => $equipment->id,
            'fuel_type' => FuelType::Diesel->value,
            'liters' => 20,
            'amount_clp' => 25000,
            'hour_meter' => 110,
        ];

        $this->postJson('/api/v1/fuel_loads', $payload)->assertCreated();

        $payload['hour_meter'] = 120;

        $this->postJson('/api/v1/fuel_loads', $payload)->assertCreated();

        $this->assertDatabaseCount('fuel_loads', 2);
    }

    public function test_rejects_different_fuel_type_for_equipment(): void
    {
        Sanctum::actingAs($this->user);

        $equipment = Equipment::factory()->create(['current_hour_meter' => 100]);
        $payload = [
            'equipment_id' => $equipment->id,
            'fuel_type' => FuelType::Diesel->value,
            'liters' => 20,
            'amount_clp' => 25000,
            'hour_meter' => 110,
        ];

        $this->postJson('/api/v1/fuel_loads', $payload)->assertCreated();

        $payload['fuel_type'] = FuelType::Gasoline->value;
        $payload['hour_meter'] = 120;

        $response = $this->postJson('/api/v1/fuel_loads', $payload);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['fuel_type']);

        $this->assertDatabaseCount('fuel_loads', 1);
        $this->assertEquals(110, $equipment->fresh()->current_hour_meter);
    }

    public function test_different_equipment_can_use_different_fuel_type(): void
    {
        Sanctum::actingAs($this->user);

        $dieselEquipment = Equipment::factory()->create(['current_hour_meter' => 100]);
        $gasolineEquipment = Equipment::factory()->create(['current_hour_meter' => 100]);

        $basePayload = [
            'fuel_type' => FuelType::Diesel->value,
            'liters' => 20,
            'amount_clp' => 25000,
            'hour_meter' => 110,
        ];

        $this->postJson('/api/v1/fuel_loads', [
            ...$basePayload,
            'equipment_id' => $dieselEquipment->id,
        ])->assertCreated();

        $this->postJson('/api/v1/fuel_loads', [
            ...$basePayload,
            'equipment_id' => $gasolineEquipment->id,
            'fuel_type' => FuelType::Gasoline->value,
        ])->assertCreated();

        $this->assertDatabaseCount('fuel_loads', 2);
    }

    public function test_validates_required_fields(): void
    {
        Sanctum::actingAs($this->user);

        $response = $this->postJson('/api/v1/fuel_loads', []);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['equipment_id', 'fuel_type', 'liters', 'amount_clp', 'hour_meter']);
    }
}
