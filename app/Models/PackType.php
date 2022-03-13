<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PackType extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = [
        'name',
        'unit_name',
        'units_per_pack',
        'serving_name',
        'typical_unit_serving',
    ];

    protected $searchableFields = ['*'];

    protected $table = 'pack_types';
}
