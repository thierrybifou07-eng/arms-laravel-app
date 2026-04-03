<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFloorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('floor'));
    }

    public function rules(): array
    {
        return [
            'floor_status_id' => ['required', 'exists:floor_statuses,id'],
            'floor_number' => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string', 'max:255'],
        ];
    }
}
