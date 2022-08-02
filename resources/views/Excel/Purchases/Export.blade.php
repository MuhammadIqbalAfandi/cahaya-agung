<table>
    <thead>
        <tr>
            <th colspan="5">{{ __('words.report_purchase') }}</th>
        </tr>
        <tr>
            <th colspan="5" rowspan="2">{{ __('words.period', ['number' => '']) }}
                {{ $purchases->first()['createdAt'] }}
                -
                {{ $purchases->last()['createdAt'] }} </th>
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
        @foreach ($purchases as $index => $purchase)
            <tr>
                <td>{{ ++$index }}</td>
                <td>{{ $purchase['createdAt'] }}</td>
                <td>{{ $purchase['qty'] }}</td>
                <td>{{ $purchase['status'] }}</td>
                <td>{{ $purchase['price'] }}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="4">{{ __('words.total') }}</td>
        </tr>
    </tbody>
</table>
