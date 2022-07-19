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
            height: 110px;
            text-align: center;
            padding-top: 40px;
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

<body>
    <div id="header">
        <table>
            <tr>
                <td style="width: 65%;">
                    <table>
                        <tr>
                            <td style="vertical-align: super;"><strong>To</strong></td>
                            <td style="vertical-align: super;">:</td>
                            <td style="padding: 0;">
                                <table style="border-spacing: 0;">
                                    <tr>
                                        <td>Cahaya Agung</td>
                                    </tr>
                                    <tr>
                                        <td>Anonym</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td style="vertical-align: super"><strong>NPWP</strong></td>
                            <td style="vertical-align: super">:</td>
                            <td style="padding: 0">
                                <table style="border-spacing: 0">
                                    <tr>
                                        <td>XXXXXXXXXXXXXXX</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="width: 35%;">
                    <table>
                        <tr style="text-align: center">
                            <td> <strong style="text-transform: uppercase; font-size: medium">INVOICE</strong></td>
                        </tr>
                        <tr>
                            <td>
                                <table>
                                    <tr>
                                        <td>Nama</td>
                                        <td>:</td>
                                        <td>Anonym</td>
                                    </tr>
                                    <tr>
                                        <td>No HP</td>
                                        <td>:</td>
                                        <td>08XXXXXXXXXX</td>
                                    </tr>
                                    <tr>
                                        <td>Alamat</td>
                                        <td>:</td>
                                        <td>Anonym</td>
                                    </tr>
                                    <tr>
                                        <td>Tanggal</td>
                                        <td>:</td>
                                        <td>Anonym</td>
                                    </tr>
                                    <tr>
                                        <td>Nomor Pembelian</td>
                                        <td>:</td>
                                        <td>Anonym</td>
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
                    <th>No</th>
                    <th>Keterangan</th>
                    <th>QTY</th>
                    <th>Satuan</th>
                    <th>Harga Satuan</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody style="text-align: center;">
                @for ($i = 0; $i < 150; $i++)
                    <tr>
                        <th>1</th>
                        <td style="text-align: left;">Playstation IV - Black</td>
                        <td>1</td>
                        <td>pc</td>
                        <td style="text-align: right;">1400.00</td>
                        <td style="text-align: right;">1400.00</td>
                    </tr>
                @endfor
            </tbody>
            <tfoot style="border-top: 1px solid black; border-bottom: 1px solid black; text-align: right;">
                <tr>
                    <td colspan="4"></td>
                    <td>Subtotal Rp</td>
                    <td>1635.00</td>
                </tr>
                <tr>
                    <td colspan="4"></td>
                    <td>PPN 11%</td>
                    <td>1929.3</td>
                </tr>
                <tr>
                    <td colspan="4"></td>
                    <td>Total Rp</td>
                    <td>1929.3</td>
                </tr>
            </tfoot>
        </table>

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
                                        <p style="margin-bottom: 75px; margin-top: 70px;">Cahaya Agung</p>
                                    </td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <span
                                            style="border-top: 1px solid black; width: 150px;display: inline-block; text-align: left;">Diterima</span>
                                    </td>
                                    <td>
                                        <span
                                            style="border-top: 1px solid black; width: 120px;display: inline-block; text-align: center;">Penjual</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
