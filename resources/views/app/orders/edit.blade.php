<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.orders.edit_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <h3 class="font-bold text-lg text-gray-800 leading-tight inline"> 
                    Order Detail 
                </h3>

                <x-form
                    method="POST"
                    action="{{ route('orders.update', ['order_id' => $order]) }}"
                    class="mt-4"
                >
                    @include('app.orders.form-inputs')
                    <div class="mt-10">                         
                        @if(($order->status != 'complete' && $order->status !='cancelled'))                                                                  
                            <button
                                type="submit"
                                class="button button-primary float-right"
                            >
                                <i class="mr-1 icon ion-md-save"></i>
                                @lang('crud.common.update')
                            </button>                    
                        @endif 
                        @if($order->status != 'complete' && $order->status != 'cancelled')                                                                              
                            <a
                                href="{{ route('orders.send', ['order_id' => $order]) }}"
                                class="mr-1 float-right"
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
                    </div>
                </x-form>
            </x-partials.card>                       
        </div>        
    </div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <x-partials.card>
            <x-slot name="title"> Items Ordered List </x-slot>
            @include('app.orders.ordered-items')                
        </x-partials.card> 
    </div>
</x-app-layout>
