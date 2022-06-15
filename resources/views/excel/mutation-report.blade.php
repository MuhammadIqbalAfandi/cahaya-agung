<table>
    <thead>
        <tr>
            <th colspan="5">Laporan Mutasi</th>
        </tr>
        <tr>
            <th colspan="5" rowspan="2">Periode {{ $mutations->first()->created_at }} -
                {{ $mutations->last()->created_at }} </th>
        </tr>
        <tr></tr>
        <tr>
            <th>#</th>
            <th>Tanggal</th>
            <th>Tipe</th>
            <th>Nilai</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($mutations->chunk(100) as $chunk)
            @foreach ($chunk as $index => $mutation)
                <tr>
                    <td>{{ ++$index }}</td>
                    <td>{{ $mutation->created_at }}</td>
                    <td>{{ $mutation->type }}</td>
                    <td>{{ $mutation->amount }}</td>
                </tr>
            @endforeach
        @endforeach
        <tr>
            <td colspan="3">Total</td>
        </tr>
        <tr>
            <td colspan="3">Pendapatan</td>
            <td>{{ App\Services\MutationService::totalIncomeAsString($mutations) }}</td>
        </tr>
        <tr>
            <td colspan="3">Pengeluran</td>
            <td>{{ App\Services\MutationService::totalExpenseAsString($mutations) }}</td>
        </tr>
        <tr>
            <td colspan="3">Jumlah</td>
            <td>{{ App\Services\MutationService::totalAmountAsString($mutations) }}</td>
        </tr>
    </tbody>
</table>
