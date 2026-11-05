<?php

namespace App\Http\Requests;

use App\Http\Enums\EquipmentStatus;
use App\Http\Enums\EquipmentType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EquipmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'internal_code' => [
                'required', 'string', 'max:50',
                Rule::unique('equipment')->ignore($this->route('equipment')),
            ],
            'type'          => ['required', Rule::enum(EquipmentType::class)],
            'license_plate' => ['nullable', 'string', 'max:20'],
            'brand'         => ['required', 'string', 'max:100'],
            'model'         => ['required', 'string', 'max:100'],
            'status'        => ['sometimes', Rule::enum(EquipmentStatus::class)],
        ];
    }
}
