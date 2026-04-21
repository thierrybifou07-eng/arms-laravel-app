<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContractRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Contract::class);
    }

    public function rules(): array
    {
        return [
            'student_id' => ['required', 'exists:students,id'],
            'room_id' => ['required', 'exists:rooms,id'],
            'contract_status_id' => ['required', 'exists:contract_statuses,id'],
            'billing_period_id' => ['required', 'exists:billing_periods,id'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'monthly_amount' => ['required', 'numeric', 'min:0'],
            'terms' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'end_date.after' => 'La date de fin doit être après la date de début.',
        ];
    }
}
