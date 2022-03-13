<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductSite;
use App\Models\Site;
use App\Models\Supplier;
use App\Models\TaxRate;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use App\Http\Requests\ProductStoreRequest;
use App\Http\Requests\ProductUpdateRequest;

use App\imports\ProductsImport;
use Maatwebsite\Excel\Validators\ValidationException;
use Session;
use Auth;
class ProductController extends Controller
{


    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function oldnewindex(Request $request)
    {
        $this->authorize('view-any', Product::class);

        $search = $request->get('search', '');

        $boxIsEmpty = true;
        $productsObj = collect(new Product);

        $site = Auth::user()->activeLocation();
        $productSites = ProductSite::where('site_id', '=', $site->id)->get();
        foreach($productSites as $productSite)
        {
            $product = Product::find($productSite->product_id);
            if($product->in_cart != 0)
                $boxIsEmpty = false;
            $exist = $productsObj->firstWhere('id', $product->id);
            if(!$exist)
                $productsObj->push($product);
        }

        if($search)
        {
            $productsObj = $productsObj->filter(function($product) use ($search){

                $category = ProductCategory::find($product->product_category_id);
                $supplier = Supplier::find($product->supplier_id);

                if(stripos($product->name, $search) !== false || stripos($product->entered_cost, $search) !== false || stripos($category->name, $search) !== false || stripos($supplier->company, $search) !== false) {
                    return true;
                }
                return false;
            });
        }
        $productsObj = $productsObj->sortByDesc('updated_at');
        //dd($productsObj);
        $products = $this->paginate($productsObj);
        //$products = $this;
//        dd($products);
//        return view('app.products.index', compact('products', 'search', 'site', 'boxIsEmpty'));
        return view('app.products.index', compact('products', 'search', 'site'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function newindex(Request $request)
    {
        $this->authorize('view-any', Product::class);

        $search = $request->get('search', '');
        $site = Auth::user()->activeLocation();
        $products = Product::search($search)
            ->latest()
            ->paginate(50);

        return view('app.products.stock', compact('products', 'search', 'site'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Product::class);

        $search = $request->get('search', '');

        $products = Product::search($search)
            ->latest()
            ->paginate(50);

        return view('app.products.index', compact('products', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Product::class);

        $productCategories = ProductCategory::pluck('name', 'id');
        $suppliers = Supplier::pluck('company', 'id');

        $vat_rates = TaxRate::all();
        $locations = Site::where('status', '=', true)->get();

        return view(
            'app.products.create',
            compact('productCategories', 'suppliers', 'vat_rates', 'locations')
        );
    }

    /**
     * @param \App\Http\Requests\ProductStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStoreRequest $request)
    {
        $this->authorize('create', Product::class);
        $validated = $request->validated();
        if($validated['entered_inc_vat'])
        {
            $validated['gross_cost'] = $validated['entered_cost'];
            $validated['net_cost'] = $validated['entered_cost'] * (1 - $validated['vat_rate']/100);
        } else {
            $validated['net_cost'] = $validated['entered_cost'];
            $validated['gross_cost'] = $validated['entered_cost'] * (1 + $validated['vat_rate']/100);
        }
        $product = Product::create($validated);

        $locations = $validated['locations'];

        foreach($locations as $location)
        {
            if($location != '0')
            {
                $site = Site::where('name', '=', $location)->first();
                ProductSite::Create([
                    'site_id' => $site->id,
                    'product_id' => $product->id,
                    'par_level' => $product->par_level ?? 0,
                    'reorder_point' => $product->reorder_point
                ]);
            }
        }

        return redirect()
            ->route('products.edit', $product)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Product $product)
    {
        $this->authorize('view', $product);

        return view('app.products.show', compact('product'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Product $product)
    {
        $this->authorize('update', $product);

        $productCategories = ProductCategory::pluck('name', 'id');
        $suppliers = Supplier::pluck('company', 'id');
        $vat_rates = TaxRate::all();
        $locations = Site::where('status', '=', true)->get();
        return view(
            'app.products.edit',
            compact('product', 'productCategories', 'suppliers', 'vat_rates', 'locations')
        );
    }

    /**
     * @param \App\Http\Requests\ProductUpdateRequest $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        $this->authorize('update', $product);

        $validated = $request->validated();

        if($validated['entered_inc_vat'])
        {
            $validated['gross_cost'] = $validated['entered_cost'];
            $validated['net_cost'] = $validated['entered_cost'] * (1 - $validated['vat_rate']/100);
        } else {
            $validated['net_cost'] = $validated['entered_cost'];
            $validated['gross_cost'] = $validated['entered_cost'] * (1 + $validated['vat_rate']/100);
        }
        $product->update($validated);

        $oldLocations = $product->sites;
        foreach($oldLocations as $location)
        {
            $productSite = ProductSite::where('site_id', $location->id)->where('product_id', $product->id)->first();
            $productSite->delete();
        }
        $newLocations = $validated['locations'];

        foreach($newLocations as $location)
        {
            if($location != '0')
            {
                $site = Site::where('name', '=', $location)->first();
                ProductSite::Create([
                    'site_id' => $site->id,
                    'product_id' => $product->id,
                    'par_level' => $product->par_level ?? 0,
                    'reorder_point' => $product->reorder_point
                ]);
            }
        }

        return redirect()
            ->route('products.edit', $product)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Product $product)
    {
        $this->authorize('delete', $product);

        $product->delete();

        return redirect()
            ->route('products.index')
            ->withSuccess(__('crud.common.removed'));
    }

    public function importProductsView(Request $request)
    {
        $sites = Auth::user()->locations();
        return view('app.products.import', compact('sites'));
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function importProducts(Request $request)
    {
        if(!$request->import_file){
            Session::flash('message', "File not selected!");
            return redirect()->back();
        }
        try {
            $import = new ProductsImport;
            \Excel::import($import, $request->import_file);

            if($import->msg != null)
            {
                Session::flash('message', $import->msg);
                return redirect()->back();
            }

            $newProducts = $import->data;
            $locations = Auth::user()->locations();
            $selected_location = $request->site_id;

            if($selected_location == "All Sites")
            {
                foreach($locations as $location)
                {
                    foreach($newProducts as $product)
                    {
                        ProductSite::updateOrCreate([
                            'site_id' => $location->id,
                            'product_id' => $product->id
                        ],[
                            'site_id' => $location->id,
                            'product_id' => $product->id,
                            'par_level' => $product->par_level,
                            'reorder_point' => $product->reorder_point
                        ]);
                    }
                }
            } else {
                $location = Site::find($selected_location);
                foreach($newProducts as $product)
                {
                    ProductSite::updateOrCreate([
                        'site_id' => $location->id,
                        'product_id' => $product->id
                    ],[
                        'site_id' => $location->id,
                        'product_id' => $product->id,
                        'par_level' => $product->par_level,
                        'reorder_point' => $product->reorder_point
                    ]);
                }
            }
        } catch(ValidationException $e)
        {
            $failure = $e->failures();
            $errors = $failure[0]->errors();
            Session::flash('message', $errors[0]);

            return redirect()->back();
        }

        return redirect()
            ->route('products.index')
            ->withSuccess(__('crud.products.imported'));
    }
}
