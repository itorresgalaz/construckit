<?php

namespace Tests\Feature;

use App\Http\Enums\FuelType;
use App\Http\Enums\MaintenanceType;
use App\Models\Equipment;
use App\Models\FuelLoad;
use App\Models\Maintenance;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EquipmentReportTest extends TestCase
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
        $equipment = Equipment::factory()->create();

        $response = $this->getJson("/api/v1/equipment/{$equipment->id}/report?from=2026-11-01&to=2026-11-30");

        $response->assertUnauthorized();
    }

    public function test_validates_required_dates(): void
    {
        $equipment = Equipment::factory()->create();

        $response = $this->actingAs($this->user)->getJson("/api/v1/equipment/{$equipment->id}/report");

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['from', 'to']);
    }

    public function test_validates_date_order(): void
    {
        $equipment = Equipment::factory()->create();

        $response = $this->actingAs($this->user)->getJson(
            "/api/v1/equipment/{$equipment->id}/report?from=2026-11-30&to=2026-11-01"
        );

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['from', 'to']);
    }

    public function test_returns_zeroes_when_no_data_in_range(): void
    {
        $equipment = Equipment::factory()->create();

        $response = $this->actingAs($this->user)->getJson(
            "/api/v1/equipment/{$equipment->id}/report?from=2026-11-01&to=2026-11-30"
        );

        $response->assertOk()
            ->assertExactJson([
                'total_liters' => 0.0,
                'total_fuel_amount_clp' => 0,
                'total_maintenance_cost_clp' => 0,
                'liters_per_hour' => null,
            ]);
    }

    public function test_calculates_aggregations_and_liters_per_hour_correctly(): void
    {
        $equipment = Equipment::factory()->create(['current_hour_meter' => 100]);

        // Cargas dentro de rango
        FuelLoad::create([
            'equipment_id' => $equipment->id,
            'fuel_type' => FuelType::Diesel,
            'occurred_at' => '2026-11-05 10:00:00',
            'liters' => 100,
            'amount_clp' => 120000,
            'hour_meter' => 100,
        ]);

        FuelLoad::create([
            'equipment_id' => $equipment->id,
            'fuel_type' => FuelType::Diesel,
            'occurred_at' => '2026-11-10 10:00:00',
            'liters' => 150,
            'amount_clp' => 180000,
            'hour_meter' => 150,
        ]);

        // Carga fuera de rango (no debe sumar)
        FuelLoad::create([
            'equipment_id' => $equipment->id,
            'fuel_type' => FuelType::Diesel,
            'occurred_at' => '2026-10-01 10:00:00',
            'liters' => 80,
            'amount_clp' => 90000,
            'hour_meter' => 50,
        ]);

        // Mantención dentro de rango
        Maintenance::create([
            'equipment_id' => $equipment->id,
            'type' => MaintenanceType::Preventive,
            'occurred_at' => '2026-11-07 14:00:00',
            'hour_meter' => 120,
            'cost_clp' => 250000,
            'description' => 'Cambio de aceite',
        ]);

        // Mantención de OTRO equipo dentro de rango (no debe sumar)
        $otherEquipment = Equipment::factory()->create();
        Maintenance::create([
            'equipment_id' => $otherEquipment->id,
            'type' => MaintenanceType::Corrective,
            'occurred_at' => '2026-11-08 14:00:00',
            'hour_meter' => 200,
            'cost_clp' => 500000,
            'description' => 'Filtros otro equipo',
        ]);

        $response = $this->actingAs($this->user)->getJson(
            "/api/v1/equipment/{$equipment->id}/report?from=2026-11-01&to=2026-11-30"
        );

        // total_liters = 100 + 150 = 250
        // total_fuel_amount_clp = 120000 + 180000 = 300000
        // total_maintenance_cost_clp = 250000
        // hour diff = 150 - 100 = 50
        // liters_per_hour = 250 / 50 = 5.0
        $response->assertOk()
            ->assertExactJson([
                'total_liters' => 250.0,
                'total_fuel_amount_clp' => 300000,
                'total_maintenance_cost_clp' => 250000,
                'liters_per_hour' => 5.0,
            ]);
    }
}
