<?php

namespace App\Http\Requests;

use App\Http\Enums\MaintenanceType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MaintenanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'equipment_id' => ['required', 'integer', Rule::exists('equipment', 'id')],
            'type' => ['required', Rule::enum(MaintenanceType::class)],
            'occurred_at' => ['sometimes', 'date', 'before_or_equal:now'],
            'hour_meter' => ['required', 'numeric', 'min:0', 'max:99999.99'],
            'cost_clp' => ['required', 'integer', 'min:0'],
            'description' => ['required', 'string', 'max:1000'],
        ];
    }
}
