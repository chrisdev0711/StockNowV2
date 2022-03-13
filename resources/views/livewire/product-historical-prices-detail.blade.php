<div>
    <div>
        @can('create', App\Models\HistoricalPrice::class)
        <button class="button" wire:click="newHistoricalPrice">
            <i class="mr-1 icon ion-md-add text-primary"></i>
            @lang('crud.common.new')
        </button>
        @endcan @can('delete-any', App\Models\HistoricalPrice::class)
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
            <div class="text-lg font-bold">{{ $modalTitle }}</div>

            <div class="mt-5">
                <div>
                    <x-inputs.group class="w-full lg:w-6/12">
                        <x-inputs.number
                            name="historicalPrice.original_price"
                            label="Original Price"
                            wire:model="historicalPrice.original_price"
                            max="255"
                            step="0.01"
                        ></x-inputs.number>
                    </x-inputs.group>

                    <x-inputs.group class="w-full lg:w-6/12">
                        <x-inputs.number
                            name="historicalPrice.new_price"
                            label="New Price"
                            wire:model="historicalPrice.new_price"
                            max="255"
                            step="0.01"
                        ></x-inputs.number>
                    </x-inputs.group>

                    <x-inputs.group class="w-full lg:w-6/12">
                        <x-inputs.text
                            name="historicalPrice.changed_by_name"
                            label="Changed By Name"
                            wire:model="historicalPrice.changed_by_name"
                            maxlength="255"
                        ></x-inputs.text>
                    </x-inputs.group>

                    <x-inputs.group class="w-full lg:w-6/12">
                        <x-inputs.text
                            name="historicalPrice.changed_by"
                            label="Changed By"
                            wire:model="historicalPrice.changed_by"
                            maxlength="255"
                        ></x-inputs.text>
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
                        @lang('crud.product_historical_prices.inputs.original_price')
                    </th>
                    <th class="px-4 py-3 text-right">
                        @lang('crud.product_historical_prices.inputs.new_price')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.product_historical_prices.inputs.changed_by_name')
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.product_historical_prices.inputs.changed_by')
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @foreach ($historicalPrices as $historicalPrice)
                <tr class="hover:bg-gray-100">
                    <td class="px-4 py-3 text-left">
                        <input
                            type="checkbox"
                            value="{{ $historicalPrice->id }}"
                            wire:model="selected"
                        />
                    </td>
                    <td class="px-4 py-3 text-right">
                        {{ $historicalPrice->original_price ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right">
                        {{ $historicalPrice->new_price ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $historicalPrice->changed_by_name ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $historicalPrice->changed_by ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-right" style="width: 134px;">
                        <div
                            role="group"
                            aria-label="Row Actions"
                            class="relative inline-flex align-middle"
                        >
                            @can('update', $historicalPrice)
                            <button
                                type="button"
                                class="button"
                                wire:click="editHistoricalPrice({{ $historicalPrice->id }})"
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
                            {{ $historicalPrices->render() }}
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
