<div>
    <div>
        @can('create', App\Models\Ingredient::class)
        <button class="button" wire:click="newIngredient">
            <i class="mr-1 icon ion-md-add text-primary"></i>
            @lang('crud.common.new')
        </button>
        @endcan @can('delete-any', App\Models\Ingredient::class)
        <button
            class="button button-danger"
             {{ empty($selected) ? 'disabled' : '' }}
            onclick="confirm('Are you sure?') || event.stopImmediatePropagation()"
            wire:click="destroySelected"
        >
            <i class="mr-1 icon ion-md-trash text-primary"></i>
            @lang('crud.common.delete_selected')
        </button>
        @endcan
    </div>

    <x-modal wire:model="showingModal">
        <div class="px-6 py-4">
            <div class="text-lg font-bold"> {{ $modalTitle }} </div>

            <div class="mt-5">
                <div>
                    <x-inputs.group class="w-full lg:w-6/12">
                        <x-inputs.select
                            name="category"
                            label="Category"
                            wire:model="category"
                        >
                            <option value=""> Select Category </option>
                            @foreach($categories as $category)
                            <option value="{{$category->id}}" > {{ $category->name }}
                            @endforeach
                        </x-inputs.select>
                    </x-inputs.group>

                    <x-inputs.group class="w-full lg:w-6/12">
                        <x-inputs.select
                            name="ingredient.product_id"
                            label="Component"
                            wire:model="ingredient.product_id"
                        >
                            <option value=""> Select Product </option>
                            @foreach($components as $component)
                            <option value="{{$component->id}}" > {{ $component->name }}
                            @endforeach
                        </x-inputs.select>
                    </x-inputs.group>

                    <x-inputs.group class="w-full lg:w-6/12">
                        <x-inputs.number
                            name="ingredient.measure"
                            label="Measure"
                            wire:model="ingredient.measure"
                            max="255"
                            step="0.01"
                        ></x-inputs.number>
                    </x-inputs.group>
                </div>
            </div>

            @if($editing) @endif
        </div>

        <div class="px-6 py-4 bg-gray-50 flex justify-between">
            <button
                type="button"
                class="button"
                wire:click="$toggle('showingModal')"
            >
                <i class="mr-1 icon ion-md-close"></i>
                @lang('crud.common.cancel')
            </button>

            <button
                type="button"
                class="button button-primary"
                wire:click="save"
            >
                <i class="mr-1 icon ion-md-save"></i>
                @lang('crud.common.save')
            </button>
        </div>
    </x-modal>

    <div class="block w-full overflow-auto scrolling-touch mt-4">
        <table class="w-full max-w-full mb-4 bg-transparent">
            <thead class="text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left w-1">
                        <input
                            type="checkbox"
                            wire:model="allSelected"
                            wire:click="toggleFullSelection"
                            title="{{ trans('crud.common.select_all') }}"
                        />
                    </th>
                    <th class="px-4 py-3 text-right">
                        @lang('crud.ingredients.inputs.product')
                    </th>
                    <th class="px-4 py-3 text-right">
                        @lang('crud.ingredients.inputs.measure')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.ingredients.inputs.cost_per_measure')
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @foreach ($ingredients as $ingredient)
                <tr class="hover:bg-gray-100">
                    <td class="px-4 py-3 text-left">
                        <input
                            type="checkbox"
                            value="{{ $ingredient->id }}"
                            wire:model="selected"
                        />
                    </td>
                    <td class="px-4 py-3 text-right">
                        {{ $ingredient->product->name ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right">
                        {{ $ingredient->measure ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $ingredient->cost_price*$ingredient->measure ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right" style="width: 134px;">
                        <div
                            role="group"
                            aria-label="Row Actions"
                            class="relative inline-flex align-middle"
                        >
                            @can('update', $ingredient)
                            <button
                                type="button"
                                class="button"
                                wire:click="editIngredient({{ $ingredient->id }})"
                            >
                                <i class="icon ion-md-create"></i>
                            </button>
                            @endcan
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5">
                        <div class="mt-10 px-4">
                            {{ $ingredients->render() }}
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
