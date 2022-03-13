<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCategoryResource;
use App\Http\Resources\ProductCategoryCollection;
use App\Http\Requests\ProductCategoryStoreRequest;
use App\Http\Requests\ProductCategoryUpdateRequest;

class ProductCategoryController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', ProductCategory::class);

        $search = $request->get('search', '');

        $productCategories = ProductCategory::search($search)
            ->latest()
            ->paginate();

        return new ProductCategoryCollection($productCategories);
    }

    /**
     * @param \App\Http\Requests\ProductCategoryStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductCategoryStoreRequest $request)
    {
        $this->authorize('create', ProductCategory::class);

        $validated = $request->validated();

        $productCategory = ProductCategory::create($validated);

        return new ProductCategoryResource($productCategory);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ProductCategory $productCategory
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, ProductCategory $productCategory)
    {
        $this->authorize('view', $productCategory);

        return new ProductCategoryResource($productCategory);
    }

    /**
     * @param \App\Http\Requests\ProductCategoryUpdateRequest $request
     * @param \App\Models\ProductCategory $productCategory
     * @return \Illuminate\Http\Response
     */
    public function update(
        ProductCategoryUpdateRequest $request,
        ProductCategory $productCategory
    ) {
        $this->authorize('update', $productCategory);

        $validated = $request->validated();

        $productCategory->update($validated);

        return new ProductCategoryResource($productCategory);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ProductCategory $productCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, ProductCategory $productCategory)
    {
        $this->authorize('delete', $productCategory);

        $productCategory->delete();

        return response()->noContent();
    }
}
