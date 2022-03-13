<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\OrderController;

use App\Models\StockTake;
use App\Models\StockCount;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Supplier;
use App\Models\Zone;
use App\Models\ProductSite;
use App\Models\Order;
use App\Models\OrderItem;

use Illuminate\Support\Str;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Session;
use Auth;

class StockTakeController extends Controller
{
    public function index(Request $request)
    {
        dd('index');
    }

    public function filter(Request $request)
    {
        $this->authorize('view-any', StockTake::class); 
        
        $categories = ProductCategory::all();
        $suppliers = Supplier::all();

        $location = Auth::user()->activeLocation();
        $areas = Zone::where('site_id', $location->id)->get();

        return view('app.stock_takes.filter', compact('categories', 'suppliers', 'areas'));
    }
    

    public function create(Request $request)
    {        
        if($request->type_filter == null)
            return redirect()->back()->withError('Please select the type!');

        if($request->area_filter == null)
            return redirect()->back()->withError('Please select the area filter!');

        if($request->area_filter == 'By Area' && $request->areaSub_filter == null)
            return redirect()->back()->withError('Current location has no any area!');

        $stockTake = StockTake::create([
            'started_on' => date('Y-m-d h:i:s'), 
            'started_by_id' => Auth::user()->id, 
            'area' => $request->area_filter,
            'area_name' => $request->areaSub_filter,
            'type' => $request->type_filter,
            'sub_type' => $request->subType_filter,
            'location' => Auth::user()->activeLocation()->id
        ]);

        $site = Auth::user()->activeLocation();        
        $productSites = ProductSite::where('site_id', '=', $site->id)->get();

        $productSites = $productSites->filter(function($productSite) use($stockTake){                   
            $product = Product::find($productSite->product_id);                        
            
            if($stockTake->type == 'Full Stocktake' || $stockTake->sub_type == 'All Categories' || $stockTake->sub_type == 'All Suppliers')
                return true; 

            if($stockTake->type == 'By Supplier')
            {
                $supplier = Supplier::where('company', '=', $stockTake->sub_type)->first();
                if($product->supplier_id == $supplier->id)
                    return true;
            }  

            if($stockTake->type == 'By Category')
            {
                $category = ProductCategory::where('name', '=', $stockTake->sub_type)->first();
                if($product->category_id == $category->id)
                    return true;
            }
                          
            return false;   
        });

        $stockCounts = collect();
        $area = $stockTake->area == 'All Areas' ? 'All' : $stockTake->area_name;
        foreach($productSites as $productSite)
        {
            $stockCount = StockCount::create([
                'stock_take_id' => $stockTake->id, 
                'product_id' => $productSite->product_id, 
                'zone' => $area,
                'count' => $productSite->current_stock_level
            ]);

            $stockCounts->push($stockCount);
        }        

        if(count($stockCounts) == 0)
        {
            $stockTake->delete();

            return redirect()->back()->withError('No matching Items found');
        }        

        session(['stock_take_id' => $stockTake->id]);

        return redirect()->route('stockTakes.stockCounts');
    }

    public function stockCounts(Request $request)
    {
        $search = $request->get('search', '');

        $stockTake_id = session('stock_take_id');
        $stockTake = StockTake::find($stockTake_id);
        $stockCounts = $stockTake->stockCounts;

        if($search)
        {
            $stockCounts = $stockCounts->filter(function($stockCount) use($search) {
                $product = Product::find($stockCount->product_id);
                $supplier = $product->supplier->company;
                $category = $product->productCategory->name;
                if(stripos($product->name, $search) !== false || stripos($product, $search) !== false || stripos($category, $search) !== false || stripos($stockCount->count, $search) !== false)
                    return true;
                return false;
            });
        }
        
        $stockCounts = $this->paginate($stockCounts);

        return view('app.stock_takes.create', compact('stockCounts', 'search'));
    }

    public function paginate($items, $perPage = 10, $page = null)
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, [
            'path' => Paginator::resolveCurrentPath()
        ]);
    }

    public function adjust(Request $request)
    {
        try {
            $input_value = $request->validate([
                'stock_count_id' => ['numeric'],
                'adjustment_num' => ['required', 'numeric', 'max:255'],
            ]);
        } catch(\Exception  $e)
        {
            return redirect()->back()->withError('Input value is invalid!');
        }
        $stockCountId = $input_value['stock_count_id'];
        $stockCount = StockCount::find($stockCountId);
        if ($request->input('action') == "add")
            $stockCount->count += $input_value['adjustment_num'];
        else
            $stockCount->count -= $input_value['adjustment_num'];
        $stockCount->save();

        return redirect()->back()->withSuccess('Successfully Updated!');
    }

    public function removeStockTake(Request $request)
    {
        $stockTake_id = session('stock_take_id');
        $stockTake = StockTake::find($stockTake_id);
        $stockTake->delete();

        return redirect()->route('stockTakes.filter')->withSuccess('Successfully Removed!');
    }

    public function complete(Request $request)
    {
        $stockTake_id = session('stock_take_id');
        $stockTake = StockTake::find($stockTake_id);
        $stockTake->completed = true;
        $stockTake->save();

        return redirect()->route('stockTakes.history')->withSuccess('Complete Success!');
    }    

    public function history(Request $request)
    {
        $this->authorize('view-any', StockTake::class);
        
        $search = $request->get('search', '');

        $stockTakes = StockTake::all();

        if($search)
        {
            $stockTakes = $stockTakes->filter(function($stockTake) use($search) {
                if(stripos($stockTake->started_on, $search) !== false)
                    return true;
                if(stripos($stockTake->started_by->name, $search) !== false)
                    return true;
                if(stripos($stockTake->area, $search) !== false || stripos($stockTake->area_name, $search) !== false)
                    return true;
                if(stripos($stockTake->type, $search) !== false || stripos($stockTake->sub_type, $search) !== false)
                    return true;
                if(stripos("YES", $search) !== false && $stockTake->completed)
                    return true;
                if(stripos("NO", $search) !== false && !$stockTake->completed)
                    return true;
                if(stripos("YES", $search) !== false && $stockTake->approved)
                    return true;
                if(stripos("NO", $search) !== false && !$stockTake->approved)
                    return true;

                return false;
            });
        }

        $stockTakes = $stockTakes->sortByDesc('updated_at');
        $stockTakes = $this->paginate($stockTakes);

        return view('app.stock_takes.history', compact('stockTakes', 'search'));
    }

    public function approve(Request $request)
    {
        $site = Auth::user()->activeLocation();
        
        $stockTake_id = $request->stock_take_id;
        $stockTake = StockTake::find($stockTake_id);
        $stockCounts = $stockTake->stockCounts;
        
        $products = DB::table('products AS p')
                    ->join('stock_counts AS c', 'p.id', '=', 'c.product_id')
                    ->join('product_site AS s', 'p.id', '=', 's.product_id')
                    ->where('s.site_id', '=', $site->id)
                    ->where('c.stock_take_id', '=', $stockTake_id)
                    ->get();
        foreach ($products as $product) {
            if ($product->count <= $product->par_level) {
                $reorder = round($product->reorder_point - $product->count);
                $order = Order::create([
                    'supplier_id' => $product->supplier_id,
                    'uuid' => Str::uuid(),
                    'status' => 'draft',
                    'created_by_id' => Auth::user()->id,
                    'order_date' => date('Y-m-d h:i:s')
                ]);
                $total_price = (double)$product->entered_cost * (double)$reorder;
                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->product_id,
                    'unit_price' => $product->entered_cost,
                    'qty' => $reorder,
                    'total_price' => $total_price,
                    'status' => 'pending'
                ]);
                $product->in_cart = 0;

                $productSite = ProductSite::where('site_id', $site->id)->where('product_id', $orderItem->product_id)->first();
                $productSite->last_stock_level = $productSite->current_stock_level;
                $productSite->current_stock_level = (double)$productSite->current_stock_level + (double)$request->receive_num; 
                
                $productSite->save();    
            }
        }
        $stockTake->approved = true;
        $stockTake->save();

        return redirect()->route('orders.index')->withSuccess('Successfully Complete StockTake!');
    }

    public function detail(Request $request)
    {
        $search = $request->get('search', '');

        $stockTake_id = $request->stock_take_id;
        if($stockTake_id == null)
            $stockTake_id = session('detail_for');
        else 
            session(['detail_for' => $stockTake_id]);

        $stockTake = StockTake::find($stockTake_id);
        $stockCounts = $stockTake->stockCounts;

        if($search)
        {
            $stockCounts = $stockCounts->filter(function($stockCount) use($search) {
                $product = Product::find($stockCount->product_id);
                $supplier = $product->supplier->company;
                $category = $product->productCategory->name;
                if(stripos($product->name, $search) !== false || stripos($product, $search) !== false || stripos($category, $search) !== false || stripos($stockCount->count, $search) !== false)
                    return true;
                return false;
            });
        }
        
        $stockCounts = $this->paginate($stockCounts);

        return view('app.stock_takes.detail', compact('stockCounts', 'search'));
    }

    public function destroy(Request $request)
    {
        $stockTake_id = $request->stock_take_id;
        $stockTake = StockTake::find($stockTake_id);
        $stockTake->delete();

        return redirect()->back()->withSuccess('Delete StockTake Success!');
    }

    public function deleteStockTake(Request $request)
    {        
        $stockTake_id = session('detail_for');
        $stockTake = StockTake::find($stockTake_id);
        $stockTake->delete();

        return redirect()->route('stockTakes.history')->withSuccess('Successfully Removed!');
    }
}
