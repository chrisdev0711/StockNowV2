<?php
namespace App\Http\Controllers\Api;

use App\Models\Product;
use App\Models\Sellable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SellableCollection;

class ProductSellablesController extends Controller
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

        $sellables = $product
            ->sellables()
            ->search($search)
            ->latest()
            ->paginate();

        return new SellableCollection($sellables);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @param \App\Models\Sellable $sellable
     * @return \Illuminate\Http\Response
     */
    public function store(
        Request $request,
        Product $product,
        Sellable $sellable
    ) {
        $this->authorize('update', $product);

        $product->sellables()->syncWithoutDetaching([$sellable->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @param \App\Models\Sellable $sellable
     * @return \Illuminate\Http\Response
     */
    public function destroy(
        Request $request,
        Product $product,
        Sellable $sellable
    ) {
        $this->authorize('update', $product);

        $product->sellables()->detach($sellable);

        return response()->noContent();
    }
}
