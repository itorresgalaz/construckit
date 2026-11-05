<?php

namespace App\Models;

use App\Http\Enums\FuelType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FuelLoad extends Model
{
    use HasFactory;
    protected $fillable = [
        'occurred_at',
        'liters',
        'amount_clp',
        'hour_meter',
        'fuel_type'
    ];

    protected function casts(): array
    {
        return [
            'occurred_at' => 'immutable_datetime',
            'liters' => 'decimal:3',
            'amount_clp' => 'integer',
            'hour_meter' => 'decimal:2',
            'fuel_type' => FuelType::class,
        ];
    }

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }
}
