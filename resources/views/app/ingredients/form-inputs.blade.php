@php $editing = isset($ingredient) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="sellable_id"
            label="Till Product"
            value="{{ old('sellable_id', ($editing ? $ingredient->sellable_id : '')) }}"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="product_id"
            label="Component Product"
            value="{{ old('product_id', ($editing ? $ingredient->product_id : '')) }}"
            maxlength="255"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="measure"
            label="Measure"
            value="{{ old('measure', ($editing ? $ingredient->measure : '')) }}"
            max="255"
            step="0.01"
            ></x-inputs.number
        >
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="cost_price"
            label="Cost Price"
            value="{{ old('cost_price', ($editing ? $ingredient->cost_price : '')) }}"
            max="255"
            step="0.01"
        ></x-inputs.number>
    </x-inputs.group>    
</div>
