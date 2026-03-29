<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStudentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->can('update', $this->route('student'));
    }

    public function rules(): array
    {
        $student = $this->route('student');

        return [
            'surname' => ['required', 'string', 'max:255'],
            'given_name' => ['required', 'string', 'max:255'],
            'middlename' => ['nullable', 'string', 'max:255'],
            'identification_number' => ['required', 'string', 'max:50', 'unique:students,identification_number,' . $student->id],
            'phone' => ['required', 'regex:/^[0-9\s\-\+\(\)]+$/'],
            'email' => ['required', 'email', 'unique:students,email,' . $student->id],
        ];
    }

    public function messages(): array
    {
        return [
            'identification_number.unique' => 'Ce numéro d\'identification existe déjà.',
            'email.unique' => 'Cet email existe déjà.',
            'phone.regex' => 'Le numéro de téléphone est invalide.',
        ];
    }
}
