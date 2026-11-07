<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FuelLoadResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'equipment_id' => $this->equipment_id,
            'fuel_type'          => $this->fuel_type,
            'occurred_at' => $this->occurred_at,
            'liters'         => $this->liters,
            'amount_clp'         => $this->amount_clp,
            'hour_meter' => $this->hour_meter,
        ];
    }
}
