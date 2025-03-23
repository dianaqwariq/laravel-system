<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // This allows all users to send requests. Modify if needed.
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'regex:/[A-Z]/'], // Ensures at least one capital letter
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:6'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.regex' => 'The name must contain at least one capital letter.', // Custom message
        ];
    }
}
