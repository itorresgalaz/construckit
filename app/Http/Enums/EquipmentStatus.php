<?php

namespace App\Http\Enums;

enum EquipmentStatus: string
{
    case Operational = 'operational';
    case UnderMaintenance = 'under_maintenance';
    case OutOfService = 'out_of_service';

}
