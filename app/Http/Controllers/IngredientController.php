<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ingredient;
use App\Http\Requests\IngredientStoreRequest;
use App\Http\Requests\IngredientUpdateRequest;

class IngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view-any', Ingredient::class);

        $search = $request->get('search', '');

        $ingredients = Ingredient::search($search)
            ->latest()
            ->paginate(50);

        return view(
            'app.ingredients.index',
            compact('ingredients', 'search')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('create', Ingredient::class);

        return view('app.ingredients.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(IngredientStoreRequest $request)
    {
        $this->authorize('create', Ingredient::class);

        $validated = $request->validated();

        $ingredient = Ingredient::create($validated);

        return redirect()
            ->route('ingredients.edit', $ingredient)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Ingredient $ingredient)
    {
        $this->authorize('view', $ingredient);

        return view('app.ingredients.show', compact('ingredient'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, Ingredient $ingredient)
    {
        $this->authorize('update', $ingredient);

        return view('app.ingredients.edit', compact('ingredient'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(
        IngredientUpdateRequest $request,
        Ingredient $ingredient
    ) {
        $this->authorize('update', $ingredient);

        $validated = $request->validated();

        $ingredient->update($validated);

        return redirect()
            ->route('ingredients.edit', $ingredient)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Ingredient $ingredient)
    {
        $this->authorize('delete', $ingredient);

        $ingredient->delete();

        return redirect()
            ->route('ingredients.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
