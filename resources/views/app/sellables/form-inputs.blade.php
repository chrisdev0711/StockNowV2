@php $editing = isset($sellable) @endphp

<div class="flex flex-wrap">
    <div class="px-4 my-2 w-full flex">
        <div class="flex-1">
            <label class="label font-medium text-gray-700" for="category_id">
                Name
            </label>
            <input
                type="text"
                name="name"
                label="Name"
                value="{{ old('name', ($editing ? $sellable->name : '')) }}"
                class="block appearance-none w-full py-1 px-2 text-base leading-normal text-gray-800 border border-gray-200 rounded" 
                maxlength="255"
                required
            ></input>
        </div>
        <div class="flex-1 ml-4">
            <label class="label font-medium text-gray-700" for="category_id">
                Sub Name
            </label>
            <input
                type="text"
                name="sub_name"
                label="Sub Name"
                value="{{ old('sub_name', ($editing ? $sellable->sub_name : '')) }}"
                class="block appearance-none w-1/2 py-1 px-2 text-base leading-normal text-gray-800 border border-gray-200 rounded" 
                maxlength="255"
                required
            ></input>
        </div>
    </div>    

    <x-inputs.group class="w-full">
        <x-inputs.textarea
            name="description"
            label="Description"
            maxlength="255"
            >{{ old('description', ($editing ? $sellable->description : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    @if($editing)
    <div class="px-4 my-2 w-full">
        <label class="label font-medium text-gray-700" for="category_id">
            Category
        </label>
        <input 
            type="text" 
            id="category_id" 
            name="category_id" 
            value="{{ old('category_id', ($editing ? $sellable->category() : '')) }}"
            class="block appearance-none w-full py-1 px-2 text-base leading-normal text-gray-800 border border-gray-200 rounded" 
            disabled="disabled" autocomplete="off">
    </div>    
    @endif
    
    <x-inputs.group class="w-full">
        <x-inputs.number
            name="price"
            label="Sale Price"
            value="{{ old('price', ($editing ? $sellable->price : '')) }}"
            max="255"
            step="0.01"
        ></x-inputs.number>
    </x-inputs.group>

    @if($editing)
    <x-inputs.group class="w-full">
        <label class="">Locations</label>
        @foreach($locations as $location)
        <x-inputs.checkbox
            name="location"
            label="{{$location->name}}"
            checked
            disabled
        >
        </x-inputs.checkbox>
        @endforeach
    </x-inputs.group>
    @endif
    
    <x-inputs.group class="w-full">
        <x-inputs.checkbox
            name="active"
            label="Active"
            :checked="old('active', ($editing ? $sellable->active : 0))"
        ></x-inputs.checkbox>
    </x-inputs.group>
</div>
