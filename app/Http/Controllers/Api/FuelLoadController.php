<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FuelLoadRequest;
use App\Http\Resources\FuelLoadResource;
use App\Models\Equipment;
use App\Services\HourMeterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FuelLoadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // return FuelLoad::all();
    }

    /**
     * Registrar Carga de Combustible.
     */
    public function store(FuelLoadRequest $request, HourMeterService $service): JsonResponse
    {
        $data = $request->validated();
        $equipment = Equipment::findOrFail($data['equipment_id']);
        unset($data['equipment_id']);

        $fuelLoad = DB::transaction(function () use ($data, $equipment, $service) {
            $service->apply(
                $equipment,
                (float) $data['hour_meter'],
                $data['fuel_type'],
            );

            return $equipment->fuelLoads()->create($data)->refresh();
        });

        return new FuelLoadResource($fuelLoad)->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(FuelLoad $fuelLoad)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FuelLoad $fuelLoad)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FuelLoad $fuelLoad)
    {
        //
    }
}
