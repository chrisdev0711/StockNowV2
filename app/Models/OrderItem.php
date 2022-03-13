<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'order_id', 
        'product_id', 
        'unit_price',
        'qty',
        'total_price',
        'received_qty',
        'received_by_id',
        'received_on',
        'status',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'order_items';

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function received_by()
    {
        return $this->belongsTo(User::class);
    }
}
