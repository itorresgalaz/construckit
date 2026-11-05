<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EquipmentResource extends JsonResource
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
            'internal_code' => $this->internal_code,
            'type'          => $this->type,
            'license_plate' => $this->license_plate,
            'brand'         => $this->brand,
            'model'         => $this->model,
            'current_hour_meter' => $this->current_hour_meter,
            'status'        => $this->status,
        ];
    }
}
