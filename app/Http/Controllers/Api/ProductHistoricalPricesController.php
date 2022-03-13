<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\HistoricalPriceResource;
use App\Http\Resources\HistoricalPriceCollection;

class ProductHistoricalPricesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Product $product)
    {
        $this->authorize('view', $product);

        $search = $request->get('search', '');

        $historicalPrices = $product
            ->historicalPrices()
            ->search($search)
            ->latest()
            ->paginate();

        return new HistoricalPriceCollection($historicalPrices);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product)
    {
        $this->authorize('create', HistoricalPrice::class);

        $validated = $request->validate([
            'original_price' => ['required', 'numeric'],
            'new_price' => ['required', 'numeric'],
            'changed_by_name' => ['required', 'max:255', 'string'],
            'changed_by' => ['required', 'max:255'],
        ]);

        $historicalPrice = $product->historicalPrices()->create($validated);

        return new HistoricalPriceResource($historicalPrice);
    }
}
