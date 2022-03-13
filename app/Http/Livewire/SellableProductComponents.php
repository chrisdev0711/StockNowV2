<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Ingredient;
use App\Models\Sellable;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SellableProductComponents extends Component
{
    use AuthorizesRequests;

    public Sellable $sellable;
    public Ingredient $ingredient;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New Ingredient';

    public $category;
    public $components = [];

    protected $rules = [
        'ingredient.product_id' => ['required', 'numeric'],
        'ingredient.measure' => ['required', 'numeric'],        
    ];

    public function mount(Sellable $sellable)
    {
        $this->sellable = $sellable;
        $this->resetIngredients();
    }

    public function resetIngredients()
    {
        $this->ingredient = new Ingredient();

        $this->dispatchBrowserEvent('refresh');
    }

    public function newIngredient()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.ingredients.new_title');
        $this->resetIngredients();

        $this->showModal();
    }

    public function editIngredient(Ingredient $ingredient)
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.ingredients.edit_title');
        $this->ingredient = $ingredient;

        $this->dispatchBrowserEvent('refresh');

        $this->showModal();
    }

    public function showModal()
    {
        $this->resetErrorBag();
        $this->showingModal = true;
    }

    public function hideModal()
    {
        $this->showingModal = false;
    }

    public function save()
    {
        $this->validate();

        if(!$this->ingredient->sellable_id) {
            $this->authorize('create', Ingredient::class);
            $this->ingredient->sellable_id = $this->sellable->id;                        
        } else {
            $this->authorize('update', $this->ingredient);
        }
        
        $product = Product::find($this->ingredient->product_id);
        $this->ingredient->cost_price = $product->entered_cost;
        if($product->units_per_pack != 0)
            $this->ingredient->cost_price = ($this->ingredient->cost_price)/($product->units_per_pack);

        $this->ingredient->save();

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', Ingredient::class);

        Ingredient::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetIngredients();
    }

    public function toggleFullSelection()
    {
        if(!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->sellable->ingredients as $ingredient) {
            array_push($this->selected, $ingredient->id);
        }
    }

    public function render()    
    {
        $categories = ProductCategory::all();        
        if(!empty($this->category)) {
            $this->components = Product::where('product_category_id', $this->category)->get();
        }
        return view('livewire.sellable-product-components', [
            'ingredients' => $this->sellable
            ->ingredients()
            ->paginate(20),
            'categories' => $categories,
            'components' => $this->components,
        ]);
    }
}
