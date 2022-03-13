<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.orders.history')
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
                                    @lang('crud.orders.inputs.order_num')
                                </th>                                
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.orders.inputs.order_date')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.orders.inputs.sent')
                                </th>                                
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.orders.inputs.accepted')
                                </th>
                                <th class="px-4 py-3 text-right">
                                    @lang('crud.orders.inputs.received')
                                </th>                                
                                <th class="px-4 py-3 text-center">
                                    @lang('crud.orders.inputs.supplier_id')
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">                            
                            @forelse($orders as $order)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-left">
                                    {{ $order->id ?? '-' }}
                                </td>                                
                                <td class="px-4 py-3 text-left">
                                    {{ $order->order_date ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $order->sent  ? 'YES' : 'NO' }}
                                </td>                                
                                <td class="px-4 py-3 text-right">
                                    {{ ( $order->status == 'complete' || $order->status == 'part-received') ? 'YES' : 'NO' }}
                                </td>                                
                                <td class="px-4 py-3 text-right">
                                    {{ $order->status == 'complete' ? 'YES' : ($order->status == 'part-received' ? 'PART' : 'NO')}}
                                </td>
                                <td class="px-4 py-3 text-right">
                                {{ optional($order->supplier)->company ?? '-' }}
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
                                        @can('update', $order)    
                                        @if($order->status != 'complete' && $order->status != 'cancelled')                                                                              
                                        <a
                                            href="{{ route('orders.send', ['order_id' => $order]) }}"
                                            class="mr-1"
                                            onclick="return confirm('{{ __('crud.common.are_you_sure_for_PO') }}')"
                                        >
                                            <button
                                                type="button"
                                                class="button"
                                            >
                                                <i class="icon ion-md-jet"></i>
                                            </button>
                                        </a>    
                                        @endif 
                                        <a
                                            href="{{ route('orders.detail', ['order_id' => $order]) }}"
                                            class="mr-1"
                                        >
                                            <button
                                                type="button"
                                                class="button"
                                            >
                                                @if($order->status != 'complete' && $order->status != 'cancelled')
                                                <i class="icon ion-md-create"></i>
                                                @elseif($order->status == 'complete' || $order->status == 'cancelled')
                                                <i class="icon ion-md-eye"></i>
                                                @endif
                                            </button>
                                        </a> 
                                        @if($order->status != 'complete' && $order->status != 'cancelled')                                              
                                        <a
                                            href="{{ route('orders.viewmail', ['order_id' => $order]) }}"
                                            class="mr-1"
                                        >
                                            <button
                                                type="button"
                                                class="button"
                                            >
                                                <i class="icon ion-md-mail"></i>
                                            </button>
                                        </a>        
                                        @endif                                                                                                           
                                        @endcan 
                                        @can('delete', $order)
                                        <form
                                            action="{{ route('orders.destroy', ['order_id' => $order]) }}"
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
                                        {!! $orders->render() !!}
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
