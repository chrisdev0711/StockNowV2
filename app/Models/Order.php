<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'supplier_id',
        'uuid',
        'status',
        'created_by_id',
        'order_date',
        'delivery_date', 
        'sent',
        'note',       
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'sent' => 'boolean',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function created_by()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function orderTotal()
    {
        $orderTotal = 0;
        $items = $this->orderItems;
        foreach($items as $item)
            $orderTotal += $item->total_price;

        return $orderTotal;
    }
}
