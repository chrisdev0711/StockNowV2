<?php

namespace App\Imports;

use App\Models\Supplier;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;

class SupplierImport implements ToModel, WithValidation, WithHeadingRow
{
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Supplier([
            'company' => $row['company'],
            'address_1' => $row['address_1'],
            'address_2' => $row['address_2'],
            'city' => $row['city'],
            'county' => $row['county'],
            'postcode' => $row['postcode'],
            'payment_terms' => $row['payment_terms'],
            'order_phone' => $row['order_phone'],
            'order_email_1' => $row['order_email_1'],
            'order_email_2' => $row['order_email_2'],
            'order_email_3' => $row['order_email_3'],
            'account_manager' => $row['account_manager'],
            'account_manager_phone' => $row['account_manager_phone'],
            'account_manager_email' => $row['account_manager_email'],
        ]);
    }

    public function rules(): array {
        return [
            '*.company' => ['required', 'max:255', 'string'],
            '*.address_1' => ['nullable', 'max:255', 'string'],
            '*.address_2' => ['nullable', 'max:255', 'string'],
            '*.city' => ['nullable', 'max:255', 'string'],
            '*.county' => ['nullable', 'max:255', 'string'],
            '*.postcode' => ['nullable', 'max:255'],
            '*.payment_terms' => ['nullable', 'max:255', 'string'],
            '*.order_phone' => ['nullable',  'max:255'],
            '*.order_email_1' => ['nullable', 'email', 'max:255'],
            '*.order_email_2' => ['nullable', 'email', 'max:255'],
            '*.order_email_3' => ['nullable', 'email', 'max:255'],
            '*.account_manager' => ['nullable', 'max:255', 'string'],
            '*.account_manager_phone' => ['nullable', 'max:255'],
            '*.account_manager_email' => ['nullable', 'email', 'max:255'],
        ];
    }
}
