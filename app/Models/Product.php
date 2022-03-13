<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use App\Models\ProductSite;

class Product extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'name',
        'sku',
        'description',
        'serving_name',
        'par_level',
        'reorder_point',
        'product_category_id',
        'supplier_id',
        'supplier_sku',
        'entered_cost',
        'entered_inc_vat',
        'vat_rate',
        'gross_cost',
        'net_cost',
        'pack_type',
        'multipack',
        'units_per_pack',
        'servings_per_unit',
        'in_cart'
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'entered_inc_vat' => 'boolean',
        'multipack' => 'boolean',
    ];

    public function productCategory()
    {
        return $this->belongsTo(ProductCategory::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function historicalPrices()
    {
        return $this->hasMany(HistoricalPrice::class);
    }

    public function sites()
    {
        return $this->belongsToMany(Site::class);
    }

    public function sellables()
    {
        return $this->belongsToMany(Sellable::class, 'ingredients');
    }

    public function getCurrentStockLevel($siteId)
    {
        $producSite = ProductSite::where('site_id', $siteId)->where('product_id', $this->id)->first();

        if($producSite)
        {
            return $producSite->current_stock_level;
        }

        return 0;
    }

    public function exitsTo($siteId)
    {
        $locations = $this->sites;
        foreach($locations as $location)
            if($location->id == $siteId)
                return true;
        return false;
    }
}
