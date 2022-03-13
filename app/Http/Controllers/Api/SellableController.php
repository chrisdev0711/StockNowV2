<?php

namespace App\Http\Controllers\Api;

use App\Models\Sellable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SellableResource;
use App\Http\Resources\SellableCollection;
use App\Http\Requests\SellableStoreRequest;
use App\Http\Requests\SellableUpdateRequest;

class SellableController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Sellable::class);

        $search = $request->get('search', '');

        $sellables = Sellable::search($search)
            ->latest()
            ->paginate();

        return new SellableCollection($sellables);
    }

    /**
     * @param \App\Http\Requests\SellableStoreRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(SellableStoreRequest $request)
    {
        $this->authorize('create', Sellable::class);

        $validated = $request->validated();

        $sellable = Sellable::create($validated);

        return new SellableResource($sellable);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Sellable $sellable
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Sellable $sellable)
    {
        $this->authorize('view', $sellable);

        return new SellableResource($sellable);
    }

    /**
     * @param \App\Http\Requests\SellableUpdateRequest $request
     * @param \App\Models\Sellable $sellable
     * @return \Illuminate\Http\Response
     */
    public function update(SellableUpdateRequest $request, Sellable $sellable)
    {
        $this->authorize('update', $sellable);

        $validated = $request->validated();

        $sellable->update($validated);

        return new SellableResource($sellable);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Sellable $sellable
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Sellable $sellable)
    {
        $this->authorize('delete', $sellable);

        $sellable->delete();

        return response()->noContent();
    }
}
