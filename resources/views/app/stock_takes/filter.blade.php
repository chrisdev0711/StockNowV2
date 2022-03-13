<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.stockTakes.create_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>   
                <x-form
                    method="POST"
                    action="{{ route('stockTakes.create') }}"
                    class="mt-4"
                >             
                    <div class="grid grid-cols-2 mt-6">
                        <p class="text-lg md:text-lg px-4 mb-3 col-span-3">
                            Specify StockTake Type
                        </p>
                        <x-inputs.group
                            class="focus:ring-indigo-500 focus:border-indigo-500 w-full rounded-none rounded-r-md sm:text-sm border-gray-300">
                            <x-inputs.select name="type_filter" id="type_filter" label="StockTake Type">
                                <option value="">-- Select Type --</option>                            
                                <option value="Full Stocktake">Full Stocktake</option>
                                <option value="By Category">By Category</option>
                                <option value="By Supplier">By Supplier</option>                            
                            </x-inputs.select>
                        </x-inputs.group>
                        <x-inputs.group
                            class="focus:ring-indigo-500 focus:border-indigo-500 w-full rounded-none rounded-r-md sm:text-sm border-gray-300">
                            <x-inputs.select name="subType_filter" id="subType_filter" label="Sub Type">
                                <option value="">-- Select Sub Type --</option>
                            </x-inputs.select>
                        </x-inputs.group>                    
                    </div> 

                    <div class="grid grid-cols-2 mt-6">
                        <p class="text-lg md:text-lg px-4 mb-3 col-span-3">
                            Specify Area for StockTake
                        </p>
                        <x-inputs.group
                            class="focus:ring-indigo-500 focus:border-indigo-500 w-full rounded-none rounded-r-md sm:text-sm border-gray-300">
                            <x-inputs.select name="area_filter" id="area_filter" label="Area Type">
                                <option value="">-- Select Area Type --</option>                            
                                <option value="All Areas">All Areas</option>
                                <option value="By Area">By Area</option>
                            </x-inputs.select>
                        </x-inputs.group>   
                        <x-inputs.group
                            class="focus:ring-indigo-500 focus:border-indigo-500 w-full rounded-none rounded-r-md sm:text-sm border-gray-300">
                            <x-inputs.select name="areaSub_filter" id="areaSub_filter" label="Area">
                                <option value="">-- Select Area --</option>
                            </x-inputs.select>
                        </x-inputs.group>                                                         
                    </div>

                    <button type="submit" class="button btn-update button-primary float-right mr-4 mt-6">
                        @lang('crud.common.start')
                    </button>
                </x-form>
            </x-partials.card>
        </div>
    </div>
</x-app-layout>

<script>
    var categories = {!! json_encode($categories) !!}
    var suppliers = {!! json_encode($suppliers) !!}
    var areas = {!! json_encode($areas) !!}
</script>

<script src="{{ asset('js/stocktake.js') }}"></script>