<?php

namespace App\Http\Livewire;

use App\Models\Site;
use App\Models\Zone;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SiteZonesDetail extends Component
{
    use AuthorizesRequests;

    public Site $site;
    public Zone $zone;

    public $selected = [];
    public $editing = false;
    public $allSelected = false;
    public $showingModal = false;

    public $modalTitle = 'New Zone';

    protected $rules = [
        'zone.name' => ['required', 'max:255', 'string'],
    ];

    public function mount(Site $site)
    {
        $this->site = $site;
        $this->resetZoneData();
    }

    public function resetZoneData()
    {
        $this->zone = new Zone();

        $this->dispatchBrowserEvent('refresh');
    }

    public function newZone()
    {
        $this->editing = false;
        $this->modalTitle = trans('crud.site_zones.new_title');
        $this->resetZoneData();

        $this->showModal();
    }

    public function editZone(Zone $zone)
    {
        $this->editing = true;
        $this->modalTitle = trans('crud.site_zones.edit_title');
        $this->zone = $zone;

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

        if (!$this->zone->site_id) {
            $this->authorize('create', Zone::class);

            $this->zone->site_id = $this->site->id;
        } else {
            $this->authorize('update', $this->zone);
        }

        $this->zone->save();

        $this->hideModal();
    }

    public function destroySelected()
    {
        $this->authorize('delete-any', Zone::class);

        Zone::whereIn('id', $this->selected)->delete();

        $this->selected = [];
        $this->allSelected = false;

        $this->resetZoneData();
    }

    public function toggleFullSelection()
    {
        if (!$this->allSelected) {
            $this->selected = [];
            return;
        }

        foreach ($this->site->zones as $zone) {
            array_push($this->selected, $zone->id);
        }
    }

    public function render()
    {
        return view('livewire.site-zones-detail', [
            'zones' => $this->site->zones()->paginate(20),
        ]);
    }
}
