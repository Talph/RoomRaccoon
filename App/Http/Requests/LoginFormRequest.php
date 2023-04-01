<?php

namespace App\Http\Requests;

use Core\Http\Requests\FormRequest;

class LoginFormRequest extends FormRequest
{
    public static function authorize(): bool
    {
        return true;
    }

    public static function rules(): array
    {
        return [
            'password' => 'string,required',
            'username' => 'string,required'
        ];
    }

}