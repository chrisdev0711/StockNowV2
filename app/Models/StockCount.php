<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockCount extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'stock_take_id', 
        'product_id', 
        'zone',
        'count',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'stock_counts';
    
    public function stockTake()
    {
        return $this->belongsTo(StockTake::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
