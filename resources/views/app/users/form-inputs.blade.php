@php $editing = isset($user) @endphp

<div class="flex flex-wrap">    
    <x-inputs.group class="w-full">
        <x-inputs.text
            name="name"
            label="Name"
            value="{{ old('name', ($editing ? $user->name : '')) }}"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="email"
            label="Email"
            value="{{ old('email', ($editing ? $user->email : '')) }}"
            maxlength="255"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.password
            name="password"
            label="Password"
            maxlength="255"
            placeholder="Password"
            :required="!$editing"
        ></x-inputs.password>
    </x-inputs.group>


    <x-inputs.group class="w-full">
        <x-inputs.password
            name="password_confirmation"
            label="Password Confirmation"
            maxlength="255"
        ></x-inputs.password>
    </x-inputs.group> 

    <x-inputs.group class="w-full">
        <label class="">Locations</label>
        @foreach($locations as $location)
        <x-inputs.checkbox
            name="location_ids[]"
            label="{{$location->name}}"
            value="{{ $location->id }}"   
            :checked="$editing ? in_array($location->id, $user->locations()) ? 1 : 0 : 0"         
        >
        </x-inputs.checkbox>
        @endforeach
    </x-inputs.group>

    @if(Auth::user()->isSuperAdmin())
    <x-inputs.group class="w-full">
        <label class="">Role</label>
        @foreach($roles as $role)
        <x-inputs.checkbox
            name="roles[]"
            label="{{$role->name}}"
            value="{{ $role->id }}"   
            :checked="$editing ? $user->hasRole($role) ? 1 : 0 : 0"         
        >
        </x-inputs.checkbox>
        @endforeach
    </x-inputs.group>
    @endif
    
</div>