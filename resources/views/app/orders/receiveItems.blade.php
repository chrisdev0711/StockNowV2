
       

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.orders.edit_title')
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title"> Items Ordered List </x-slot>
                <div class="py-12">        
                <div class="mb-5">
                    <div class="flex flex-wrap justify-between">        
                        <div class="md:w-full">
                            <form>
                                <div class="flex items-center w-full">
                                    <input
                                        type="hidden"
                                        name="order_id"
                                        value="{{$order->id}}">
                                    </input>
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
                <form method="POST"
                    action="{{ route('orders.receiveAll', $orderItems) }}">                      
                    {{csrf_field()}}
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
                                @forelse($orderItems as $item)
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
                                        <div class="relative inline-flex align-middle">
                                            <input
                                                type="text"
                                                name="receive_num[]"
                                                class="block appearance-none w-16 py-1 px-2 mr-2 text-base leading-normal text-gray-800 border border-gray-200 rounded"
                                                value=""
                                                placeholder="{{ $item->received_qty ?? '0' }}"
                                                maxlength="255"
                                            ></input> 
                                            <input 
                                                type="hidden"
                                                name="item_id[]"
                                                value="{{$item->id}}"> 
                                            </input>
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
                                            {!! $orderItems->render() !!}
                                        </div>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                        @if($orderItems)
                            <div class="float-right">                            
                            <button
                                    type="submit"
                                    class="button button-primary"
                                    onclick="return confirm('Are you sure?')"
                                >
                                    @lang('crud.orders.receive_all')
                            </button>                         
                            </div>
                        @endif
                    </div>
                </form>
            </x-partials.card>                       
        </div>        
    </div>
</x-app-layout>