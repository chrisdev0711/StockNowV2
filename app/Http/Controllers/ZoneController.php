<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use App\Models\Site;
use Illuminate\Http\Request;
use App\Http\Requests\ZoneStoreRequest;
use App\Http\Requests\ZoneUpdateRequest;

class ZoneController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Zone::class);

        $search = $request->get('search', '');

        $zones = Zone::search($search)
            ->latest()
            ->paginate(50);

        return view('app.zones.index', compact('zones', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Zone::class);

        $sites = Site::pluck('name', 'id');

        return view('app.zones.create', compact('sites'));
    }

    /**
     * @param \App\Http\Requests\ZoneStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(ZoneStoreRequest $request)
    {
        $this->authorize('create', Zone::class);

        $validated = $request->validated();

        $zone = Zone::create($validated);

        return redirect()
            ->route('zones.edit', $zone)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Zone $zone
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Zone $zone)
    {
        $this->authorize('view', $zone);

        return view('app.zones.show', compact('zone'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Zone $zone
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Zone $zone)
    {
        $this->authorize('update', $zone);

        $sites = Site::pluck('name', 'id');

        return view('app.zones.edit', compact('zone', 'sites'));
    }

    /**
     * @param \App\Http\Requests\ZoneUpdateRequest $request
     * @param \App\Models\Zone $zone
     * @return \Illuminate\Http\Response
     */
    public function update(ZoneUpdateRequest $request, Zone $zone)
    {
        $this->authorize('update', $zone);

        $validated = $request->validated();

        $zone->update($validated);

        return redirect()
            ->route('zones.edit', $zone)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Zone $zone
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Zone $zone)
    {
        $this->authorize('delete', $zone);

        $zone->delete();

        return redirect()
            ->route('zones.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
