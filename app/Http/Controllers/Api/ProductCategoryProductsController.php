<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductCollection;

class ProductCategoryProductsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ProductCategory $productCategory
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, ProductCategory $productCategory)
    {
        $this->authorize('view', $productCategory);

        $search = $request->get('search', '');

        $products = $productCategory
            ->products()
            ->search($search)
            ->latest()
            ->paginate();

        return new ProductCollection($products);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ProductCategory $productCategory
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ProductCategory $productCategory)
    {
        $this->authorize('create', Product::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
            'sku' => ['nullable', 'max:255', 'string'],
            'description' => ['nullable', 'max:255', 'string'],
            'par_level' => ['nullable', 'numeric'],
            'reorder_point' => ['nullable', 'numeric'],
            'supplier_id' => ['nullable', 'exists:suppliers,id'],
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

        $product = $productCategory->products()->create($validated);

        return new ProductResource($product);
    }
}
