<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;

use App\Models\ProductCategory;
use App\Models\Supplier;

class ProductsImport implements ToModel, WithValidation, WithHeadingRow
{
    use Importable;

    public $data;
    public $msg;

    public function __construct()
    {
        $this->data = collect();
        $this->msg = null;
    }    
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $inc_vat = false;
        $gross_cost = 0;
        $net_cost = 0;
        if($row['cost_price_includes_vat'] == "Yes")
        {
            $inc_vat = true;
            $gross_cost = $row['cost_price'];
            $net_cost = (1 - $row['vat_rate']/100) * $row['cost_price'];
        } else {
            $gross_cost = (1 + $row['vat_rate']/100) * $row['cost_price'];
            $net_cost = $row['cost_price'];
        }

        $category = ProductCategory::where('name', '=', $row['category_name'])->first();

        if(!$category)
        {
            $this->msg = "error: category doesn't exist for\n" . $row['product_name'];
            return null;
        }

        $supplier = Supplier::where('company', '=', $row['supplier_company_name'])->first();

        if(!$supplier)
        {
            $this->msg = "error: supplier doesn't exist for\n". $row['product_name'];
            return null;
        }
        
        $model = Product::updateOrCreate([
            'sku' => $row['sku']
            ],
            [
            'name' => $row['product_name'],
            'sku' => $row['sku'],
            'description' => $row['description'],
            'par_level' => $row['minimum_stock_count'],
            'reorder_point' => $row['reorder_point'],
            'product_category_id' => $category->id,
            'supplier_id' => $supplier->id,
            'entered_cost' => $row['cost_price'],
            'entered_inc_vat' => $inc_vat,
            'vat_rate' => $row['vat_rate'],
            'gross_cost' => $gross_cost,
            'net_cost' => $net_cost,
            'pack_type' => $row['pack_yesno'],
            'units_per_pack' => $row['pack_size'],
        ]);     
        
        $this->data->push($model);

        return $model;
    }

    public function rules(): array {
        return [
            '*.product_name' => ['required', 'max:255', 'string'],
            '*.sku' => ['nullable', 'max:255'],
            '*.description' => ['nullable', 'max:255', 'string'],
            '*.minimum_stock_count' => ['nullable', 'numeric'],
            '*.reorder_point' => ['nullable', 'numeric'],            
            '*.category_name' => ['nullable', 'string'],
            '*.supplier_company_name' => ['nullable', 'string'],
            '*.cost_price' => ['nullable', 'numeric'],
            '*.cost_price_includes_vat' => ['nullable', 'string'],
            '*.vat_rate' => ['nullable', 'numeric'],
            '*.gross_cost' => ['nullable', 'numeric'],
            '*.net_cost' => ['nullable', 'numeric'],
            '*.pack_yesno' => ['nullable', 'max:255', 'string'],
            '*.pack_size' => ['nullable', 'numeric']
        ];
    }
}
