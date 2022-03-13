<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Site extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'code',
        'name',
        'address_1',
        'address_2',
        'city',
        'country',
        'postcode',
        'email',
        'phoneNumber',
        'merchantId',
        'logoUrl',
        'status',
        'display_on_orders',
    ];

    protected $searchableFields = ['*'];

    protected $casts = [
        'display_on_orders' => 'boolean',
        'status' => 'boolean'
    ];

    public function zones()
    {
        return $this->hasMany(Zone::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
