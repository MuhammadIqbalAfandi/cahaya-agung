<html>

<head>
    <style>
        * {
            font-family: Verdana, Arial, sans-serif;
        }

        table {
            font-size: x-small;
            border-collapse: collapse;
            border-spacing: 0;
            width: 100%;
        }

        tr {
            vertical-align: super;
        }

        tfoot tr td {
            font-weight: bold;
            font-size: x-small;
        }

        @page {
            margin: 180px 50px;
        }

        #header {
            position: fixed;
            left: 0px;
            top: -180px;
            right: 0px;
            height: 140px;
            text-align: center;
            padding-top: 20px;
        }

        #content {
            position: relative;
            height: 100%;
        }

        #footer {
            position: fixed;
            left: 0px;
            bottom: -180px;
            right: 0px;
            height: 150px;
        }

        .page:after {
            content: counter(page, numeric);
        }
    </style>

    <title>Sale Invoice</title>
</head>

<body>
    <div id="header">
        <h1 style="text-align: right; margin: 0; margin-right: 15%;"><strong
                style="text-transform: uppercase; font-size: medium">INVOICE</strong></h1>

        <table>
            <tr>
                <td style="width: 65%;">
                    <table>
                        <tr>
                            <td><strong>To</strong></td>
                            <td>:</td>
                            <td style="padding: 0;">
                                <table style="border-spacing: 0;">
                                    <tr>
                                        <td>{{ $sale->customer->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>{{ $sale->customer->address }}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>NPWP</strong></td>
                            <td>:</td>
                            <td style="padding: 0">
                                <table style="border-spacing: 0">
                                    <tr>
                                        <td>{{ $sale->customer->npwp }}</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="width: 35%;">
                    <table>
                        <tr>
                            <td>
                                <table>
                                    <tr>
                                        <td>NPWP</td>
                                        <td>:</td>
                                        <td>{{ $company->npwp }}</td>
                                    </tr>
                                    <tr>
                                        <td>Invoice No</td>
                                        <td>:</td>
                                        <td>XXXXXXXXXXXX</td>
                                    </tr>
                                    <tr>
                                        <td>Date</td>
                                        <td>:</td>
                                        <td>{{ $sale->updated_at }}</td>
                                    </tr>
                                    <tr>
                                        <td>PO No</td>
                                        <td>:</td>
                                        <td>{{ $sale->number }}</td>
                                    </tr>
                                    <tr>
                                        <td>DO No</td>
                                        <td>:</td>
                                        <td>XXXXXXXXXXXX</td>
                                    </tr>
                                    <tr>
                                        <td>Halaman</td>
                                        <td>:</td>
                                        <td class="page"></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>

    <div id="footer">
    </div>

    <div id="content">
        <table>
            <thead style="border-top: 1px solid black; border-bottom: 1px solid black;">
                <tr>
                    <th>NO</th>
                    <th>DESCRIPTION</th>
                    <th>QTY</th>
                    <th>UOM</th>
                    <th>UNIT PRICE</th>
                    <th>AMOUNT</th>
                </tr>
            </thead>
            <tbody style="text-align: center;">
                @foreach ($sale->saleDetail as $key => $saleDetail)
                    <tr>
                        <th>{{ $key + 1 }}</th>
                        <td style="text-align: left;">{{ $saleDetail->product->name }}</td>
                        <td>{{ $saleDetail->qty }}</td>
                        <td>UNIT</td>
                        <td style="text-align: right;">
                            {{ App\Services\FunctionService::rupiahFormat($saleDetail->price) }}</td>
                        <td style="text-align: right;">
                            {{ App\Services\FunctionService::rupiahFormat($saleDetail->price * $saleDetail->qty) }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot style="border-top: 1px solid black; border-bottom: 1px solid black; text-align: right;">
                <tr>
                    <td colspan="4"></td>
                    <td>TOTAL</td>
                    <td>{{ App\Services\FunctionService::rupiahFormat(App\Services\SaleService::totalPrice($sale)) }}
                    </td>
                </tr>
                {{-- <tr>
                    <td colspan="4"></td>
                    <td>SUB. TOTAL</td>
                    <td>800.000</td>
                </tr>
                <tr>
                    <td colspan="4"></td>
                    <td>PPN 11%</td>
                    <td>88.000</td>
                </tr>
                <tr>
                    <td colspan="4"></td>
                    <td>TOTAL IDR</td>
                    <td>888.000</td>
                </tr> --}}
            </tfoot>
        </table>

        <p style="margin: 0; font-size: x-small; font-weight: bold; text-align: right;">Semua produk sudah dikenakan ppn
            {{ $sale->ppn ? $ppn : 0 }} %
        </p>

        <div style="position: absolute; bottom: 0; left: 0; right: 0;">
            <table>
                <tbody>
                    <tr>
                        <td style="width: 40%;"></td>
                        <td style="width: 60%;">
                            <table style="width: 100%; text-align: right;">
                                <thead style="margin-bottom: 20px;">
                                    <tr>
                                        <td></td>
                                        <td colspan="1">
                                            <p style="margin-bottom: 75px; margin-top: 70px;">{{ $company->name }}</p>
                                        </td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <span
                                                style="border-top: 1px solid black; width: 150px;display: inline-block; text-align: left;">RECEIVED
                                                BY</span>
                                        </td>
                                        <td>
                                            <span
                                                style="border-top: 1px solid black; width: 120px;display: inline-block; text-align: center;">AUTHORISED
                                                SIGNATURE</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
