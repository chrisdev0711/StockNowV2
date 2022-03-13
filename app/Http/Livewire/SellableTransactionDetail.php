<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Sellable;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SellableTransactionDetail extends Component
{
    use AuthorizesRequests;

    public Sellable $sellable;

    public function mount(Sellable $sellable)
    {
        $this->sellable = $sellable;
        $this->resetTransactionData();
    }

    public function resetTransactionData()
    {
        $this->dispatchBrowserEvent('refresh');
    }

    public function render()
    {
        return view('livewire.sellable-transaction-detail', [
            'transactionsDetail' => $this->sellable
                ->transactionDetail()
                ->orderBy('transaction_time', 'desc')
                ->paginate(20),
        ]);
    }
}
