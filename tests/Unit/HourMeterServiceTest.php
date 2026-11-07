<?php

namespace Tests\Unit;

use App\Models\Equipment;
use App\Services\HourMeterService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class HourMeterServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_rejects_lower_hour_meter(): void
    {
        $equipment = Equipment::factory()->create(['current_hour_meter' => 100]);

        $this->expectException(ValidationException::class);

        app(HourMeterService::class)->apply($equipment, 50);
    }

    public function test_accepts_equal_hour_meter_without_incrementing(): void
    {
        $equipment = Equipment::factory()->create(['current_hour_meter' => 100]);

        app(HourMeterService::class)->apply($equipment, 100);

        $this->assertEquals(100, $equipment->fresh()->current_hour_meter);
    }

    public function test_updates_equipment_when_hour_meter_is_greater(): void
    {
        $equipment = Equipment::factory()->create(['current_hour_meter' => 100]);

        app(HourMeterService::class)->apply($equipment, 150);

        $this->assertEquals(150, $equipment->fresh()->current_hour_meter);
    }
}
