<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Payment::class);
    }

    public function rules(): array
    {
        return [
            'contract_id' => ['required', 'exists:contracts,id'],
            'payment_method_id' => ['required', 'exists:payment_methods,id'],
            'payment_status_id' => ['required', 'exists:payment_statuses,id'],
            'expected_amount' => ['required', 'numeric', 'min:0'],
            'paid_amount' => ['required', 'numeric', 'min:0'],
            'tip_amount' => ['nullable', 'numeric', 'min:0'],
            'payment_date' => ['required', 'date'],
            'due_date' => ['required', 'date'],
        ];
    }
}
