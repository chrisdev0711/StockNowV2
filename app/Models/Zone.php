<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Zone extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['name', 'site_id'];

    protected $searchableFields = ['*'];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
