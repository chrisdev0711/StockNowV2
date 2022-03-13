<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Square\Models\SearchOrdersResponse;
use App\Models\Sale;

class SalesApi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $orders;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($orders)
    {
        $this->queue = 'default'; //choose a queue name
        $this->connection = 'database';
        $this->orders = new SearchOrdersResponse;
        $this->orders = $orders;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $sales = $this->orders->getOrders();
        if($sales)
        {
            foreach($sales as $sale)
            {
                $order_id = $sale->getId();
                $location_id = $sale->getLocationId();
                $transaction_time = date('Y-m-d H:i:s', strtotime($sale->getCreatedAt()));

                $lineItems = $sale->getLineItems();   
                if($lineItems)
                {
                    foreach($lineItems as $lineItem)
                    {                       
                        $catalogObjectId = $lineItem->getCatalogObjectId();
                        if($catalogObjectId)
                        {
                            $quantity = $lineItem->getQuantity();
                            $name = $lineItem->getName();
                            $sub_name = $lineItem->getVariationName();
                            
                            $gross_sale_money_item = $lineItem->getGrossSalesMoney();
                            $gross_sale_money = $gross_sale_money_item->getAmount();
        
                            $total_tax_money_item = $lineItem->getTotalTaxMoney();
                            $total_tax_money = $total_tax_money_item->getAmount();
        
                            $currency = $gross_sale_money_item->getCurrency();
        
                            $net_sale_money = $gross_sale_money - $total_tax_money;

                            $sale = Sale::firstOrCreate(['order_id' => $order_id],[
                                'order_id' => $order_id, 
                                'transaction_time' => $transaction_time, 
                                'location_id' => $location_id, 
                                'catalog_object_id' => $catalogObjectId, 
                                'quantity' => $quantity, 
                                'name' => $name, 
                                'sub_name' => $sub_name, 
                                'gross_sale_money' => $gross_sale_money, 
                                'total_tax_money' => $total_tax_money, 
                                'currency' => $currency,        
                                'net_sale_money' => $net_sale_money
                            ]);                                                                            
                        }                        
                    }
                }
            }
        }
    }
}
