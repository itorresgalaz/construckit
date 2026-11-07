<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FuelLoadRequest;
use App\Http\Resources\FuelLoadResource;
use App\Models\Equipment;
use App\Services\HourMeterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class FuelLoadController extends Controller
{

/*    public function index()
    {
        //
        // return FuelLoad::all();
    }*/

    /**
     * Cargas de combustible de un equipo, paginadas (más recientes primero).
     */
    public function byEquipment(Equipment $equipment): AnonymousResourceCollection
    {
        return FuelLoadResource::collection(
            $equipment->fuelLoads()->latest('occurred_at')->latest('id')->paginate(10)
        );
    }

    /**
     * Registrar carga de combustible de un equipo.
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

/*    public function show(FuelLoad $fuelLoad)
    {
        //
    }


    public function update(Request $request, FuelLoad $fuelLoad)
    {
        //
    }


    public function destroy(FuelLoad $fuelLoad)
    {
        //
    }*/
}
