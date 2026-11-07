<?php

namespace App\Services;

use App\Models\Equipment;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class HourMeterService
{
    /**
     * Valida el horómetro entrante contra el actual del equipo y lo actualiza
     * si corresponde, todo dentro de una transacción con bloqueo de fila para que otra operación no lo modifique.
     *
     * @throws ValidationException si el horómetro entrante es menor al actual.
     */
    public function apply(Equipment $equipment, float $hourMeter, ?string $fuelType = null): void
    {
        DB::transaction(function () use ($equipment, $hourMeter, $fuelType) {
            $locked = Equipment::whereKey($equipment->id)->lockForUpdate()->firstOrFail();

            if ($fuelType !== null) {
                $registeredFuelType = $locked->fuelLoads()
                    ->orderBy('id')->lockForUpdate()->first()?->fuel_type?->value;

                if ($registeredFuelType !== null && $registeredFuelType !== $fuelType) {
                    throw ValidationException::withMessages([
                        'fuel_type' => 'El equipo ya tiene registrado otro tipo de combustible.',
                    ]);
                }
            }

            if ($hourMeter < $locked->current_hour_meter) {
                throw ValidationException::withMessages([
                    'hour_meter' => "El horómetro ({$hourMeter}) no puede ser menor al actual del equipo ({$locked->current_hour_meter}).",
                ]);
            }

            if ($hourMeter > $locked->current_hour_meter) {
                // Asignación directa: current_hour_meter no está en $fillable
                // porque los controladores no deben modificarlo; el servicio sí.
                $locked->current_hour_meter = $hourMeter;
                $locked->save();
            }

            $equipment->setAttribute('current_hour_meter', $locked->current_hour_meter);
        });
    }
}
