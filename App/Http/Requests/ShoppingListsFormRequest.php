<?php

namespace App\Http\Requests;

use Core\Http\Requests\FormRequest;

class ShoppingListsFormRequest extends FormRequest
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
            'product' => 'array,required',
            'quantity' => 'array,required',
            'price' => 'array,required',
            'is_checked' => 'array,required',
        ];
    }

}