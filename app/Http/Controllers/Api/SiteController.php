<?php

namespace App\Http\Controllers\Api;

use App\Models\Site;
use Illuminate\Http\Request;
use App\Http\Resources\SiteResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\SiteCollection;
use App\Http\Requests\SiteStoreRequest;
use App\Http\Requests\SiteUpdateRequest;

class SiteController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Site::class);

        $search = $request->get('search', '');

        $sites = Site::search($search)
            ->latest()
            ->paginate();

        return new SiteCollection($sites);
    }

    /**
     * @param \App\Http\Requests\SiteStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SiteStoreRequest $request)
    {
        $this->authorize('create', Site::class);

        $validated = $request->validated();

        $site = Site::create($validated);

        return new SiteResource($site);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Site $site
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Site $site)
    {
        $this->authorize('view', $site);

        return new SiteResource($site);
    }

    /**
     * @param \App\Http\Requests\SiteUpdateRequest $request
     * @param \App\Models\Site $site
     * @return \Illuminate\Http\Response
     */
    public function update(SiteUpdateRequest $request, Site $site)
    {
        $this->authorize('update', $site);

        $validated = $request->validated();

        $site->update($validated);

        return new SiteResource($site);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Site $site
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Site $site)
    {
        $this->authorize('delete', $site);

        $site->delete();

        return response()->noContent();
    }
}
