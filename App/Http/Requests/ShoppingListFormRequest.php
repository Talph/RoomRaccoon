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
            'item_price' => 'array',
//            'is_checked' => 'array',
            'user_id' => 'int,required',
            'title' => 'string,required',
            'description' => 'string,required',
            'item_name' => 'array,required',
            'item_quantity' => 'array,required',
        ];
    }

}