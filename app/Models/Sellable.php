<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\SellableCategory;
use App\Models\Ingredient;
use App\Models\Sale;

class Sellable extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['uuid', 'parent_id', 'name', 'sub_name', 'description', 'price', 'cost', 'total_sale', 'active', 'presentLocationIds', 'category_id'];

    protected $searchableFields = ['*'];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'ingredients');
    }

    public function ingredients()
    {
        return $this->hasMany(Ingredient::class);
    }

    public function category()
    {
        $category_id = $this->category_id;

        $category = SellableCategory::where('uuid', '=' , $category_id)->first();
        $category_name = $category->name;

        return $category_name;
    }

    public function noIngredient()
    {
        $ingredients = Ingredient::where('sellable_id', '=', $this->id)->get();
        if(count($ingredients) > 0)
        {
            return false;
        }

        return true;
    }

    public function transactionDetail()
    {
        $transactions = Sale::where('catalog_object_id', '=', $this->uuid);

        return $transactions;
    }
}
