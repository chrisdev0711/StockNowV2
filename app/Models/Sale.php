<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sale extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'order_id', 
        'transaction_time', 
        'location_id', 
        'catalog_object_id', 
        'quantity', 
        'name', 
        'sub_name', 
        'gross_sale_money', 
        'total_tax_money', 
        'currency',        
        'net_sale_money'
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'active' => 'boolean',
    ];
}
