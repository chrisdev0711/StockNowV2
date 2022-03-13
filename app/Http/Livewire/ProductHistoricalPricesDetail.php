<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\HistoricalPrice;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductHistoricalPricesDetail extends Component
{
    use AuthorizesRequests;

    public Product $product;
    public HistoricalPrice $historicalPrice;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New HistoricalPrice';

    protected $rules = [
        'historicalPrice.original_price' => ['required', 'numeric'],
        'historicalPrice.new_price' => ['required', 'numeric'],
        'historicalPrice.changed_by_name' => ['required', 'max:255', 'string'],
        'historicalPrice.changed_by' => ['required', 'max:255'],
    ];

    public function mount(Product $product)
    {
        $this->product = $product;
        $this->resetHistoricalPriceData();
    }

    public function resetHistoricalPriceData()
    {
        $this->historicalPrice = new HistoricalPrice();

        $this->dispatchBrowserEvent('refresh');
    }

    public function newHistoricalPrice()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.product_historical_prices.new_title');
        $this->resetHistoricalPriceData();

        $this->showModal();
    }

    public function editHistoricalPrice(HistoricalPrice $historicalPrice)
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.product_historical_prices.edit_title');
        $this->historicalPrice = $historicalPrice;

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

        if (!$this->historicalPrice->product_id) {
            $this->authorize('create', HistoricalPrice::class);

            $this->historicalPrice->product_id = $this->product->id;
        } else {
            $this->authorize('update', $this->historicalPrice);
        }

        $this->historicalPrice->save();

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', HistoricalPrice::class);

        HistoricalPrice::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetHistoricalPriceData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->product->historicalPrices as $historicalPrice) {
            array_push($this->selected, $historicalPrice->id);
        }
    }

    public function render()
    {
        return view('livewire.product-historical-prices-detail', [
            'historicalPrices' => $this->product
                ->historicalPrices()
                ->paginate(20),
        ]);
    }
}
