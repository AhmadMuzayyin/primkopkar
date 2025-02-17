<!DOCTYPE html>
<html>

<head>
    <title>Struk Pembayaran</title>
    <style>
        .receipt-container {
            width: 80mm;
            padding: 10px;
            font-family: 'Arial', sans-serif;
            font-size: 12px;
        }

        .receipt-header {
            text-align: center;
            margin-bottom: 15px;
        }

        .receipt-title {
            font-size: 14px;
            font-weight: bold;
            margin: 5px 0;
        }

        .receipt-item {
            margin: 5px 0;
        }

        .receipt-total {
            margin-top: 10px;
            padding-top: 5px;
            border-top: 1px dashed #000;
            font-weight: bold;
        }

        .receipt-footer {
            margin-top: 15px;
            text-align: center;
            font-size: 10px;
        }

        @media print {
            @page {
                margin: 0;
                size: 80mm 200mm;
            }

            body {
                margin: 0;
            }
        }
    </style>
</head>

<body>
    <div class="receipt-container">
        <div class="receipt-header">
            <div class="receipt-title">STRUK PEMBAYARAN</div>
            <div>{{ config('app.name') }}</div>
            <div>{{ date('d/m/Y H:i:s') }}</div>
        </div>

        <div class="receipt-item">No. Transaksi: @{{ payment_reference }}</div>
        <div class="receipt-item">Tanggal: @{{ tgl_bayar }}</div>
        <div class="receipt-item">Metode Bayar: @{{ metode_bayar }}</div>

        <div class="receipt-item">
            <hr style="border-top: 1px dashed #000;">
        </div>

        <div class="receipt-item">Volume: @{{ volume_m3 }} m³</div>
        <div class="receipt-item">Jenis Pengiriman: @{{ jenis_pengiriman }}</div>
        <div class="receipt-item">Biaya Pengiriman: Rp @{{ formatNumber(total_biaya) }}</div>
        <div class="receipt-item">Biaya Operasional: Rp @{{ formatNumber(biaya_operasional) }}</div>

        <div class="receipt-total">
            TOTAL: Rp @{{ formatNumber(total_biaya + biaya_operasional) }}
        </div>

        <div class="receipt-footer">
            Terima kasih telah menggunakan jasa kami
            <br>
            ** Struk ini merupakan bukti pembayaran yang sah **
        </div>
    </div>
</body>

</html>
