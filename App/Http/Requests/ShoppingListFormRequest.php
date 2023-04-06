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
            'item_quantity' => 'array,required',
            'item_price' => 'array',
            'is_checked' => 'array,required',
        ];
    }

}