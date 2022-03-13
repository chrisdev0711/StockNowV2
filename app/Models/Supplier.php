<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'company',
        'address_1',
        'address_2',
        'city',
        'county',
        'postcode',
        'payment_terms',
        'order_phone',
        'order_email_1',
        'order_email_2',
        'order_email_3',
        'account_manager',
        'account_manager_phone',
        'account_manager_email',
    ];

    protected $searchableFields = ['*'];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
