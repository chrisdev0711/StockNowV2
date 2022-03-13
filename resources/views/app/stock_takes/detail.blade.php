<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.stockTakes.new_title')
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
                        <div class="md:w-1/2 text-right">                            
                            <a
                                href="{{ route('stockTakes.deleteStockTake') }}"
                                class="button button-danger"
                                onclick="return confirm('Are you sure?')"
                            >
                                <i class="mr-1 icon ion-md-trash"></i>
                                @lang('crud.common.delete')
                            </a>

                            <a
                                href="{{ route('stockTakes.complete') }}"
                                class="button button-primary"
                                onclick="return confirm('Are you sure?')"
                            >
                                <i class="mr-1 icon ion-md-save"></i>
                                @lang('crud.stockTakes.complete')
                            </a>                            
                        </div>                        
                    </div>
                </div>                               
                <div class="block w-full overflow-auto scrolling-touch">

                    <table class="w-full max-w-full mb-4 bg-transparent">
                        <thead class="text-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.stockTakes.inputs.name')
                                </th>                                
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.stockTakes.inputs.product_category_id')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.stockTakes.inputs.supplier_id')
                                </th>                                
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.stockTakes.inputs.stock_count')
                                </th>                                
                                <th class="px-4 py-3 text-center">
                                    @lang('crud.stockTakes.inputs.adjustment')
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">                            
                            @forelse($stockCounts as $stockCount)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-left">
                                    {{ optional($stockCount->product)->name ?? '-' }}
                                </td>                                
                                <td class="px-4 py-3 text-left">
                                    {{ optional($stockCount->product->productCategory)->name ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ optional($stockCount->product->supplier)->company ?? '-' }}
                                </td>                                
                                <td class="px-4 py-3 text-right">
                                    {{ $stockCount->count ?? '0' }}
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
                                        @if(!$stockCount->stockTake->approved)
                                        @can('update', $stockCount)  
                                        <x-form
                                        method="POST"
                                        action="{{ route('stockTakes.adjust', ['stock_count_id' => $stockCount->id]) }}"
                                            >
                                            <div class="relative inline-flex align-middle">
                                                <span class="mr-2">
                                                    <input
                                                        type="text"
                                                        name="adjustment_num"
                                                        id="adjustment_num"
                                                        class="block appearance-none w-full py-1 px-2 mr-2 text-base leading-normal text-gray-800 border border-gray-200 rounded"
                                                        value=""
                                                        maxlength="255"
                                                    ></input>                                                     
                                                </span>                                  
                                                <span
                                                >
                                                    <button
                                                        type="submit"
                                                        class="button button-primary float-right"
                                                        onclick="return confirm('Are you sure?')"
                                                    >
                                                        <i
                                                            class="icon ion-md-save"
                                                        ></i>
                                                    </button>
                                                </span> 
                                            </div>   
                                        </x-form>                                                                                
                                        @endcan
                                        @endif                                         
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
                                        {!! $stockCounts->render() !!}
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
