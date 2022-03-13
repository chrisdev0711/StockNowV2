<?php

namespace App\Services;

use App\Settings\SquareApiSettings;

use Square\SquareClient;
use Square\Exceptions\ApiException;
use Square\Http\ApiResponse;
use Square\Environment;
use Square\LocationsApi;
use Square\Models\ListLocationsResponse;
use Square\Models\CatalogObjectType;
use Square\Models\SearchOrdersRequest;
use Square\Models\SearchOrdersQuery;
use Square\Models\SearchOrdersFilter;
use Square\Models\OrderState;
use Square\Models\SearchOrdersStateFilter;
use Square\Models\SearchOrdersDateTimeFilter;
use Square\Models\TimeRange;

use App\Models\TaxRate;
use App\Models\Site;
use App\Models\SellableCategory;
use App\Models\Sellable;
use App\Models\Sale;

use App\Jobs\SalesApi;
use \Datetime;

class SquareService 
{   
    protected $client;

    public function __construct()
    {
        $client = new SquareClient([
            'accessToken' => app(SquareApiSettings::class)->access_token,
            'environment' => Environment::PRODUCTION,
        ]);
        $this->client = $client;
    }    

    public function fetchVatRates()
    {
        $catalogApi = $this->client->getCatalogApi(null, CatalogObjectType::CATEGORY, null);            
        
        $apiResponse = $catalogApi->listCatalog($cursor = null, $types = 'TAX', $catalogVersion = null);
        if ($apiResponse->isSuccess()) {
            $listCatalogResponse = $apiResponse->getResult();
            $taxs = $listCatalogResponse->getObjects(); 
            foreach($taxs as $index => $tax)
            {
                $taxData = $tax->getTaxData();
                if($taxData)
                {
                    $new_tax = TaxRate::firstOrCreate(['tax_id' => $tax->getId()],[
                        'tax_id' => $tax->getId(),
                        'rate' => 0
                    ]); 
                    $new_tax->rate = $taxData->getPercentage();
                    $new_tax->save();
                }
            }
        } else {
            $errors = $apiResponse->getErrors();
        }
    }

    public function fetchCategory()
    {
        $catalogApi = $this->client->getCatalogApi(null, CatalogObjectType::CATEGORY, null);            
        
        $category_cursor = null;

        do {
            $apiResponse = $catalogApi->listCatalog($cursor = $category_cursor, $types = 'CATEGORY', $catalogVersion = null);
            $category_cursor = $apiResponse->getCursor();
            if ($apiResponse->isSuccess()) {
                $listCatalogResponse = $apiResponse->getResult();
                $categories = $listCatalogResponse->getObjects();
                foreach($categories as $category)
                {
                    $uuid = $category->getId();
                    $categoryData = $category->getCategoryData();
                    $cat_name = $categoryData->getName();
                    $category = SellableCategory::firstOrCreate(['uuid' => $uuid],[
                        'uuid' => $uuid,
                        'name' => ''
                    ]); 
                    $category->name = $cat_name;
                    $category->save();
                }
            } else {
                $errors = $apiResponse->getErrors();
            }
        } while($category_cursor != null);        
    }    

    public function fetchLocation()
    {        
        $locationsApi = $this->client->getLocationsApi();
        $apiResponse = $locationsApi->listLocations();
        if($apiResponse->isSuccess()){
            $listLocationsResponse = $apiResponse->getResult();
            $locations = $listLocationsResponse->getLocations();
            foreach($locations as $location)
            {   
                $new_location = Site::firstOrCreate(['code' => $location->getId()], [
                    'code' => $location->getId(),
                    'name' => ''                    
                ]);

                $new_location->name = $location->getName();
                
                $address = $location->getAddress();                
                $new_location->address_1 = $address->getAddressLine1();
                $new_location->address_2 = $address->getAddressLine2();
                
                $new_location->city = $address->getLocality();

                $new_location->postcode = $address->getPostalCode();

                if($location->getStatus() == 'ACTIVE')
                    $new_location->status = true;
                else
                    $new_location->status = false;

                $new_location->country = $location->getCountry();

                $new_location->merchantId = $location->getMerchantId();

                $new_location->email = $location->getBusinessEmail();

                $new_location->phoneNumber = $location->getPhoneNumber();

                $new_location->logoUrl = $location->getLogoUrl();

                $new_location->save();
            }
        } else {
            $errors = $apiResponse->getErrors();
            return $errors;
        }

        return null;
    }

    public function fetchSellable()
    {
        $sellable_cursor = null;
        do {            
            $catalogApi = $this->client->getCatalogApi();            
            
            $apiResponse = $catalogApi->listCatalog($cursor = $sellable_cursor);
            
            if ($apiResponse->isSuccess()) {
                $listCatalogResponse = $apiResponse->getResult();
                $items = $listCatalogResponse->getObjects();
                $sellable_cursor = $listCatalogResponse->getCursor();
                foreach($items as $item)
                {   
                    $presentAtLocationsIds;
                    $presentAtAllLocations = $item->getPresentAtAllLocations();
                    if($presentAtAllLocations)
                    {
                        $locations = Site::where('status', '=', true)->get();
                        foreach($locations as $index => $location)
                        {
                            if($index == 0)
                                $presentAtLocationsIds = $location->code;
                            else
                                $presentAtLocationsIds .= ';' . $location->code;
                        }                    

                    } else {
                        $locationIds = $item->getPresentAtLocationIds();
                        if($locationIds)
                        {
                            foreach($locationIds as $index => $locationId)
                            {
                                if($index == 0)
                                    $presentAtLocationsIds = $locationId;
                                else
                                    $presentAtLocationsIds .= ';' . $locationId; 
                            }
                        }
                    }
                    $itemData = $item->getItemData();
                    if($itemData)
                    {
                        $item_name = $itemData->getName();
                        $item_description = $itemData->getDescription();
                        $item_categoryId = $itemData->getCategoryId();
                        
                        $variations = $itemData->getVariations();
                                        
                        foreach($variations as $index => $variation)
                        {     
                            $uuid = $variation->getId();
                            $variationData = $variation->getItemVariationData();
                            if($variationData)
                            {
                                $sellable = Sellable::firstOrCreate(['uuid' => $uuid],[
                                    'name' => '',
                                    'description' => '',
                                    'uuid' => $uuid,
                                ]);
        
                                $sellable->parent_id = $variationData->getItemId();
                                $sellable->name = $item_name;
                                $sellable->sub_name = $variationData->getName();
                                $sellable->description = $item_description ?: '';
                                $sellable->price = ($variationData->getPriceMoney()->getAmount())/100;
                                $sellable->presentLocationIds = $presentAtLocationsIds;
                                $sellable->category_id = $item_categoryId;
                                $sellable->save();
                            }                                         
                        }                
                    }                
                }
            } else {
                $errors = $apiResponse->getErrors();
            }
        } while($sellable_cursor != null);                     
    }

    public function fetchSales()
    {
        $locations = array();
        $locationItems = Site::where('status', '=', true)->get();
        foreach($locationItems as $locationItem)
            array_push($locations, $locationItem->code);
        $start_date = new DateTime("first day of last month");
        $start_time = $start_date->format('Y-m-d h:i:s');
        $start_time = str_replace(' ', 'T', $start_time);
        $end_time = date("Y-m-d h:i:s", time());
        $end_time = str_replace(' ', 'T', $end_time);
        $prve_exists = true;
        $api_cursor = null;
        do {
            $sale_cursor = null; 
            do {
                $ordersApi = $this->client->getOrdersApi($cursor = $sale_cursor);
                $body = new SearchOrdersRequest;
                $body->setLocationIds($locations);
                $body->setCursor($sale_cursor);
                $body->setQuery(new SearchOrdersQuery);
                $body->getQuery()->setFilter(new SearchOrdersFilter);
                $body_query_filter_stateFilter_states = [OrderState::COMPLETED];
                $body->getQuery()->getFilter()->setStateFilter(new SearchOrdersStateFilter(
                    $body_query_filter_stateFilter_states
                ));    

                $body->getQuery()->getFilter()->setDateTimeFilter(new SearchOrdersDateTimeFilter);
                $body->getQuery()->getFilter()->getDateTimeFilter()->setCreatedAt(new TimeRange);
                $body->getQuery()->getFilter()->getDateTimeFilter()->getCreatedAt()->setStartAt($start_time);
                $body->getQuery()->getFilter()->getDateTimeFilter()->getCreatedAt()->setEndAt($end_time);
                $body->setLimit(100);

                $apiResponse = $ordersApi->searchOrders($body);
                if($sale_cursor == null)
                    $api_cursor = $apiResponse->getCursor();
                $sale_cursor = $apiResponse->getCursor();

                if ($apiResponse->isSuccess()) {
                    $searchOrdersResponse = $apiResponse->getResult();

                    $salesJob = new SalesApi($searchOrdersResponse);
                    dispatch($salesJob);
                    
                } else {
                    $errors = $apiResponse->getErrors();
                }

            } while($sale_cursor != null);     
            $end_time = $start_time;
            $start_time = date("Y-m-d h:i:s", mktime(0,0,0,date("m", strtotime($start_time))-1, 1));
            $start_time = str_replace(' ', 'T', $start_time);                
        } while($api_cursor != null);    
    }
}