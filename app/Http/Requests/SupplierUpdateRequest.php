<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierUpdateRequest extends FormRequest
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
            'company' => ['required', 'max:255', 'string'],
            'address_1' => ['required', 'max:255', 'string'],
            'address_2' => ['nullable', 'max:255', 'string'],
            'city' => ['nullable', 'max:255', 'string'],
            'county' => ['nullable', 'max:255', 'string'],
            'postcode' => ['nullable', 'max:255', 'string'],
            'payment_terms' => ['nullable', 'max:255', 'string'],
            'order_phone' => ['nullable', 'max:255', 'string'],
            'order_email_1' => ['nullable', 'max:255', 'email'],
            'order_email_2' => ['nullable', 'max:255', 'email'],
            'order_email_3' => ['nullable', 'max:255', 'email'],
            'account_manager' => ['nullable', 'max:255', 'string'],
            'account_manager_phone' => ['nullable', 'max:255', 'string'],
            'account_manager_email' => ['nullable', 'max:255', 'email'],
        ];
    }
}
