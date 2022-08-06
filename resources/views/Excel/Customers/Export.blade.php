<table>
    <thead>
        <tr>
            <th colspan="8">{{ __('words.report_history_purchase') }}</th>
        </tr>
        <tr>
            <th colspan="8" rowspan="2">{{ __('words.period', ['number' => '']) }}
                {{ $sales->first()['createdAt'] }}
                -
                {{ $sales->last()['createdAt'] }} </th>
        </tr>
        <tr></tr>
        <tr>
            <th>#</th>
            <th>{{ __('words.date') }}</th>
            <th>{{ __('words.number') }}</th>
            <th>{{ __('words.name_product') }}</th>
            <th>{{ __('words.quantity') }}</th>
            <th>{{ __('words.status') }}</th>
            <th>PPN</th>
            <th>{{ __('words.total_price') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($sales as $index => $sale)
            <tr>
                <td>{{ ++$index }}</td>
                <td>{{ $sale['createdAt'] }}</td>
                <td>{{ $sale['number'] }}</td>
                <td>{{ $sale['name'] }}</td>
                <td>{{ $sale['qty'] }}</td>
                <td>{{ $sale['status'] }}</td>
                <td>{{ $sale['ppn'] }}</td>
                <td>{{ $sale['price'] }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="7">{{ __('words.total') }}</td>
        </tr>
    </tbody>
</table>
