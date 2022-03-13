<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductCategory;
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
            ->paginate(50);

        return view(
            'app.product_categories.index',
            compact('productCategories', 'search')
        );
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', ProductCategory::class);

        return view('app.product_categories.create');
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

        return redirect()
            ->route('product-categories.edit', $productCategory)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ProductCategory $productCategory
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, ProductCategory $productCategory)
    {
        $this->authorize('view', $productCategory);

        return view('app.product_categories.show', compact('productCategory'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ProductCategory $productCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, ProductCategory $productCategory)
    {
        $this->authorize('update', $productCategory);

        return view('app.product_categories.edit', compact('productCategory'));
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

        return redirect()
            ->route('product-categories.edit', $productCategory)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('product-categories.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
