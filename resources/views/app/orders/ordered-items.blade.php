<div class="mb-5">
    <div class="flex flex-wrap justify-between">        
        <div class="md:w-full">
            <form
                method="GET"
                action="{{ route('orders.detail', ['order_id' => $order]) }}"
            >
                <div class="flex items-center w-full">
                    <input
                        type="hidden"
                        name="order_id"
                        value="{{ $order->id ?? '' }}"
                    ></input>

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
                    @lang('crud.orderItems.inputs.product_name')
                </th>                                
                <th class="px-4 py-3 text-left">
                    @lang('crud.orderItems.inputs.order_count')
                </th>
                <th class="px-4 py-3 text-left">
                    @lang('crud.orderItems.inputs.goods_received')
                </th>                                
                <th class="px-4 py-3 text-right">
                    @lang('crud.orderItems.inputs.total_cost')
                </th>
                <th class="px-4 py-3 text-right">
                    @lang('crud.orderItems.inputs.received_by')
                </th>
                <th class="px-4 py-3 text-right">
                    @lang('crud.orderItems.inputs.received_on')
                </th>         
                <th></th>
            </tr>
        </thead>
        <tbody class="text-gray-600">                            
            @forelse($items as $item)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 text-left">
                    {{ optional($item->product)->name ?? '-' }}
                </td>                                
                <td class="px-4 py-3 text-left">
                    {{ $item->qty ?? '-' }}
                </td>
                <td class="px-4 py-3 text-left">
                    {{ $item->received_qty ?? '-' }}
                </td>                                
                <td class="px-4 py-3 text-right">
                    {{ $item->total_price ?? '-' }}
                </td>                                
                <td class="px-4 py-3 text-right">
                    {{ optional($item->received_by)->name ?? '-' }}
                </td>                    
                <td class="px-4 py-3 text-right">
                    {{ $item->received_on ?? 'Awaiting Delivery' }}
                </td>
                <td
                    class="px-4 py-3 text-center"
                    style="width: 134px;"
                >
                @if($item->status != 'received')
                    <div
                        role="group"
                        aria-label="Row Actions"
                        class="
                            relative
                            inline-flex
                            align-middle
                        "
                    >
                        @can('update', $item)  
                        <x-form
                        method="POST"
                        action="{{ route('orders.updateItem', ['item_id' => $item]) }}"
                            > 
                        <div class="relative inline-flex align-middle">
                            <span>
                                <input
                                    type="text"
                                    name="update_num"
                                    class="block appearance-none w-16 py-1 px-2 mr-2 text-base leading-normal text-gray-800 border border-gray-200 rounded"
                                    value=""
                                    placeholder="{{ $item->qty ?? '0' }}"
                                    maxlength="255"
                                ></input> 
                            </span>                                  
                            <span class="mr-2">
                                <button
                                    type="submit"                                                    
                                    class="button float-right"
                                >
                                    <i
                                        class="icon ion-md-create"
                                    ></i>
                                </button>
                            </span> 
                        </div>
                        </x-form>                                                                                   
                        @endcan
                        @can('delete', $item)
                        <form
                            action="{{ route('orders.removeItem', ['item_id' => $item]) }}"
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
                        @endcan                                         
                    </div>
                @endif
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
                        {!! $items->render() !!}
                    </div>
                </td>
            </tr>
        </tfoot>
    </table>
</div>                  