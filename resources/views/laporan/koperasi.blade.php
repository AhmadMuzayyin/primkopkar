<h4 class="fw-bold fs-2 text-white text-uppercase my-3 bg-danger text-center">Laporan Simpanan</h4>
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
<table class="table table-responsive table-striped" id="simpanan">
    <thead>
        <tr>
            <th>No</th>
            <th>Member</th>
            <th>Debit/Credit</th>
            <th>Kategori</th>
            <th>Saldo</th>
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
                data: 'member',
                name: 'member'
            },
            {
                data: 'debit_credit',
                name: 'debit_credit',
            },
            {
                data: 'kategori',
                name: 'kategori',
            },
            {
                data: 'saldo',
                name: 'saldo',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp. ')
            },
        ];
        var table = $('#simpanan').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('laporan.simpanan') }}',
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
<hr class="border border-success border-5 opacity-75 my-5">
<h4 class="fw-bold fs-2 text-white text-uppercase my-3 bg-danger text-center">Laporan Pinjaman</h4>
<table class="table table-responsive table-striped" id="pinjaman">
    <thead>
        <tr>
            <th>No</th>
            <th>Member</th>
            <th>Nominal</th>
            <th>Tanggal Pinjaman</th>
            <th>Tanggal Pelunasan</th>
            <th>Angsuran</th>
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
                data: 'member',
                name: 'member'
            },
            {
                data: 'nominal',
                name: 'nominal'
            },
            {
                data: 'tgl_pinjaman',
                name: 'tgl_pinjaman',
            },
            {
                data: 'tgl_pelunasan',
                name: 'tgl_pelunasan',
            },
            {
                data: 'angsuran',
                name: 'angsuran',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp. ')
            },
        ];
        $('#pinjaman').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('laporan.pinjaman') }}',
            columns: columns
        });
    </script>
@endpush
