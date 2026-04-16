<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBillingPeriodRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('billing_period'));
    }

    public function rules(): array
    {
        $billingPeriod = $this->route('billing_period');

        return [
            'name' => ['required', 'string', 'max:255', 'unique:billing_periods,name,' . $billingPeriod->id],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'is_active' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => 'Cette période de facturation existe déjà.',
            'end_date.after' => 'La date de fin doit être après la date de début.',
        ];
    }
}
