@php $editing = isset($site) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full lg:w-8/12">
        <x-inputs.text
            name="name"
            label="Name"
            value="{{ old('name', ($editing ? $site->name : '')) }}"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full lg:w-4/12">
        <x-inputs.text
            name="code"
            label="Code"
            value="{{ old('code', ($editing ? $site->code : '')) }}"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="address_1"
            label="Address 1"
            value="{{ old('address_1', ($editing ? $site->address_1 : '')) }}"
            maxlength="255"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="address_2"
            label="Address 2"
            value="{{ old('address_2', ($editing ? $site->address_2 : '')) }}"
            maxlength="255"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="city"
            label="City"
            value="{{ old('city', ($editing ? $site->city : '')) }}"
            maxlength="255"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="county"
            label="County"
            value="{{ old('county', ($editing ? $site->county : '')) }}"
            maxlength="255"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="postcode"
            label="Postcode"
            value="{{ old('postcode', ($editing ? $site->postcode : '')) }}"
            maxlength="255"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.email
            name="email"
            label="Email"
            value="{{ old('email', ($editing ? $site->email : '')) }}"
            maxlength="255"
        ></x-inputs.email>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.checkbox
            name="display_on_orders"
            label="Display On Orders"
            :checked="old('display_on_orders', ($editing ? $site->display_on_orders : 0))"
        ></x-inputs.checkbox>
    </x-inputs.group>
</div>
