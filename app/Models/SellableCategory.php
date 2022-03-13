<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellableCategory extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['uuid', 'name', 'reported'];

    protected $searchableFields = ['*'];

    protected $table = 'sellable_categories';

    protected $casts = [
        'reported' => 'boolean',
    ];
}
