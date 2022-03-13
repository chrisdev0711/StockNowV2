<?php
namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Models\Sellable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;

class SellableProductsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Sellable $sellable
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Sellable $sellable)
    {
        $this->authorize('view', $sellable);

        $search = $request->get('search', '');

        $products = $sellable
            ->products()
            ->search($search)
            ->latest()
            ->paginate();

        return new ProductCollection($products);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Sellable $sellable
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        Sellable $sellable,
        Product $product
    ) {
        $this->authorize('update', $sellable);

        $sellable->products()->syncWithoutDetaching([$product->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Sellable $sellable
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Sellable $sellable,
        Product $product
    ) {
        $this->authorize('update', $sellable);

        $sellable->products()->detach($product);

        return response()->noContent();
    }
}
