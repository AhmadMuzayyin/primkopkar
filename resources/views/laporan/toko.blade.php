<h4 class="fw-bold fs-2 text-white text-uppercase my-3 bg-danger text-center">Laporan Kulakan Barang</h4>
<div class="row">
    <div class="col">
        <x-t-input id="from" name="from" t="datetime-local" r="" />
    </div>
    <div class="col">
        <x-t-input id="to" name="to" t="datetime-local" r="" />
    </div>
    <div class="col">
        <button class="btn btn-primary" id="filterKulakan">
            <i class="bx bx-filter"></i>
        </button>
    </div>
</div>
<table class="table table-responsive table-striped" id="kulakan">
    <thead>
        <tr>
            <th>No</th>
            <th>Kasir</th>
            <th>Nama Barang</th>
            <th>Harga Beli</th>
            <th>Stok Input</th>
        </tr>
    </thead>
</table>
@push('js')
    <script>
        var columns = [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'kasir',
                name: 'kasir'
            },
            {
                data: 'barang',
                name: 'barang'
            },
            {
                data: 'purchase_price',
                name: 'purchase_price',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp. ')
            },
            {
                data: 'stock',
                name: 'stock'
            },
        ];
        var tableKulakan = $('#kulakan').DataTable({
            processing: true,
            serverSide: true,
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'print',
                    text: '<i class="bx bx-printer"></i> Print Laporan',
                    className: 'btn btn-primary'
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="bx bx-file"></i> Export PDF',
                    className: 'btn btn-success'
                },
            ],
            ajax: {
                url: '{{ route('laporan.kulakan') }}',
                data: function(d) {
                    d.from = $('#from').val();
                    d.to = $('#to').val();
                }
            },
            columns: columns
        });

        $('#filterKulakan').on('click', function() {
            tableKulakan.ajax.reload();
        });
    </script>
@endpush

<hr class="border border-success border-5 opacity-75 my-5">

<h4 class="fw-bold fs-2 text-white text-uppercase my-3 bg-danger text-center">Laporan Penjualan Perbarang</h4>
<div class="row">
    <div class="col">
        <x-t-input id="from" name="from" t="datetime-local" r="" />
    </div>
    <div class="col">
        <x-t-input id="to" name="to" t="datetime-local" r="" />
    </div>
    <div class="col">
        <button class="btn btn-primary" id="ftPerbarang">
            <i class="bx bx-filter"></i>
        </button>
    </div>
</div>
<table class="table table-responsive table-striped" id="perBarang">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Harga Beli</th>
            <th>Harga Jual</th>
            <th>Harga Kredit</th>
            <th>Stok</th>
            <th>Laku</th>
            <th>Total</th>
        </tr>
    </thead>
</table>
@push('js')
    <script>
        var columns = [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'purchase_price',
                name: 'purchase_price',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp. ')
            },
            {
                data: 'price',
                name: 'price',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp. ')
            },
            {
                data: 'price_credit',
                name: 'price_credit',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp. ')
            },
            {
                data: 'stock',
                name: 'stock'
            },
            {
                data: 'total_sold',
                name: 'total_sold'
            },
            {
                data: 'total_revenue',
                name: 'total_revenue',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp. ')
            },
        ];
        var tablePerbarang = $('#perBarang').DataTable({
            processing: true,
            serverSide: true,
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'print',
                    text: '<i class="bx bx-printer"></i> Print Laporan',
                    className: 'btn btn-primary'
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="bx bx-file"></i> Export PDF',
                    className: 'btn btn-success'
                },
            ],
            ajax: {
                url: '{{ route('laporan.perbarang') }}',
                data: function(d) {
                    d.from = $('#from').val();
                    d.to = $('#to').val();
                }
            },
            columns: columns
        });

        $('#ftPerbarang').on('click', function() {
            tablePerbarang.ajax.reload();
        });
    </script>
@endpush

<hr class="border border-success border-5 opacity-75 my-5">

<h4 class="fw-bold fs-2 text-white text-uppercase my-3 bg-danger text-center">Anggota Dengan Piutang</h4>
<div class="row">
    <div class="col">
        <x-t-input id="from" name="from" t="datetime-local" r="" />
    </div>
    <div class="col">
        <x-t-input id="to" name="to" t="datetime-local" r="" />
    </div>
    <div class="col">
        <button class="btn btn-primary" id="ftAnggota">
            <i class="bx bx-filter"></i>
        </button>
    </div>
</div>
<table class="table table-responsive table-striped" id="memberCredit">
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Telepon</th>
            <th>Hutang</th>
            <th>
                <i class="bx bx-cog"></i>
            </th>
        </tr>
    </thead>
</table>
@push('js')
    <script>
        var columns = [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'address',
                name: 'address'
            },
            {
                data: 'phone',
                name: 'phone'
            },
            {
                data: 'credit',
                name: 'credit',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp. ')
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ];
        var tbAnggota = $('#memberCredit').DataTable({
            processing: true,
            serverSide: true,
            dom: 'Bfrtip',
            buttons: [{
                    extend: 'print',
                    text: '<i class="bx bx-printer"></i> Print Laporan',
                    className: 'btn btn-primary'
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="bx bx-file"></i> Export PDF',
                    className: 'btn btn-success'
                },
            ],
            ajax: '{{ route('laporan.piutang_member') }}',
            columns: columns
        });
        $('#ftPerbarang').on('click', function() {
            tbAnggota.ajax.reload();
        });
    </script>
@endpush
