<h4 class="fw-bold fs-2 text-white text-uppercase my-3 bg-danger text-center">Laporan Transaksi Jasa Angkutan</h4>
<div class="row">
    <div class="col">
        <x-t-input id="from" name="from" t="datetime-local" r="" />
    </div>
    <div class="col">
        <x-t-input id="to" name="to" t="datetime-local" r="" />
    </div>
    <div class="col">
        <button class="btn btn-primary" id="filter">
            <i class="bx bx-filter"></i>
        </button>
    </div>
</div>
<table class="table table-responsive table-striped" id="jasa">
    <thead>
        <tr>
            <th>No</th>
            <th>Pelanggan</th>
            <th>BKPH</th>
            <th>Provider</th>
            <th>Total Pembayaran</th>
            <th>Status</th>
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
                data: 'pelanggan',
                name: 'pelanggan'
            },
            {
                data: 'bkph',
                name: 'bkph',
            },
            {
                data: 'provider',
                name: 'provider',
            },
            {
                data: 'total',
                name: 'total',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp. ')
            },
            {
                data: 'status',
                name: 'status'
            },
        ];
        var table = $('#jasa').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('laporan.jasa') }}',
                data: function(d) {
                    d.from = $('#from').val();
                    d.to = $('#to').val();
                }
            },
            columns: columns
        });

        $('#filter').on('click', function() {
            table.ajax.reload(); // Memuat ulang data di DataTable dengan parameter filter
        });
    </script>
@endpush
