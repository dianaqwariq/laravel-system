<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['nullable', 'regex:/[A-Z]/'], // Optional but must have a capital letter if provided
            'email' => ['nullable', 'email', Rule::unique('users')->ignore($this->user)],
            'password' => ['nullable', 'min:6'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.regex' => 'The name must contain at least one capital letter.',
        ];
    }
}
