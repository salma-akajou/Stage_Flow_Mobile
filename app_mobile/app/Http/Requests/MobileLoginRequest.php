<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MobileLoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if (empty($this->all()) && !empty($this->getContent())) {
            parse_str($this->getContent(), $parsed);
            $this->merge($parsed);
        }
    }

    public function rules(): array
    {
        return [
            'email'    => ['required', 'email'],
            'password' => ['required', 'string', 'min:6'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email'    => 'Veuillez saisir une adresse email valide.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min'   => 'Le mot de passe doit faire au moins 6 caractères.',
        ];
    }
}
