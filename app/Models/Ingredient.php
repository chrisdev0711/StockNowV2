<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ingredient extends Model
{
    use HasFactory;
    use Searchable;

    public $timestamps = false;
    
    protected $fillable = [
        'sellable_id',
        'product_id',
        'measure',
        'cost_price'
    ];

    protected $searchableFields = ['*'];

    public function sellable()
    {
        return $this->belongsTo(Sellable::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
