<?php

namespace App\Http\Controllers;

use App\Models\Sellable;
use App\Models\Ingredient;
use Illuminate\Http\Request;
use App\Http\Requests\SellableStoreRequest;
use App\Http\Requests\SellableUpdateRequest;
use App\Models\Site;

class SellableController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Sellable::class);

        $sellables = Sellable::all();
        foreach($sellables as $sellable)
        {
            $cost_of_sellable = 0;
            $ingredients = Ingredient::where('sellable_id', $sellable->id)->get();
            foreach($ingredients as $ingredient)
                $cost_of_sellable += ($ingredient->measure * $ingredient->cost_price);
            $sellable->cost = $cost_of_sellable;
            $sellable->save();
        }

        $search = $request->get('search', '');

        $sellables = Sellable::search($search)
            ->latest()
            ->paginate(50);

        return view('app.sellables.index', compact('sellables', 'search'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Sellable::class);

        return view('app.sellables.create');
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

        return redirect()
            ->route('sellables.edit', $sellable)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Sellable $sellable
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Sellable $sellable)
    {
        $this->authorize('view', $sellable);

        return view('app.sellables.show', compact('sellable'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Sellable $sellable
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Sellable $sellable)
    {
        $this->authorize('update', $sellable);

        $locations = Site::where('status', '=', true)->get();
        
        return view('app.sellables.edit', compact('sellable', 'locations'));
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

        return redirect()
            ->route('sellables.edit', $sellable)
            ->withSuccess(__('crud.common.saved'));
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

        return redirect()
            ->route('sellables.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
