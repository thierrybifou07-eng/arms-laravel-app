<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBuildingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('building'));
    }

    public function rules(): array
    {
        return [
            'building_status_id' => ['required', 'exists:building_statuses,id'],
            'name' => ['required', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'capacity' => ['required', 'integer', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'capacity.required' => 'La capacité est requise.',
            'capacity.min' => 'La capacité doit être positive.',
        ];
    }
}
