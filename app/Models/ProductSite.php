<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductSite extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'site_id', 
        'product_id', 
        'par_level',
        'reorder_point',
        'active',
        'last_stock_level',
        'current_stock_level'
    ];

    protected $searchableFields = ['*'];

    protected $table = 'product_site';    

    protected $casts = [
        'active' => 'boolean',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function sites()
    {
        return $this->hasMany(Site::class);
    }

}
