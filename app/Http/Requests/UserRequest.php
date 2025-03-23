<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        Log::info('UserRequest: authorize method called');
        return true;
    }

    public function rules()
    {
        Log::info('UserRequest: rules method called');
        return [
           'name' => ['required', 'string', 'regex:/[A-Z]/'],
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ];
    }

    public function messages()
    {
        Log::info('UserRequest: messages method called');
        return [
            'name.regex' => 'The name must contain at least one capital letter.',
        ];
       
    }
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
{
    Log::info('Validation failed', ['errors' => $validator->errors()]);
    // parent::failedValidation($validator);
    throw new \Illuminate\Validation\ValidationException($validator);
}
}