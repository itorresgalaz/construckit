<?php

namespace App\Models;

use App\Http\Enums\MaintenanceType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Maintenance extends Model
{
    use HasFactory;

    protected $table = 'maintenance';

    protected $fillable = [
        'equipment_id',
        'type',
        'occurred_at',
        'hour_meter',
        'cost_clp',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'type' => MaintenanceType::class,
            'occurred_at' => 'immutable_datetime',
            'hour_meter' => 'decimal:2',
            'cost_clp' => 'integer',
        ];
    }

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }
}
