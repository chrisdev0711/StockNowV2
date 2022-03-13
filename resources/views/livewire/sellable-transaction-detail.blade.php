<div>
    <div class="block w-full overflow-auto scrolling-touch mt-4">
        <table class="w-full max-w-full mb-4 bg-transparent">
            <thead class="text-gray-700">
                <tr>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.sellable_transaction_detail.inputs.transaction_time')
                    </th>
                    <th class="px-4 py-3 text-left">
                        Quantity
                    </th>
                    <th class="px-4 py-3 text-left">
                        Net
                    </th>
                    <th class="px-4 py-3 text-left">
                        @lang('crud.sellable_transaction_detail.inputs.sale_price')
                    </th>
                </tr>
            </thead>
            <tbody class="text-gray-600">
                @foreach ($transactionsDetail as $transaction)
                <tr class="hover:bg-gray-100">
                    <td class="px-4 py-3 text-left">
                        {{ $transaction->transaction_time ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        {{ $transaction->quantity ?? '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        £{{ $transaction->net_sale_money ? ($transaction->net_sale_money)/100 : '-' }}
                    </td>
                    <td class="px-4 py-3 text-left">
                        £{{ $transaction->gross_sale_money ? ($transaction->gross_sale_money)/100 : '-' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5">
                        <div class="mt-10 px-4">
                            {{ $transactionsDetail->render() }}
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
