<?php

namespace App\Models;

use App\Http\Enums\EquipmentStatus;
use App\Http\Enums\EquipmentType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    /** @use HasFactory<\Database\Factories\EquipmentFactory> */
    use HasFactory;

    protected $table = 'equipment';
    protected $fillable = [
        'internal_code',
        'license_plate',
        'type',
        'brand',
        'model',
        'status',
    ];

    public function casts(): array
    {
        return [
            'type' => EquipmentType::class,
            'status' => EquipmentStatus::class,
            'current_hour_meter' => 'decimal:2',
        ];
    }

    public function fuelLoads()
    {
        return $this->hasMany(FuelLoad::class);
    }

    public function maintenances()
    {
        return $this->hasMany(Maintenance::class);
    }
}
