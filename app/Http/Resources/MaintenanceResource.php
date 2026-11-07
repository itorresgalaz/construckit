<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MaintenanceResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'equipment_id' => $this->equipment_id,
            'type' => $this->type,
            'occurred_at' => $this->occurred_at,
            'hour_meter' => $this->hour_meter,
            'cost_clp' => $this->cost_clp,
            'description' => $this->description,
        ];
    }
}
