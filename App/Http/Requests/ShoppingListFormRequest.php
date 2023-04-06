<?php

namespace App\Http\Requests;

use Core\Http\Requests\FormRequest;

class ShoppingListFormRequest extends FormRequest
{
    public static function authorize(): bool
    {
        return true;
    }

    public static function rules(): array
    {
        return [
            'user_id' => 'int,required',
            'description' => 'string,required',
            'name' => 'array,required',
            'quantity' => 'array,required',
            'price' => 'array,required',
            'is_checked' => 'array,required',
        ];
    }

}