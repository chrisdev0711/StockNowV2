<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Site;
use Auth;

class ActiveSiteMenu extends Component
{
    public Site $active;

    public function mount(Site $active)
    {
        $this->active = $active;
        $this->dispatchBrowserEvent('refresh');
    }    

    public function setActive(Site $selected)
    {
        $this->active = $selected;

        $user = Auth::user();
        $user->active_site = $selected->id;
        $user->save();

        $this->dispatchBrowserEvent('refresh');
    }

    public function render()    
    {
        $sites = Auth::user()->locations();
        return view('livewire.active-site-menu', [
            'sites' => $sites
        ]);
    }
}
