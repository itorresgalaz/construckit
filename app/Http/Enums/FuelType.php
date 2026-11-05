<?php

namespace App\Http\Enums;

enum FuelType: string
{
    case Diesel = 'diesel';
    case Gasoline = 'gasoline';

    case Other = 'other';
}
