<table>
    <thead>
        <tr>
            <th colspan="8">{{ __('words.report_history_stock_product') }}</th>
        </tr>
        <tr>
            <th colspan="8" rowspan="2">{{ __('words.period', ['number' => '']) }}
                {{ $historyStockProducts->first()['createdAt'] }}
                -
                {{ $historyStockProducts->last()['createdAt'] }} </th>
        </tr>
        <tr></tr>
        <tr>
            <th>#</th>
            <th>{{ __('words.date') }}</th>
            <th>{{ __('words.name_product') }}</th>
            <th>{{ __('words.quantity') }}</th>
            <th>PPN</th>
            <th>{{ __('words.unit') }}</th>
            <th>{{ __('words.total_price') }}</th>
            <th>{{ __('words.category') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($historyStockProducts as $index => $historyStockProduct)
            <tr>
                <td>{{ ++$index }}</td>
                <td>{{ $historyStockProduct['createdAt'] }}</td>
                <td>{{ $historyStockProduct['name'] }}</td>
                <td>{{ $historyStockProduct['qty'] }}</td>
                <td>{{ $historyStockProduct['ppn'] }}</td>
                <td>{{ $historyStockProduct['unit'] }}</td>
                <td>{{ $historyStockProduct['price'] }}</td>
                <td>{{ $historyStockProduct['category'] }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="6">{{ __('words.total') }}</td>
        </tr>
    </tbody>
</table>
