<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IngredientUpdateRequest extends FormRequest
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
            'sellable_id' => ['required', 'exists:sellables,id'],
            'product_id' => ['required', 'exists:products,id'],            
            'measure' => ['nullable', 'numeric'],
            'cost_price' => ['nullable', 'numeric'],                    
        ];
    }
}
