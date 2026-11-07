<?php

namespace App\Http\Enums;

enum MaintenanceType: string
{
    case Preventive = 'preventive';
    case Corrective = 'corrective';
}
