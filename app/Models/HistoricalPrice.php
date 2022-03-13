<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HistoricalPrice extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'original_price',
        'new_price',
        'changed_by_name',
        'changed_by',
        'product_id',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'historical_prices';

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
