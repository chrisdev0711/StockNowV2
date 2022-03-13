<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderItemStoreRequest extends FormRequest
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
            'order_id' => ['required', 'exists:orders,id'],
            'product_id' => ['required', 'exists:products,id'],
            'unit_price' => ['nullable', 'numeric'], 
            'qty' => ['nullable', 'numeric'], 
            'total_price' => ['nullable', 'numeric'], 
            'received_qty' => ['nullable', 'numeric'], 
            'received_by_id' => ['nullable', 'exists:users,id'],
            'received_on' => ['nullable', 'date', 'date'],
            'status' => [
                'required',
                'in:pending,received,partial'
            ],            
        ];
    }
}
