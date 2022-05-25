<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserLoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required|min:8',
        ];
    }

    /**
     * Get the error messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'email.required' => 'L\':attribute és obligatòria',
            'password.required' => 'La :attribute és obligatòria',
            'password.min' => 'La :attribute ha de contenir, com a mínim, :min caràcters'
        ];
    }

    /**
     * Get the attributes that apply to the request
     */
    public function attributes()
    {
        return [
            'email' => 'adreça de correu eletrònic',
            'password' => 'contrasenya',
        ];
    }
}
