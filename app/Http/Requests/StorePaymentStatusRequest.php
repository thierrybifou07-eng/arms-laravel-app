<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole('super_admin');
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:payment_statuses,name'],
            'code' => ['required', 'string', 'max:50', 'unique:payment_statuses,code'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => 'Ce statut de paiement existe déjà.',
            'code.unique' => 'Ce code de statut existe déjà.',
        ];
    }
}
