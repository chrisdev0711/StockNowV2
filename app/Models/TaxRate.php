<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxRate extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'tax_id',
        'rate',        
    ];

    protected $searchableFields = ['*'];
}
