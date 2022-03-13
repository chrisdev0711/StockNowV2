<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductSiteUpdateRequest extends FormRequest
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
            'site_id' => ['required', 'numeric'], 
            'product_id' => ['required', 'numeric'], 
            'par_level' => ['required', 'numeric'],
            'reorder_point' => ['required', 'numeric'],
            'active' => ['nullable', 'boolean'],
            'last_stock_level' => ['nullable', 'numeric'],
            'current_stock_level' => ['nullable', 'numeric']
        ];
    }
}
