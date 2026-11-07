<?php

namespace Tests\Feature;

use App\Http\Enums\FuelType;
use App\Http\Enums\MaintenanceType;
use App\Models\Equipment;
use App\Models\FuelLoad;
use App\Models\Maintenance;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class EquipmentHistoryTest extends TestCase
{
    use RefreshDatabase;

    public function test_history_endpoints_require_authentication(): void
    {
        $equipment = Equipment::factory()->create();

        $this->getJson("/api/v1/equipment/{$equipment->id}/maintenances")->assertUnauthorized();
        $this->getJson("/api/v1/equipment/{$equipment->id}/fuel-loads")->assertUnauthorized();
    }

    public function test_lists_only_equipment_maintenances_paginated_latest_first(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $equipment = Equipment::factory()->create();
        $other = Equipment::factory()->create();

        Maintenance::factory()->count(16)->create(['equipment_id' => $equipment->id]);
        $newest = Maintenance::factory()->create([
            'equipment_id' => $equipment->id,
            'occurred_at' => now()->addDay(),
        ]);
        Maintenance::factory()->create(['equipment_id' => $other->id]);

        $response = $this->getJson("/api/v1/equipment/{$equipment->id}/maintenances");

        $response->assertOk()
            ->assertJsonCount(15, 'data')
            ->assertJsonPath('meta.total', 17)
            ->assertJsonPath('data.0.id', $newest->id);

        $this->getJson("/api/v1/equipment/{$equipment->id}/maintenances?page=2")
            ->assertOk()
            ->assertJsonCount(2, 'data');
    }

    public function test_lists_only_equipment_fuel_loads_paginated_latest_first(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $equipment = Equipment::factory()->create();
        $other = Equipment::factory()->create();

        FuelLoad::factory()->count(16)->create([
            'equipment_id' => $equipment->id,
            'fuel_type' => FuelType::Diesel,
            'occurred_at' => now(),
        ]);
        $newest = FuelLoad::factory()->create([
            'equipment_id' => $equipment->id,
            'fuel_type' => FuelType::Diesel,
            'occurred_at' => now()->addDay(),
        ]);
        FuelLoad::factory()->create([
            'equipment_id' => $other->id,
            'fuel_type' => FuelType::Diesel,
            'occurred_at' => now(),
        ]);

        $response = $this->getJson("/api/v1/equipment/{$equipment->id}/fuel-loads");

        $response->assertOk()
            ->assertJsonCount(15, 'data')
            ->assertJsonPath('meta.total', 17)
            ->assertJsonPath('data.0.id', $newest->id);

        $this->getJson("/api/v1/equipment/{$equipment->id}/fuel-loads?page=2")
            ->assertOk()
            ->assertJsonCount(2, 'data');
    }

    public function test_returns_404_for_unknown_equipment(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $this->getJson('/api/v1/equipment/999999/maintenances')->assertNotFound();
        $this->getJson('/api/v1/equipment/999999/fuel-loads')->assertNotFound();
    }

    public function test_pending_preventive_requires_authentication(): void
    {
        $this->getJson('/api/v1/equipment/pending-preventive-maintenance')->assertUnauthorized();
    }

    public function test_pending_preventive_uses_strict_threshold_from_last_preventive(): void
    {
        Sanctum::actingAs(User::factory()->create());

        // Nunca tuvo preventiva: 251 h desde cero -> pendiente.
        $neverMaintained = Equipment::factory()->create(['current_hour_meter' => 251]);
        // Nunca tuvo preventiva: 250 h exactas -> no pendiente (umbral estricto).
        Equipment::factory()->create(['current_hour_meter' => 250]);
        // Última preventiva en 100, actual 350 -> exactamente 250 -> no pendiente.
        $exact = Equipment::factory()->create(['current_hour_meter' => 350]);
        $this->preventive($exact, 100);
        // Última preventiva en 100, actual 351 -> 251 -> pendiente.
        $over = Equipment::factory()->create(['current_hour_meter' => 351]);
        $this->preventive($over, 100);
        // Usa la MÁS reciente (300), no la primera: 400 - 300 = 100 -> no pendiente.
        $multiple = Equipment::factory()->create(['current_hour_meter' => 400]);
        $this->preventive($multiple, 50);
        $this->preventive($multiple, 300);
        // Correctiva reciente no reinicia el contador: 500 desde cero -> pendiente.
        $corrective = Equipment::factory()->create(['current_hour_meter' => 500]);
        Maintenance::factory()->create([
            'equipment_id' => $corrective->id,
            'type' => MaintenanceType::Corrective,
            'hour_meter' => 490,
        ]);

        $ids = collect($this->getJson('/api/v1/equipment/pending-preventive-maintenance')
            ->assertOk()
            ->json('data'))->pluck('id')->all();

        $this->assertEqualsCanonicalizing(
            [$neverMaintained->id, $over->id, $corrective->id],
            $ids
        );
    }

    private function preventive(Equipment $equipment, float $hourMeter): void
    {
        Maintenance::factory()->create([
            'equipment_id' => $equipment->id,
            'type' => MaintenanceType::Preventive,
            'hour_meter' => $hourMeter,
        ]);
    }
}
