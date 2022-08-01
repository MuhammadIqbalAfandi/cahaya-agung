<table>
    <thead>
        <tr>
            <th colspan="5">{{ __('words.report_sale') }}</th>
        </tr>
        <tr>
            <th colspan="5" rowspan="2">{{ __('words.period', ['number' => '']) }}
                {{ $sales->first()['createdAt'] }}
                -
                {{ $sales->last()['createdAt'] }} </th>
        </tr>
        <tr></tr>
        <tr>
            <th>#</th>
            <th>{{ __('words.date') }}</th>
            <th>{{ __('words.quantity') }}</th>
            <th>{{ __('words.status') }}</th>
            <th>{{ __('words.total_price') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($sales as $index => $sale)
            <tr>
                <td>{{ ++$index }}</td>
                <td>{{ $sale['createdAt'] }}</td>
                <td>{{ $sale['qty'] }}</td>
                <td>{{ $sale['status'] }}</td>
                <td>{{ $sale['price'] }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="4">Total</td>
        </tr>
    </tbody>
</table>
