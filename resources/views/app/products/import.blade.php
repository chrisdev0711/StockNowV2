<x-app-layout>
    
<div
	class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white"
>
    <form action="{{ route('products.import') }}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="mt-3 text-center mx-auto">   
            @if (Session::has('message'))
            <div class="block mt-3 text-sm text-red-600 bg-red-200 border border-red-400 h-12 flex items-center p-4 rounded-sm relative" role="alert">
                <strong class="mr-4">Error!</strong> {{ Session::get('message') }}
                <button type="button" data-dismiss="alert" aria-label="Close" onclick="this.parentElement.remove();">
                    <span class="absolute top-0 bottom-0 right-0 text-2xl px-3 py-1 hover:text-red-900" aria-hidden="true" >×</span>
                </button>
            </div>   
            @endif 

            <div class="mt-2 px-7 py-3">
                <h3 class="text-sm mx-4 text-gray-500">
                    Select the Ingredients List(Excel)
                </h3>
            </div>
            <label
                class="w-18 flex flex-col items-center px-2 py-2 bg-white rounded-md shadow-md tracking-wide uppercase border border-blue cursor-pointer hover:bg-purple-600 hover:text-white text-purple-600 ease-linear transition-all duration-150">
                <i class="icon ion-md-cloud-upload" style="zoom:4.0;"></i>                
                <input type='file' name="import_file" class="hidden" accept=".csv,.xls,.xlsx"/>
            </label>                                    
            
            <x-inputs.group class="w-full">
                <x-inputs.select name="site_id" label="Belong to">                   
                    <option vale="0">All Sites</option>
                    @foreach($sites as $site)
                    <option value="{{ $site->id }}">{{ $site->name }}</option>
                    @endforeach
                </x-inputs.select>
            </x-inputs.group>

            <div class="items-center px-4 py-3 mt-3">
                <button
                    id="ok-btn"
                    class="px-4 py-2 bg-green-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300"
                >
                    Import Products
                </button>
            </div>
        </div>
    </form>
</div>
</x-app-layout>