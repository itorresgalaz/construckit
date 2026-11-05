<?php

namespace App\Http\Requests;

use App\Http\Enums\FuelType;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FuelLoadRequest extends FormRequest
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
            'fuel_type' => ['required', Rule::enum(FuelType::class)],
            'occurred_at' => ['sometimes','date','before_or_equal:now'],
            'liters' => ['required','numeric','gt:0','max:999.999'],
            'amount_clp' => ['required','integer','min:0'],
            'hour_meter' => ['required', 'numeric','min:0','max:999.999'],

        ];
    }
}
