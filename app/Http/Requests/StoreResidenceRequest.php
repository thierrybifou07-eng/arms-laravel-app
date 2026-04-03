<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreResidenceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('create', \App\Models\Residence::class);
    }

    public function rules(): array
    {
        return [
            'residence_status_id' => ['required', 'exists:residence_statuses,id'],
            'name' => ['required', 'string', 'max:255', 'unique:residences,name'],
            'address' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'regex:/^[0-9\s\-\+\(\)]+$/'],
            'email' => ['nullable', 'email'],
            'manager_id' => ['nullable', 'exists:users,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => 'Cette résidence existe déjà.',
            'phone.regex' => 'Le numéro de téléphone est invalide.',
        ];
    }
}
