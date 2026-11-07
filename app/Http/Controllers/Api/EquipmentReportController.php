<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\EquipmentReportRequest;
use App\Models\Equipment;
use Illuminate\Http\JsonResponse;

class EquipmentReportController extends Controller
{
    /**
     * Reporte de equipo
     */
    public function __invoke(EquipmentReportRequest $request, Equipment $equipment): JsonResponse
    {
        $from = $request->date('from')->startOfDay();
        $to = $request->date('to')->endOfDay();

        $fuelData = $equipment->fuelLoads()
            ->whereBetween('occurred_at', [$from, $to])
            ->selectRaw('SUM(liters) as total_liters, SUM(amount_clp) as total_fuel_amount_clp, MIN(hour_meter) as min_hour, MAX(hour_meter) as max_hour')
            ->first();

        $maintenanceData = $equipment->maintenances()
            ->whereBetween('occurred_at', [$from, $to])
            ->selectRaw('SUM(cost_clp) as total_maintenance_cost_clp')
            ->first();

        $totalLiters = (float) ($fuelData->total_liters ?? 0);
        $hourDiff = ($fuelData->max_hour ?? 0) - ($fuelData->min_hour ?? 0);
        $litersPerHour = $hourDiff > 0 ? round($totalLiters / $hourDiff, 2) : null;

        return response()->json([
            'total_liters' => $totalLiters,
            'total_fuel_amount_clp' => (int) ($fuelData->total_fuel_amount_clp ?? 0),
            'total_maintenance_cost_clp' => (int) ($maintenanceData->total_maintenance_cost_clp ?? 0),
            'liters_per_hour' => $litersPerHour,
        ]);
    }
}
