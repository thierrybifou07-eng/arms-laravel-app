<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoomRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Room::class);
    }

    public function rules(): array
    {
        return [
            'room_status_id' => ['required', 'exists:room_statuses,id'],
            'room_number' => ['required', 'string', 'max:50'],
            'capacity' => ['required', 'integer', 'min:1'],
            'room_type' => ['required', 'string', 'in:single,double,triple,quad'],
            'price_per_month' => ['required', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'room_type.in' => 'Le type de chambre doit être: single, double, triple ou quad.',
        ];
    }
}
