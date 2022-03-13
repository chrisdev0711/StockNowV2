<?php

namespace App\Http\Controllers\Api;

use App\Models\Site;
use Illuminate\Http\Request;
use App\Http\Resources\ZoneResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\ZoneCollection;

class SiteZonesController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Site $site
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Site $site)
    {
        $this->authorize('view', $site);

        $search = $request->get('search', '');

        $zones = $site
            ->zones()
            ->search($search)
            ->latest()
            ->paginate();

        return new ZoneCollection($zones);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Site $site
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Site $site)
    {
        $this->authorize('create', Zone::class);

        $validated = $request->validate([
            'name' => ['required', 'max:255', 'string'],
        ]);

        $zone = $site->zones()->create($validated);

        return new ZoneResource($zone);
    }
}
