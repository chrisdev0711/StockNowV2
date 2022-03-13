<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockTake extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'started_on', 
        'started_by_id', 
        'area',
        'area_name',
        'type',
        'sub_type',
        'completed',
        'approved',
        'location'
    ];

    protected $searchableFields = ['*'];

    protected $table = 'stock_takes';

    protected $casts = [
        'completed' => 'boolean',
        'approved' => 'boolean'
    ];

    public function started_by()
    {
        return $this->belongsTo(User::class);
    }

    public function stockCounts()
    {
        return $this->hasMany(StockCount::class);
    }
}
