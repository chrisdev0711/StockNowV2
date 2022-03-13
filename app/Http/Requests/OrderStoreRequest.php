<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
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
            'supplier_id' => ['required', 'exists:suppliers,id'],
            'uuid' => ['nullable', 'string'],
            'sent' => ['nullable', 'boolean'],
            'status' => [
                'required',
                'in:draft,ordered,part-received,complete,cancelled'
            ],
            'created_by_id' => ['required', 'exists:users,id'],
            'order_date' => ['nullable', 'date', 'date'],
            'delivery_date' => ['nullable', 'date', 'date'],
            'note' => ['nullable', 'max:255']            
        ];
    }
}
