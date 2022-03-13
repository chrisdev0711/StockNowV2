@php $editing = isset($order) @endphp

<div class="flex flex-wrap">            
    <x-inputs.group class="w-1/2">
        <x-inputs.text
            name="supplier_id"
            label="Supplier"
            value="{{ old('supplier_id', ($editing ? optional($order->supplier)->company ?? '-' : '')) }}"
            maxlength="255"
            disabled
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-1/2">
        <x-inputs.number
            name="order_total"
            label="Order Total(£)"
            value="{{ old('order_total', ($editing ? $order->orderTotal() : '')) }}"
            max="255"
            step="0.01"
            disabled
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-1/2">
        <x-inputs.select 
            name="sent" 
            label="Sent"
            disabled
        >
            <option value="{{ $order->sent }}" {{ $order->sent == 0 ? 'selected' : '' }} >No</option>
            <option value="{{ $order->sent }}" {{ $order->sent == 1 ? 'selected' : '' }} >Yes</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-1/2">
        <x-inputs.text
            name="fully_received"
            label="Fully Received"
            value="{{ old('status', ($editing ? $order->status == 'complete' ? 'Yes' : 'No' : '')) }}"
            maxlength="255"
            disabled
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-1/2">
        <x-inputs.text
            name="order_date"
            label="Order Date"
            value="{{ old('order_date', ($editing ? $order->order_date : '')) }}"
            maxlength="255"
            disabled
        ></x-inputs.text>
    </x-inputs.group>
    <x-inputs.group class="w-1/2">
        <x-inputs.datetime
            name="delivery_date"
            label="Delivery Date"
            class="{{($order->status == 'complete' || $order->status =='cancelled') ? 'disabled-link' : ''}}"
            value="{{ old('delivery_date', ($editing ? optional($order->delivery_date)->format('Y-m-d\TH:i:s') : '')) }}"
            max="255"
            required
        ></x-inputs.datetime>
    </x-inputs.group>
    <x-inputs.group class="w-1/3">
        <x-inputs.text
            name="net"
            label="NET"
            value="{{$net}}"
            max="255"
            disabled
        ></x-inputs.text>
    </x-inputs.group>    
    <x-inputs.group class="w-1/3">
        <x-inputs.text
            name="vat"
            label="VAT"
            value="{{$vat}}"
            max="255"
            disabled
        ></x-inputs.text>
    </x-inputs.group>        
    <x-inputs.group class="w-1/3">
        <x-inputs.text
            name="total_cost"
            label="TOTAL"
            value="{{$total}}"
            max="255"
            disabled
        ></x-inputs.text>
    </x-inputs.group>   
    
    <x-inputs.group class="w-1/2">
        <x-inputs.text
            name="state"
            label="State"
            value="{{$editing ? $order->status == 'complete' ? 'Recieved' : ($order->status == 'part-received' ? 'PART' : 'Not Received yet') : ''}}"
            max="255"
            disabled
        ></x-inputs.text>
    </x-inputs.group> 
    <x-inputs.group class="w-full">
        <label for="note" class="block font-medium text-gray-700">Notes</label>
        <textarea
            id="note"
            name="note"
            rows="3"
            class="{{($order->status == 'complete' || $order->status =='cancelled') ? 'disabled-link' : ''}} block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            >{{$editing ? $order->note : ''}}</textarea>
    </x-inputs.group>         
</div>
