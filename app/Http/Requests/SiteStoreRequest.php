<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SiteStoreRequest extends FormRequest
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
            'code' => ['required', 'max:255', 'string'],
            'address_1' => ['nullable', 'max:255', 'string'],
            'address_2' => ['nullable', 'max:255', 'string'],
            'city' => ['nullable', 'max:255', 'string'],
            'country' => ['nullable', 'max:255', 'string'],
            'postcode' => ['nullable', 'max:255', 'string'],
            'email' => ['nullable', 'email'],
            'phoneNumber' => ['nullable', 'max:255', 'string'],
            'merchantId' => ['nullable', 'max:255', 'string'],
            'logoUrl' => ['nullable', 'max:255', 'string'],
            'status' => ['nullable', 'boolean'],
            'display_on_orders' => ['nullable', 'boolean'],
        ];
    }
}
