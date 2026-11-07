<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MaintenanceRequest;
use App\Http\Resources\MaintenanceResource;
use App\Models\Equipment;
use App\Services\HourMeterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class MaintenanceController extends Controller
{
    public function store(MaintenanceRequest $request, HourMeterService $service): JsonResponse
    {
        $data = $request->validated();
        $equipment = Equipment::findOrFail($data['equipment_id']);
        unset($data['equipment_id']);

        $maintenance = DB::transaction(function () use ($data, $equipment, $service) {
            $service->apply($equipment, (float) $data['hour_meter']);

            return $equipment->maintenances()->create($data)->refresh();
        });

        return (new MaintenanceResource($maintenance))->response()->setStatusCode(201);
    }
}
