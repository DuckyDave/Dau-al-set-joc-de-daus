<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
        ];
    }

    /**
     * get the error messages thst apply to the request
     */
    public function messages()
    {
        return [
            'nick_name.max' => 'El :attribute no pot contenir més de :max caràcters',
        ];
    }

    /**
     * Get the attributes that apply to the request
     */
    public function attributes()
    {
        return [
            'nick_name' => 'nom d\'usuari',
        ];
    }
}
