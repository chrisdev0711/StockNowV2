<?php
namespace App\Http\Controllers\Api;

use App\Models\Site;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SiteCollection;

class ProductSitesController extends Controller
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

        $sites = $product
            ->sites()
            ->search($search)
            ->latest()
            ->paginate();

        return new SiteCollection($sites);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @param \App\Models\Site $site
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Product $product, Site $site)
    {
        $this->authorize('update', $product);

        $product->sites()->syncWithoutDetaching([$site->id]);

        return response()->noContent();
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @param \App\Models\Site $site
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Product $product, Site $site)
    {
        $this->authorize('update', $product);

        $product->sites()->detach($site);

        return response()->noContent();
    }
}
