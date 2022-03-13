@php $editing = isset($productCategory) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="name"
            label="Name"
            value="{{ old('name', ($editing ? $productCategory->name : '')) }}"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.checkbox
            name="reported"
            label="Reported"
            :checked="old('reported', ($editing ? $productCategory->reported : 0))"
        ></x-inputs.checkbox>
    </x-inputs.group>
</div>
