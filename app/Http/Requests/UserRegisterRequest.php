<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRegisterRequest extends FormRequest
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
            'nick_name' => 'bail|string|max:20',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ];
    }

    /**
     * get the error messages thst apply to the request
     */
    public function messages()
    {
        return [
            'nick_name.max' => 'El :attribute no pot contenir més de :max caràcters',
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
            'nick_name' => 'nom d\'usuari',
            'email' => 'adreça de correu eletrònic',
            'password' => 'contrasenya',
        ];
    }
}
