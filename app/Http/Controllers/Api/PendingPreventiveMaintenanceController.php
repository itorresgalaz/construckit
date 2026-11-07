<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Enums\MaintenanceType;
use App\Http\Resources\EquipmentResource;
use App\Models\Equipment;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PendingPreventiveMaintenanceController extends Controller
{
    private const int THRESHOLD_HOURS = 250;

    /**
     * Equipos con más de 250 horas desde su última preventiva (o desde cero si no tienen).
     */
    public function __invoke(): AnonymousResourceCollection
    {
        $equipment = Equipment::query()
            ->whereRaw(
                'current_hour_meter - COALESCE((
                    SELECT MAX(m.hour_meter) FROM maintenance m
                    WHERE m.equipment_id = equipment.id AND m.type = ?
                ), 0) > ?',
                [MaintenanceType::Preventive->value, self::THRESHOLD_HOURS]
            )
            ->orderBy('id')
            ->paginate();

        return EquipmentResource::collection($equipment);
    }
}
