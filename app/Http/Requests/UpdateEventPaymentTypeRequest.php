<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventPaymentTypeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('event_payment_type'));
    }

    public function rules(): array
    {
        $eventPaymentType = $this->route('event_payment_type');

        return [
            'name' => ['required', 'string', 'max:255', 'unique:event_payment_types,name,' . $eventPaymentType->id],
            'description' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => 'Ce type de paiement d\'événement existe déjà.',
        ];
    }
}
