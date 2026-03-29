<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole('super_admin');
    }

    public function rules(): array
    {
        $paymentStatus = $this->route('payment_status');

        return [
            'name' => ['required', 'string', 'max:255', 'unique:payment_statuses,name,' . $paymentStatus->id],
            'code' => ['required', 'string', 'max:50', 'unique:payment_statuses,code,' . $paymentStatus->id],
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
