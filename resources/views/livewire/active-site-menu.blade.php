@if(isset($sites) && !empty($sites))
    @if(count($sites) == 1)
    <button wire:model="active" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
        @if($active->logoUrl)
        <!-- <span class="flex-shrink-0 mr-3">
            <img class="h-10 w-10 rounded-full object-cover" src="{{ $active->logoUrl }}" alt="{{ $active->name }}" />
        </span> -->
        @endif
        {{ $active->name }}
    </button>
    @else
    <x-jet-dropdown align="right" width="48">
        <x-slot name="trigger">            
            <span class="inline-flex rounded-md">
                <button wire:model="active" type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                    @if($active->logoUrl)
                    <!-- <span class="flex-shrink-0 mr-3">
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ $active->logoUrl }}" alt="{{ $active->name }}" />
                    </span> -->
                    @endif
                    {{ $active->name }}                    
                    <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </span>
        </x-slot>

        <x-slot name="content">
            <!-- Active Site Management -->
            <div class="block px-4 py-2 text-xs text-gray-400">
                {{ __('Set Active Site') }}
            </div> 
            @foreach($sites as $site)                   
                <a
                    class="bg-white block px-4 py-2 flex text-sm items-center text-gray-700 w-full cursor-pointer"                
                    wire:click="setActive({{ $site }})"
                > 
                {{ $site->name }}               
                </a> 
            @endforeach          
        </x-slot>
    </x-jet-dropdown>
    @endif
@endif