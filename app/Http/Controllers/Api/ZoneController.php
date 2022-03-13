<?php

namespace App\Http\Controllers\Api;

use App\Models\Zone;
use Illuminate\Http\Request;
use App\Http\Resources\ZoneResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\ZoneCollection;
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
            ->paginate();

        return new ZoneCollection($zones);
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

        return new ZoneResource($zone);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Zone $zone
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Zone $zone)
    {
        $this->authorize('view', $zone);

        return new ZoneResource($zone);
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

        return new ZoneResource($zone);
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

        return response()->noContent();
    }
}
