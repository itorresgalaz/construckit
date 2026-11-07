<?php

namespace Tests\Feature;

use App\Http\Enums\MaintenanceType;
use App\Models\Equipment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class MaintenanceStoreTest extends TestCase
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
        $response = $this->postJson('/api/v1/maintenance', []);

        $response->assertUnauthorized();
    }

    public function test_creates_maintenance_and_updates_equipment_hour_meter(): void
    {
        Sanctum::actingAs($this->user);

        $equipment = Equipment::factory()->create(['current_hour_meter' => 100]);

        $payload = [
            'equipment_id' => $equipment->id,
            'type' => MaintenanceType::Preventive->value,
            'occurred_at' => now()->toDateTimeString(),
            'hour_meter' => 180.50,
            'cost_clp' => 150000,
            'description' => 'Cambio de filtros y aceites.',
        ];

        $response = $this->postJson('/api/v1/maintenance', $payload);

        $response->assertCreated()
            ->assertJsonPath('data.equipment_id', $equipment->id)
            ->assertJsonPath('data.cost_clp', 150000)
            ->assertJsonPath('data.type', 'preventive');

        $this->assertDatabaseHas('maintenance', [
            'equipment_id' => $equipment->id,
            'cost_clp' => 150000,
        ]);

        $this->assertEquals(180.50, $equipment->fresh()->current_hour_meter);
    }

    public function test_accepts_equal_hour_meter_without_increment(): void
    {
        Sanctum::actingAs($this->user);

        $equipment = Equipment::factory()->create(['current_hour_meter' => 100]);

        $payload = [
            'equipment_id' => $equipment->id,
            'type' => MaintenanceType::Corrective->value,
            'hour_meter' => 100,
            'cost_clp' => 50000,
            'description' => 'Ajuste menor',
        ];

        $this->postJson('/api/v1/maintenance', $payload)->assertCreated();

        $this->assertEquals(100, $equipment->fresh()->current_hour_meter);
    }

    public function test_rejects_lower_hour_meter_with_validation_error(): void
    {
        Sanctum::actingAs($this->user);

        $equipment = Equipment::factory()->create(['current_hour_meter' => 100]);

        $payload = [
            'equipment_id' => $equipment->id,
            'type' => MaintenanceType::Preventive->value,
            'hour_meter' => 80,
            'cost_clp' => 50000,
            'description' => 'Revisión',
        ];

        $response = $this->postJson('/api/v1/maintenance', $payload);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['hour_meter']);

        $this->assertDatabaseCount('maintenance', 0);
        $this->assertEquals(100, $equipment->fresh()->current_hour_meter);
    }

    public function test_validates_required_fields(): void
    {
        Sanctum::actingAs($this->user);

        $response = $this->postJson('/api/v1/maintenance', []);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['equipment_id', 'type', 'hour_meter', 'cost_clp', 'description']);
    }
}
