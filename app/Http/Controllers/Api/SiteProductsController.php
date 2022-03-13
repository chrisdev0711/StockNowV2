<?php
namespace App\Http\Controllers\Api;

use App\Models\Site;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCollection;

class SiteProductsController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Site $site
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Site $site)
    {
        $this->authorize('view', $site);

        $search = $request->get('search', '');

        $products = $site
            ->products()
            ->search($search)
            ->latest()
            ->paginate();

        return new ProductCollection($products);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Site $site
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Site $site, Product $product)
    {
        $this->authorize('update', $site);

        $site->products()->syncWithoutDetaching([$product->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Site $site
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Site $site, Product $product)
    {
        $this->authorize('update', $site);

        $site->products()->detach($product);

        return response()->noContent();
    }
}
