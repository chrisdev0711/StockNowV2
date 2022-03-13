<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.suppliers.show_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <x-slot name="title">
                    <a href="{{ route('suppliers.index') }}" class="mr-4"
                        ><i class="mr-1 icon ion-md-arrow-back"></i
                    ></a>
                </x-slot>

                <div class="mt-4 px-4">
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.suppliers.inputs.company')
                        </h5>
                        <span>{{ $supplier->company ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.suppliers.inputs.address_1')
                        </h5>
                        <span>{{ $supplier->address_1 ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.suppliers.inputs.address_2')
                        </h5>
                        <span>{{ $supplier->address_2 ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.suppliers.inputs.city')
                        </h5>
                        <span>{{ $supplier->city ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.suppliers.inputs.county')
                        </h5>
                        <span>{{ $supplier->county ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.suppliers.inputs.postcode')
                        </h5>
                        <span>{{ $supplier->postcode ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.suppliers.inputs.payment_terms')
                        </h5>
                        <span>{{ $supplier->payment_terms ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.suppliers.inputs.order_phone')
                        </h5>
                        <span>{{ $supplier->order_phone ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.suppliers.inputs.order_email_1')
                        </h5>
                        <span>{{ $supplier->order_email_1 ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.suppliers.inputs.order_email_2')
                        </h5>
                        <span>{{ $supplier->order_email_2 ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.suppliers.inputs.order_email_3')
                        </h5>
                        <span>{{ $supplier->order_email_3 ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.suppliers.inputs.account_manager')
                        </h5>
                        <span>{{ $supplier->account_manager ?? '-' }}</span>
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.suppliers.inputs.account_manager_phone')
                        </h5>
                        <span
                            >{{ $supplier->account_manager_phone ?? '-' }}</span
                        >
                    </div>
                    <div class="mb-4">
                        <h5 class="font-medium text-gray-700">
                            @lang('crud.suppliers.inputs.account_manager_email')
                        </h5>
                        <span
                            >{{ $supplier->account_manager_email ?? '-' }}</span
                        >
                    </div>
                </div>

                <div class="mt-10">
                    <a href="{{ route('suppliers.index') }}" class="button">
                        <i class="mr-1 icon ion-md-return-left"></i>
                        @lang('crud.common.back')
                    </a>

                    @can('create', App\Models\Supplier::class)
                    <a href="{{ route('suppliers.create') }}" class="button">
                        <i class="mr-1 icon ion-md-add"></i>
                        @lang('crud.common.create')
                    </a>
                    @endcan
                </div>
            </x-partials.card>
        </div>
    </div>
</x-app-layout>
