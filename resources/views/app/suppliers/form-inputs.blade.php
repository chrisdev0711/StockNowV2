@php $editing = isset($supplier) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="company"
            label="Company"
            value="{{ old('company', ($editing ? $supplier->company : '')) }}"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="address_1"
            label="Address 1"
            value="{{ old('address_1', ($editing ? $supplier->address_1 : '')) }}"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="address_2"
            label="Address 2"
            value="{{ old('address_2', ($editing ? $supplier->address_2 : '')) }}"
            maxlength="255"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="city"
            label="City"
            value="{{ old('city', ($editing ? $supplier->city : '')) }}"
            maxlength="255"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="county"
            label="County"
            value="{{ old('county', ($editing ? $supplier->county : '')) }}"
            maxlength="255"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="postcode"
            label="Postcode"
            value="{{ old('postcode', ($editing ? $supplier->postcode : '')) }}"
            maxlength="255"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="payment_terms"
            label="Payment Terms"
            value="{{ old('payment_terms', ($editing ? $supplier->payment_terms : '')) }}"
            maxlength="255"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="order_phone"
            label="Order Phone"
            value="{{ old('order_phone', ($editing ? $supplier->order_phone : '')) }}"
            maxlength="255"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="order_email_1"
            label="Order Email 1"
            value="{{ old('order_email_1', ($editing ? $supplier->order_email_1 : '')) }}"
            maxlength="255"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="order_email_2"
            label="Order Email 2"
            value="{{ old('order_email_2', ($editing ? $supplier->order_email_2 : '')) }}"
            maxlength="255"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="order_email_3"
            label="Order Email 3"
            value="{{ old('order_email_3', ($editing ? $supplier->order_email_3 : '')) }}"
            maxlength="255"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="account_manager"
            label="Account Manager"
            value="{{ old('account_manager', ($editing ? $supplier->account_manager : '')) }}"
            maxlength="255"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="account_manager_phone"
            label="Account Manager Phone"
            value="{{ old('account_manager_phone', ($editing ? $supplier->account_manager_phone : '')) }}"
            maxlength="255"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="account_manager_email"
            label="Account Manager Email"
            value="{{ old('account_manager_email', ($editing ? $supplier->account_manager_email : '')) }}"
            maxlength="255"
        ></x-inputs.text>
    </x-inputs.group>
</div>
