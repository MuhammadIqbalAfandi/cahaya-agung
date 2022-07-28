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

    <title>Sale Delivery Order</title>
</head>

<body>
    <div id="header">
        <h1 style="text-align: right; margin: 0; margin-right: 10%;"><strong
                style="text-transform: uppercase; font-size: medium">DELIVERY ORDER</strong></h1>

        <table>
            <tr>
                <td style="width: 65%;">
                    <table>
                        <tr>
                            <td><strong>TO</strong></td>
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
                            <td><strong>TLP</strong></td>
                            <td>:</td>
                            <td style="padding: 0">
                                <table style="border-spacing: 0">
                                    <tr>
                                        <td>{{ $sale->customer->phone }}</td>
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
                                        <td>DATE</td>
                                        <td>:</td>
                                        <td>{{ $sale->updated_at }}</td>
                                    </tr>
                                    <tr>
                                        <td>SALE NO</td>
                                        <td>:</td>
                                        <td>{{ $sale->number }}</td>
                                    </tr>
                                    <tr>
                                        <td>PAGE</td>
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
        <table style="border: 1px solid black;">
            <thead style="border: 1px solid black;">
                <tr style="border: 1px solid black;">
                    <th style="border-left: 1px solid black;">ITEM</th>
                    <th style="border-left: 1px solid black;">DESCRIPTION</th>
                    <th style="border-left: 1px solid black;">QTY</th>
                    <th style="border-left: 1px solid black;">UOM</th>
                    <th style="border-left: 1px solid black;">REMAKS</th>
                </tr>
            </thead>
            <tbody style="text-align: center;">
                @foreach ($sale->saleDetail as $key => $saleDetail)
                    <tr>
                        <td style="border-left: 1px solid black;">{{ $key + 1 }}</td>
                        <td style="border-left: 1px solid black; text-align: left;">{{ $saleDetail->product->name }}
                        </td>
                        <td style="border-left: 1px solid black;">{{ $saleDetail->qty }}</td>
                        <td style="border-left: 1px solid black;">UNIT</td>
                        <td style="border-left: 1px solid black;"></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <p>RECEIVED IN GOOD ORDER & CONDITION</p>

        <div style="position: absolute; bottom: 0; left: 0; right: 0;">
            <table>
                <tbody>
                    <tr>
                        <td>
                            <table style="width: 100%; text-align: center">
                                <thead style="margin-bottom: 20px;">
                                    <tr>
                                        <td></td>
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
                                                style="border-top: 1px solid black; width: 120px;display: inline-block; text-align: center;">CHOP
                                                & SIGN</span>
                                        </td>
                                        <td>
                                            <span
                                                style="border-top: 1px solid black; width: 120px;display: inline-block; text-align: center;">DELIVERY</span>
                                        </td>
                                        <td>
                                            <span
                                                style="border-top: 1px solid black; width: 150px;display: inline-block; text-align: center;"></span>
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
