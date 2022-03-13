<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\ProductSite;
use App\Models\Site;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Supplier;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Auth;

class PurchaseOrderController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $order_uuid  = $request->uuid;

      $order = DB::table('orders')
            ->where('orders.uuid', '=', $order_uuid)
            ->get();
      $order_id = $order[0]->id;
      $supplier_id = $order[0]->supplier_id;
      $orderItem = DB::table('order_items')
            ->where('order_items.order_id', '=', $order_id)
            ->get();
      $supplier = DB::table('suppliers')
            ->where('suppliers.id', '=', $supplier_id)
            ->get();
      $supplier_company = $supplier[0]->company;
      $supplier_address = $supplier[0]->address_1;
      $supplier_city = $supplier[0]->city;
      $supplier_county = $supplier[0]->county;
      $supplier_postcode = $supplier[0]->postcode;
      return view('emails.purchase-order-list', compact('supplier_company'));
    }
}
