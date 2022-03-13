<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
            'name' => ['required', 'max:255', 'string'],
            'sku' => ['nullable', 'max:255', 'string'],
            'description' => ['nullable', 'max:255', 'string'],
            'serving_name' => ['nullable', 'max:255', 'string'],
            'par_level' => ['nullable', 'numeric'],
            'reorder_point' => ['nullable', 'numeric'],
            'product_category_id' => [
                'nullable',
                'exists:product_categories,id',
            ],
            'supplier_id' => ['nullable', 'exists:suppliers,id'],
            'supplier_sku' => ['nullable', 'max:255', 'string'],
            'entered_cost' => ['required', 'numeric'],
            'entered_inc_vat' => ['nullable', 'boolean'],
            'vat_rate' => ['required', 'numeric'],
            'gross_cost' => ['nullable', 'numeric'],
            'net_cost' => ['nullable', 'numeric'],
            'pack_type' => ['nullable', 'max:255', 'string'],
            'multipack' => ['nullable', 'boolean'],
            'units_per_pack' => ['nullable', 'numeric'],
            'servings_per_unit' => ['nullable', 'numeric'],
            'in_cart' => ['nullable', 'numeric'],
            'locations.*' => ['nullable'],
        ];
    }
}
