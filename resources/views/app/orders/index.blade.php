<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.orders.create_title')
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
                        @if(!$boxIsEmpty)
                        <div class="md:w-1/2 text-right">                            
                            <a
                                href="{{ route('orders.clearCart') }}"
                                class="button button-danger"
                                onclick="return confirm('Are you sure?')"
                            >
                                <i class="mr-1 icon ion-md-trash"></i>
                                @lang('crud.orders.clear_basket')
                            </a>
                    
                            <a
                                href="{{ route('orders.viewCart') }}"
                                class="button button-primary"
                            >
                                <i class="mr-1 icon ion-md-eye"></i>
                                @lang('crud.orders.view_basket')
                            </a>                            
                        </div>
                        @endif
                    </div>
                </div> 
                <x-form
                    method="POST"
                    action="{{ route('orders.addToCart') }}"
                        >               
                <div class="block w-full overflow-auto scrolling-touch">
                    <table class="w-full max-w-full mb-4 bg-transparent">
                        <thead class="text-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.orders.inputs.name')
                                </th>                                
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.orders.inputs.product_category_id')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.orders.inputs.supplier_id')
                                </th>                                
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.orders.inputs.entered_cost')
                                </th>
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.orders.inputs.stock_level')
                                </th>                                
                                <th class="px-4 py-3 text-center">
                                    @lang('crud.orders.inputs.to_basket')
                                </th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">                            
                            @forelse($products as $product)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-left">
                                    {{ $product->name ?? '-' }}
                                </td>                                
                                <td class="px-4 py-3 text-left">
                                    {{ optional($product->productCategory)->name
                                    ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ optional($product->supplier)->company ??
                                    '-' }}
                                </td>                                
                                <td class="px-4 py-3 text-right">
                                    {{ $product->entered_cost ?? '-' }}
                                </td>                                
                                <td class="px-4 py-3 text-right">
                                    {{ $product->getCurrentStockLevel($site->id) ?? '-' }}
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
                                        @can('update', $product)  
                                        <input 
                                            name="products[]"
                                            type="hidden"                                       
                                            value="{{$product}}"/>
                                        <div class="relative inline-flex align-middle">
                                            <span class="mr-2">
                                                <input
                                                    type="text"
                                                    name="order_num[]"
                                                    class="block appearance-none w-full py-1 px-2 mr-2 text-base leading-normal text-gray-800 border border-gray-200 rounded"
                                                    value=""
                                                    placeholder="{{ $product->in_cart ?? '0' }}"
                                                    maxlength="255"
                                                ></input> 
                                            </span>                                  
                                            <span
                                            >
                                                <button
                                                    type="submit"
                                                    name="addOne[]"
                                                    value="{{$product->id}}"
                                                    class="button button-primary float-right"
                                                >
                                                    <i
                                                        class="icon ion-md-add"
                                                    ></i>
                                                </button>
                                            </span> 
                                        </div>                                                                                   
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
                                        {!! $products->render() !!}
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="mt-10">                    
                    <button
                        name="addAll"
                        value="all"
                        type="submit"
                        class="button button-primary float-right"
                    >
                        <i class="mr-1 icon ion-md-save"></i>
                        @lang('crud.orders.inputs.to_basket')
                    </button>
                </div>
                </x-form>                
            </x-partials.card>
        </div>
    </div>
</x-app-layout>
