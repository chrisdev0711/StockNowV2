<?php

namespace App\Http\Controllers\Api;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;

class SupplierProductsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Supplier $supplier
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Supplier $supplier)
    {
        $this->authorize('view', $supplier);

        $search = $request->get('search', '');

        $products = $supplier
            ->products()
            ->search($search)
            ->latest()
            ->paginate();

        return new ProductCollection($products);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Supplier $supplier
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Supplier $supplier)
    {
        $this->authorize('create', Product::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'sku' => ['nullable', 'max:255', 'string'],
            'description' => ['nullable', 'max:255', 'string'],
            'par_level' => ['nullable', 'numeric'],
            'reorder_point' => ['nullable', 'numeric'],
            'product_category_id' => [
                'nullable',
                'exists:product_categories,id',
            ],
            'supplier_sku' => ['nullable', 'max:255', 'string'],
            'entered_cost' => ['nullable', 'numeric'],
            'entered_inc_vat' => ['nullable', 'boolean'],
            'vat_rate' => ['nullable', 'numeric'],
            'gross_cost' => ['nullable', 'numeric'],
            'net_cost' => ['nullable', 'numeric'],
            'pack_type' => ['nullable', 'max:255', 'string'],
            'multipack' => ['nullable', 'boolean'],
            'units_per_pack' => ['nullable', 'numeric'],
            'servings_per_unit' => ['nullable', 'numeric'],
        ]);

        $product = $supplier->products()->create($validated);

        return new ProductResource($product);
    }
}
