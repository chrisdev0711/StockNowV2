<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\ProductSite;
use App\Models\Site;
use App\Models\Supplier;
use App\Models\ProductCategory;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Requests\OrderStoreRequest;
use App\Http\Requests\OrderUpdateRequest;
use App\Http\Requests\OrderItemStoreRequest;
use App\Http\Requests\OrderItemUpdateRequest;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Pagination\LengthAwarePaginator;
use Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
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
        // $productsObj = $productsObj->sortByDesc('updated_at');        
        $products = $this->paginate($productsObj);

        return view('app.orders.index', compact('products', 'search', 'site', 'boxIsEmpty'));
    }

    public function paginate($items, $perPage = 10, $page = null)
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, [
            'path' => Paginator::resolveCurrentPath()
        ]);
    }    

    public function addToCart(Request $request)
    {
        $oneOrall = isset($request->addOne);
        if($oneOrall)
        {
            
            $order_value = null;
            $orders = $request->order_num;            
            foreach($orders as $order)
            {
                if($order)
                $order_value = $order;
            }
            
            if(!$order_value)
            {
                return redirect()->back()->withError('please input the value!');
            }
            
            $product_id = $request->addOne[0];
            $product = Product::find($product_id);
            if($product->in_cart != 0)
                $product->in_cart = $product->in_cart + $order_value;
            else
                $product->in_cart = $order_value;

            $product->save();
            return redirect()->back()->withSuccess('added to the basket Successfully!');
            
        } else {
            $orders = $request->order_num;
            $products = $request->products;

            $allEmpty = true;
            foreach($orders as $index => $order)
            {
                if($order != null)
                {
                    $productObj = json_decode($products[$index]);
                    $product = Product::find($productObj->id);
                    if($product->in_cart != 0)
                        $product->in_cart = $product->in_cart + $order;
                    else
                        $product->in_cart = $order;
                    $product->save();
                    $allEmpty = false;
                }
            }

            if($allEmpty)
                return redirect()->back()->withError('please input the value!');
            else
                return redirect()->back()->withSuccess('added to the basket Successfully!');
        }  
    } 
    
    public function clearCart(Request $request)
    {
        $site = Auth::user()->activeLocation();        
        $productSites = ProductSite::where('site_id', '=', $site->id)->get();
        foreach($productSites as $productSite)
        {
            $product = Product::find($productSite->product_id);
            if($product->in_cart)
                $product->in_cart = 0;                                        
            $product->save();
        }
        return redirect('orders')->withSuccess('Clear Basket Success!');
    }
  
    public function viewCart(Request $request)
    {
        $this->authorize('view-any', Product::class);

        $search = $request->get('search', '');

        $productsObj = collect(new Product);

        $site = Auth::user()->activeLocation();        
        $productSites = ProductSite::where('site_id', '=', $site->id)->get();
        foreach($productSites as $productSite)
        {
            $product = Product::find($productSite->product_id);                            
            $exist = $productsObj->firstWhere('id', $product->id);
            if(!$exist && $product->in_cart != 0)
                $productsObj->push($product);
        }                    
        
        if($search)
        {                  
            $productsObj = $productsObj->filter(function($product) use ($search){   
                
                $category = ProductCategory::find($product->product_category_id);
                $supplier = Supplier::find($product->supplier_id);
                
                if(stripos($product->name, $search) !== false || stripos($product->entered_cost, $search) !== false || stripos($category->name, $search) !== false || stripos($supplier->company, $search) !== false || stripos($supplier->in_cart, $search) !== false) {
                    return true;
                }  
                return false;              
            });
        }
        // $productsObj = $productsObj->sortByDesc('updated_at');        
        $products = $this->paginate($productsObj);

        return view('app.orders.cart', compact('products', 'search', 'site'));
    }

    public function updateOne(Request $request)
    {
        if(!$request->update_num)
            return redirect()->back()->withError('please input the value!');

        $product_id = $request->product_id;
        $product = Product::find($product_id);

        $product->in_cart = $request->update_num;
        $product->save();

        return redirect()->back()->withSuccess('Successfully updated!');
    }

    public function removeOne(Request $request)
    {
        $product_id = $request->product_id;
        $product = Product::find($product_id);

        $product->in_cart = 0;
        $product->save();

        return redirect('orders/viewCart')->withSuccess('Successfully removed!');
    }

    public function confirmOrder(Request $request)
    {
        $productsObj = collect(new Product);

        $site = Auth::user()->activeLocation();        
        $productSites = ProductSite::where('site_id', '=', $site->id)->get();
        foreach($productSites as $productSite)
        {
            $product = Product::find($productSite->product_id);                            
            $exist = $productsObj->firstWhere('id', $product->id);
            if(!$exist && $product->in_cart != 0)
                $productsObj->push($product);
        } 

        $productsObj = $productsObj->groupBy('supplier_id');
        foreach($productsObj as $index => $productObj)
        {
            $order = Order::create([
                'supplier_id' => $index,
                'uuid' => Str::uuid(),
                'status' => 'draft',
                'created_by_id' => Auth::user()->id,
                'order_date' => date('Y-m-d h:i:s')
            ]);
            foreach($productObj as $product)
            {
                $total_price = (double)$product->entered_cost * (double)$product->in_cart;
                $orderItem = OrderItem::create([
                    'order_id' => $order->id, 
                    'product_id' => $product->id, 
                    'unit_price' => $product->entered_cost,
                    'qty' => $product->in_cart,
                    'total_price' => $total_price,
                    'status' => 'pending'
                ]);                
                $product->in_cart = 0;
                $product->save();
            }
        }

        return redirect('orders')->withSuccess('Place Order Success!');
    }

    public function history(Request $request)
    {
        $this->authorize('view-any', Order::class);

        $search = $request->get('search', '');

        $orders = Order::Where('created_by_id', '=', Auth::user()->id)->get();
        
        if($search)
        {
            $orders = $orders->filter(function($order) use ($search) {

                if(stripos(($order->supplier)->company, $search) !== false) 
                    return true;

                if(stripos($order->order_date, $search) !== false) 
                    return true;

                if(stripos("no",$search) !== false && $order->status == 'draft')
                    return true;

                if(stripos("yes", $search) !== false && $order->status != 'draft' && $order->status != 'cancelled')
                    return true;

                if(stripos("part", $search) !== false && $order->status == 'part-received')
                    return true;
            
                return false;
            });            
        }

        $orders = $orders->sortByDesc('updated_at');
        
        $orders = $this->paginate($orders);

        return view('app.orders.history', compact('orders', 'search'));
    }

    public function sendMail($order) {
        $site = Auth::user()->activeLocation();
        $orderItem = DB::table('order_items')
                    ->where('order_items.order_id', '=', $order->id)
                    ->get();
        $product = DB::table('products')
                    ->where('products.id', '=', $orderItem[0]->product_id)
                    ->get();
        $site = DB::table('sites')
                    ->where('sites.id', '=', $site->id)
                    ->get();
        $details = [
            'order_id' => $order->id,
            'supplier' => ($order->supplier)->company,
            'supplier_address' => ($order->supplier)->address_1,
            'supplier_city' => ($order->supplier)->city,
            'supplier_county' => ($order->supplier)->county,
            'supplier_postcode' => ($order->supplier)->postcode,
            'order_date' => date("d/m/Y", strtotime($order->order_date)),
            'delivery_date' => date("d/m/Y", strtotime($order->delivery_date)),
            'qty' => round($orderItem[0]->qty),
            'unit_price' => $orderItem[0]->unit_price,
            'total' => (double)round($orderItem[0]->qty) * (double)$orderItem[0]->unit_price,
            'site_name' => $site[0]->name,
            'site_addresss' => $site[0]->address_1,
            'site_city' => $site[0]->city,
            'site_postcode' => $site[0]->postcode,
            'sku' => $product[0]->sku,
            'description' => $product[0]->description,
            'vat' => $product[0]->vat_rate,
            'note' => $order->note,
            'term' => substr(($order->supplier)->payment_terms, 0, strpos(($order->supplier)->payment_terms, " Days")),
        ];
        $email_address = ($order->supplier)->order_email_1;
        \Mail::to($email_address)->send(new \App\Mail\PurchaseOrderEmail($details));
    }
    public function viewmail(Request $request)
    {
        $order = Order::find($request->order_id);
        $this->authorize('update', $order);

        $site = Auth::user()->activeLocation();
        $orderItem = DB::table('order_items')
                    ->where('order_items.order_id', '=', $order->id)
                    ->get();
        $product = DB::table('products')
                    ->where('products.id', '=', $orderItem[0]->product_id)
                    ->get();
        $site = DB::table('sites')
                    ->where('sites.id', '=', $site->id)
                    ->get();
        $details = [
            'order_id' => $order->id,
            'supplier' => ($order->supplier)->company,
            'supplier_address' => ($order->supplier)->address_1,
            'supplier_city' => ($order->supplier)->city,
            'supplier_county' => ($order->supplier)->county,
            'supplier_postcode' => ($order->supplier)->postcode,
            'order_date' => date("d/m/Y", strtotime($order->order_date)),
            'delivery_date' => date("d/m/Y", strtotime($order->delivery_date)),
            'qty' => round($orderItem[0]->qty),
            'unit_price' => $orderItem[0]->unit_price,
            'total' => (double)round($orderItem[0]->qty) * (double)$orderItem[0]->unit_price,
            'site_name' => $site[0]->name,
            'site_addresss' => $site[0]->address_1,
            'site_city' => $site[0]->city,
            'site_postcode' => $site[0]->postcode,
            'sku' => $product[0]->sku,
            'description' => $product[0]->description,
            'vat' => $product[0]->vat_rate,
            'note' => $order->note,
            'term' => substr(($order->supplier)->payment_terms, 0, strpos(($order->supplier)->payment_terms, " Days")),
        ];
            return view('emails.purchase-order-email', compact('details'));

    }
    public function send(Request $request)
    {
        $order = Order::find($request->order_id);
        $this->authorize('update', $order);

        $order->status = 'ordered';
        $order->sent = true;
        $order->order_date = date("Y-m-d H:i:s");
        $order->save();
        $this->sendMail($order);

        return redirect()->back()->withSuccess('Successfully Sent Purchase Order and Mail to Supplier!');
    }

    public function detail(Request $request)
    {
        $search = $request->get('search', '');

        $order = Order::find($request->order_id);

        $items = $order->orderItems;

        if($search)
        {
            $items = $items->filter(function($item) use ($search){   
                
                if(stripos(optional($item->product)->name, $search) !== false || stripos($item->qty, $search) !== false || stripos($item->received_qty, $search) !== false || stripos(optional($item->received_by)->name, $search) !== false || stripos($item->received_on, $search) !== false || stripos($item->total_price, $search) !== false) {
                    return true;
                }  
                return false;              
            });
        }
        $net = 0;
        $vat = 0;
        $total = 0;
        foreach ($items as $item) {
            $product = Product::find($item->product_id);
            $vat_rate = $product->vat_rate;
            $cost = $product->entered_cost;
            $vat += $vat_rate * $cost / 100;
            $net += $cost;
        }        
        
        $total = $vat + $net;
        $items = $this->paginate($items);
            
        $this->authorize('update', $order);

        return view('app.orders.edit', compact('order', 'search', 'items', 'net', 'vat', 'total'));
    }

    public function update(Request $request)
    {
        $order = Order::find($request->order_id);
        
        $this->authorize('update', $order);

        $order->delivery_date = $request->delivery_date;
        $order->note = $request->note;
        $order->save();
        
        return redirect()->back()->withSuccess('Order Update Success!');
    }

    public function updateItem(Request $request)
    {
        if(!$request->update_num)
            return redirect()->back()->withError('Must be input update number!');
        $orderItem = OrderItem::find($request->item_id);
        $orderItem->qty = $request->update_num;
        $orderItem->save();

        return redirect()->back()->withSuccess('Order Item Update Success!');
    }

    public function receive(Request $request)
    {
        $this->authorize('view-any', Order::class);

        $search = $request->get('search', '');

        $orders = Order::Where('created_by_id', '=', Auth::user()->id)->Where('status', '!=', 'complete')->Where('status', '!=', 'cancelled')->get();
        
        if($search)
        {
            $orders = $orders->filter(function($order) use ($search) {

                if(stripos(($order->supplier)->company, $search) !== false) 
                    return true;

                if(stripos($order->order_date, $search) !== false) 
                    return true;

                if(stripos($order->id ,$search) !== false)
                    return true;
                            
                return false;
            });            
        }

        $orders = $orders->sortByDesc('updated_at');
        
        $orders = $this->paginate($orders);

        return view('app.orders.receive', compact('orders', 'search'));
    }

    public function receiveItem(Request $request)
    {
        $search = $request->get('search', '');

        $order = Order::find($request->order_id);

        $orderItems = $order->orderItems;

        if($search)
        {
            $orderItems = $orderItems->filter(function($item) use ($search){   
                
                if(stripos(optional($item->product)->name, $search) !== false || stripos($item->qty, $search) !== false || stripos($item->received_qty, $search) !== false || stripos(optional($item->received_by)->name, $search) !== false || stripos($item->received_on, $search) !== false || stripos($item->total_price, $search) !== false) {
                    return true;
                }  

                if(stripos("Awaiting Delivery", $search) !== false && $item->status == 'pending')
                    return true;

                return false;              
            });
        }

        $orderItems = $this->paginate($orderItems);
            
        return view('app.orders.receiveItems', compact('orderItems', 'search', 'order'));
    }

    public function receiveAll(Request $request) {
        $item_ids = $request->item_id;
        $receive_nums = $request->receive_num;
        foreach ($item_ids as $key=>$item_id) {
            if(!$receive_nums[$key])
                $receive_nums[$key] = 0;
            //     return redirect()->back()->withError('Please Input Number Received!');
            
            $orderItem = OrderItem::find($item_id);

            $acceptable_num = ($orderItem->qty - $orderItem->received_qty);
            if($receive_nums[$key] > $acceptable_num)
                return redirect()->back()->withError('Valid Number is equal or below than ' . $acceptable_num);
            
            $orderItem->received_qty += $receive_nums[$key];
            $orderItem->received_by_id = Auth::user()->id;
            $orderItem->received_on = date("Y-m-d H:i:s");
            if($orderItem->qty == $receive_nums[$key])
                $orderItem->status = 'received';
            else
                $orderItem->status = 'partial';

            $orderItem->save();

            $activeSite = Auth::user()->activeLocation();
            $productSite = ProductSite::where('site_id', $activeSite->id)->where('product_id', $orderItem->product_id)->first();
            $productSite->last_stock_level = $productSite->current_stock_level;
            $productSite->current_stock_level = (double)$productSite->current_stock_level + (double)$request->receive_num; 

            $productSite->save();
        }           
        return redirect()->back()->withSuccess('Receive Success!');
    }

    public function receiveConfirm(Request $request)
    {
        if(!$request->receive_num)
            return redirect()->back()->withError('Please Input Number Received!');
        
        $orderItem = OrderItem::find($request->item_id);

        $acceptable_num = ($orderItem->qty - $orderItem->received_qty);
        if($request->receive_num > $acceptable_num)
            return redirect()->back()->withError('Valid Number is equal or below than ' . $acceptable_num);
        
        $orderItem->received_qty += $request->receive_num;
        $orderItem->received_by_id = Auth::user()->id;
        $orderItem->received_on = date("Y-m-d H:i:s");
        if($orderItem->qty == $request->receive_num)
            $orderItem->status = 'received';
        else
            $orderItem->status = 'partial';

        $orderItem->save();

        $activeSite = Auth::user()->activeLocation();
        $productSite = ProductSite::where('site_id', $activeSite->id)->where('product_id', $orderItem->product_id)->first();
        $productSite->last_stock_level = $productSite->current_stock_level;
        $productSite->current_stock_level += $request->receive_num; 

        $productSite->save();

        return redirect()->back()->withSuccess('Receive Success!');
    }

    public function destroy(Request $request)
    {
        $order = Order::find($request->order_id);
        
        $this->authorize('update', $order);

        $order->delete();
        
        return redirect()
            ->back()
            ->withSuccess(__('crud.common.removed'));
    }

    public function removeItem(Request $request)
    {
        $orderItem = OrderItem::find($request->item_id);

        $this->authorize('delete', $orderItem);

        $orderItem->delete();

        return redirect()
            ->back()
            ->withSuccess(__('crud.common.removed'));
    }
}
