<h4 class="fw-bold fs-2 text-white text-uppercase my-3 bg-danger text-center">Laporan Penjualan Perbarang</h4>
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
                data: 'price_credit',
                name: 'price_credit',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp. ')
            },
            {
                data: 'price',
                name: 'price',
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
        $('#perBarang').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('laporan.perbarang') }}',
            columns: columns
        });
    </script>
@endpush
<hr class="border border-success border-5 opacity-75 my-5">
<h4 class="fw-bold fs-2 text-white text-uppercase my-3 bg-danger text-center">Anggota Dengan Piutang</h4>
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
        $('#memberCredit').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('laporan.piutang_member') }}',
            columns: columns
        });
    </script>
@endpush
