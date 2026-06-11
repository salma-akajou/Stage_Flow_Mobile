<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MobileRegisterRequest extends FormRequest
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
            'prenom'           => ['required', 'string', 'max:255'],
            'nom'              => ['required', 'string', 'max:255'],
            'email'            => ['required', 'email', 'max:255'],
            'password'         => ['required', 'string', 'min:6', 'confirmed'],
            'ville_id'         => ['required', 'integer'],
            'etablissement_id' => ['required', 'integer'],
            'filiere_id'       => ['required', 'integer'],
            'niveau_etude'     => ['required', 'string'],
            'bio'              => ['nullable', 'string'],
            'github'           => ['nullable', 'string'],
            'linkedin'         => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'prenom.required' => 'Le prénom est obligatoire.',
            'nom.required'    => 'Le nom est obligatoire.',
            'email.required'  => 'L\'adresse email est obligatoire.',
            'email.email'     => 'Veuillez saisir une adresse email valide.',
            'password.required' => 'Le mot de passe est obligatoire.',
            'password.min'    => 'Le mot de passe doit contenir au moins 6 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
            'ville_id.required'  => 'La ville est obligatoire.',
            'etablissement_id.required' => 'L\'établissement est obligatoire.',
            'filiere_id.required'       => 'La filière est obligatoire.',
            'niveau_etude.required'     => 'Le niveau d\'études est obligatoire.',
        ];
    }
}
