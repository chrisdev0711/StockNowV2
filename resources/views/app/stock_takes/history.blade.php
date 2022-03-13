<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.stockTakes.history')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <div class="mb-5 mt-4">
                    <div class="flex flex-wrap justify-between">
                        <div class="md:w-1/2">
                            <form>
                                <div class="flex items-center w-full">
                                    <x-inputs.text
                                        name="search"
                                        value="{{ $search ?? '' }}"
                                        placeholder="{{ __('crud.common.search') }}"
                                        autocomplete="off"
                                    ></x-inputs.text>

                                    <div class="ml-1">
                                        <button
                                            type="submit"
                                            class="button button-primary"
                                        >
                                            <i class="icon ion-md-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>                        
                    </div>
                </div>                                
                <div class="block w-full overflow-auto scrolling-touch">
                    <table class="w-full max-w-full mb-4 bg-transparent">
                        <thead class="text-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.stockTakes.inputs.started_on')
                                </th>                                
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.stockTakes.inputs.started_by_id')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.stockTakes.inputs.area')
                                </th>                                
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.stockTakes.inputs.type')
                                </th>
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.stockTakes.inputs.completed')
                                </th>                                
                                <th class="px-4 py-3 text-center">
                                    @lang('crud.stockTakes.inputs.approved')
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">                            
                            @forelse($stockTakes as $stockTake)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-left">
                                    {{ $stockTake->started_on ?? '-' }}
                                </td>                            
                                <td class="px-4 py-3 text-left">
                                    {{ optional($stockTake->started_by)->name ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $stockTake->area_name ? $stockTake->area . '(' . $stockTake->area_name . ')' : $stockTake->area }}
                                </td>                                
                                <td class="px-4 py-3 text-right">
                                    {{ $stockTake->sub_type ? $stockTake->type . '(' . $stockTake->sub_type . ')' : $stockTake->type }}
                                </td>                                
                                <td class="px-4 py-3 text-right">
                                    {{ $stockTake->completed ? 'YES' : 'NO' }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                {{ $stockTake->approved ? 'YES' : 'NO' }}
                                </td>
                                <td
                                    class="px-4 py-3 text-center"
                                    style="width: 134px;"
                                >
                                    <div
                                        role="group"
                                        aria-label="Row Actions"
                                        class="
                                            relative
                                            inline-flex
                                            align-middle
                                        "
                                    >
                                        @can('update', $stockTake)    
                                        @if(!$stockTake->approved)                                                                              
                                        <a
                                            href="{{ route('stockTakes.approve', ['stock_take_id' => $stockTake]) }}"
                                            class="mr-1"
                                            onclick="return confirm('{{ __('crud.stockTakes.confirm') }}')"
                                        >
                                            <button
                                                type="button"
                                                class="button"
                                            >
                                                <i class="icon ion-md-checkmark"></i>
                                            </button>
                                        </a>    
                                        @endif 
                                        <a
                                            href="{{ route('stockTakes.detail', ['stock_take_id' => $stockTake]) }}"
                                            class="mr-1"
                                        >
                                            <button
                                                type="button"
                                                class="button"
                                            >                                                
                                                <i class="icon ion-md-eye"></i>
                                            </button>
                                        </a>                                                                                                                    
                                        @endcan 
                                        @can('delete', $stockTake)
                                            @if(!$stockTake->approved)
                                            <form
                                                action="{{ route('stockTakes.destroy', ['stock_take_id' => $stockTake]) }}"
                                                method="POST"
                                                onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')"
                                            >
                                                @csrf
                                                <button
                                                    type="submit"
                                                    class="button"
                                                >
                                                    <i
                                                        class="
                                                            icon
                                                            ion-md-trash
                                                            text-red-600
                                                        "
                                                    ></i>
                                                </button>
                                            </form>
                                            @endif
                                        @endcan                                        
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="17">
                                    @lang('crud.common.no_items_found')
                                </td>
                            </tr>
                            @endforelse                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="17">
                                    <div class="mt-10 px-4">
                                        {!! $stockTakes->render() !!}
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>                                                
            </x-partials.card>
        </div>
    </div>
</x-app-layout>
