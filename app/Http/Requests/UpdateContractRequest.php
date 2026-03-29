<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContractRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('contract'));
    }

    public function rules(): array
    {
        return [
            'contract_status_id' => ['required', 'exists:contract_statuses,id'],
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
