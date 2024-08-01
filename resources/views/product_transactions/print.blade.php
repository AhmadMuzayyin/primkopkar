<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap"
        rel="stylesheet">
    <style>
        /* Gaya untuk memusatkan teks di seluruh tabel */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            text-align: center;
        }
    </style>
</head>

<body>
    <p style="text-align: center">PRIMER KOPERASI KARYAWAN</p>
    <hr class="hr">
    <p style="text-align: center">{{ $product->user->name . ' / ' . $product->created_at . ' / ' . $product->type }}</p>
    <hr class="hr">
    <table>
        @php
            $total = 0;
        @endphp
        @foreach ($items as $item)
            @php
                $price = 0;
                if ($product->type == 'Credit') {
                    $price = $item->price + $item->shu * $item->quantity;
                } else {
                    $price = $item->price * $item->quantity;
                }
                $total += $price;
            @endphp
            <tr style="text-align: center">
                <td>{{ $item->quantity }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td>x</td>
                <td></td>
                <td></td>
                <td></td>
                <td>{{ $item->product->name }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td>{{ number_format($product->type == 'Credit' ? $item->product->price_credit : $item->product->price) }}
                </td>
            </tr>
        @endforeach
    </table>
    <hr class="hr">
    <table>
        <tr>
            <td>Total</td>
            <td>{{ number_format($total) }}</td>
        </tr>
        <tr>
            <td>Bayar:</td>
            <td>{{ number_format($product->amount_price) }}</td>
        </tr>
        <tr>
            <td>Kembali:</td>
            <td>
                @php
                    $kembali = 0;
                    if ($product->amount_price > $product->amount) {
                        $kembali = $product->amount_price - $product->amount;
                    }
                @endphp
                {{ number_format($kembali) }}
            </td>
        </tr>
    </table>
    <p style="text-align: center">Termikasih, barang yang sudah dibeli tidak dapat dikembalikan.</p>
    <script>
        window.print();
        setTimeout(() => {
            window.close();
        }, 1000);
    </script>
</body>

</html>
