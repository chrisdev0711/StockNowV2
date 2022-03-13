@php $editing = isset($product) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="name"
            label="Name"
            value="{{ old('name', ($editing ? $product->name : '')) }}"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="sku"
            label="Sku"
            value="{{ old('sku', ($editing ? $product->sku : '')) }}"
            maxlength="255"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea
            name="description"
            label="Description"
            maxlength="255"
            >{{ old('description', ($editing ? $product->description : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>
    
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="serving_name"
            label="Serving_name"
            value="{{ old('serving_name', ($editing ? $product->serving_name : '')) }}"
            maxlength="255"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="par_level"
            label="Par Level"
            value="{{ old('par_level', ($editing ? $product->par_level : '')) }}"
            max="255"
            step="0.01"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="reorder_point"
            label="Reorder Point"
            value="{{ old('reorder_point', ($editing ? $product->reorder_point : '')) }}"
            max="255"
            step="0.01"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="product_category_id" label="Product Category">
            @php $selected = old('product_category_id', ($editing ? $product->product_category_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Product Category</option>
            @foreach($productCategories as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="supplier_id" label="Supplier">
            @php $selected = old('supplier_id', ($editing ? $product->supplier_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Supplier</option>
            @foreach($suppliers as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="supplier_sku"
            label="Supplier Sku"
            value="{{ old('supplier_sku', ($editing ? $product->supplier_sku : '')) }}"
            maxlength="255"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="entered_cost"
            label="Entered Cost"
            value="{{ old('entered_cost', ($editing ? $product->entered_cost : '')) }}"
            max="255"
            step="0.01"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.checkbox
            name="entered_inc_vat"
            label="Entered Inc Vat"
            :checked="old('entered_inc_vat', ($editing ? $product->entered_inc_vat : 0))"
        ></x-inputs.checkbox>
    </x-inputs.group>
    
    <x-inputs.group class="w-full">
        <x-inputs.select name="vat_rate" label="Vat Rate">
            @php $selected = old('vat_rate', ($editing ? $product->vat_rate : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Vat Rate</option>            
            @foreach($vat_rates as $vat)
            <option value="{{ $vat->rate }}" {{ $selected == $vat->rate ? 'selected' : '' }} >{{ $vat->rate . '%' }}</option>
            @endforeach            
        </x-inputs.select>
    </x-inputs.group>

    @if($editing)
    <x-inputs.group class="w-full">
        <x-inputs.number
            name="gross_cost"
            label="Gross Cost"
            value="{{ old('gross_cost', ($editing ? $product->gross_cost : '')) }}"
            max="255"
            step="0.01"
            readonly
        ></x-inputs.number>
    </x-inputs.group>
    @endif
    
    @if($editing)
    <x-inputs.group class="w-full">
        <x-inputs.number
            name="net_cost"
            label="Net Cost"
            value="{{ old('net_cost', ($editing ? $product->net_cost : '')) }}"
            max="255"
            step="0.01"
            readonly
        ></x-inputs.number>
    </x-inputs.group>
    @endif

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="pack_type"
            label="Pack Type"
            value="{{ old('pack_type', ($editing ? $product->pack_type : '')) }}"
            maxlength="255"
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.checkbox
            name="multipack"
            label="Multipack"
            :checked="old('multipack', ($editing ? $product->multipack : 0))"
        ></x-inputs.checkbox>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="units_per_pack"
            label="Units Per Pack"
            value="{{ old('units_per_pack', ($editing ? $product->units_per_pack : '')) }}"
            max="255"
            step="0.01"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="servings_per_unit"
            label="Servings Per Unit"
            value="{{ old('servings_per_unit', ($editing ? $product->servings_per_unit : '')) }}"
            max="255"
            step="0.01"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <label class="">Locations</label>
        @foreach($locations as $location)
        <x-inputs.checkbox
            name="locations[]"
            value="{{$location->name}}"
            label="{{$location->name}}"
            :checked="$editing ? $product->exitsTo($location->id) : false"
        >
        </x-inputs.checkbox>
        @endforeach
    </x-inputs.group>
</div>
