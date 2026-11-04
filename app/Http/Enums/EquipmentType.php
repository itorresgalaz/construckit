<?php

namespace App\Http\Enums;

enum EquipmentType: string
{
    case Truck = 'truck';
    case Excavator = 'excavator';
    case Generator = 'generator';

    case Other = 'other';

}

