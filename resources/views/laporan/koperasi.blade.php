<h4 class="fw-bold fs-2 text-white text-uppercase my-3 bg-danger text-center">Laporan Simpanan</h4>
<div class="row">
    <div class="col">
        <x-t-input id="from" name="from" t="datetime-local" r="" />
    </div>
    <div class="col">
        <x-t-input id="to" name="to" t="datetime-local" r="" />
    </div>
    <div class="col">
        <button class="btn btn-primary" id="ftSimpanan">
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
        var tbSimpanan = $('#simpanan').DataTable({
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
                url: '{{ route('laporan.simpanan') }}',
                data: function(d) {
                    d.from = $('#from').val();
                    d.to = $('#to').val();
                }
            },
            columns: columns
        });

        $('#ftSimpanan').on('click', function() {
            tbSimpanan.ajax.reload();
        });
    </script>
@endpush
<hr class="border border-success border-5 opacity-75 my-5">
<h4 class="fw-bold fs-2 text-white text-uppercase my-3 bg-danger text-center">Laporan Pinjaman</h4>
<div class="row">
    <div class="col">
        <x-t-input id="from" name="from" t="datetime-local" r="" />
    </div>
    <div class="col">
        <x-t-input id="to" name="to" t="datetime-local" r="" />
    </div>
    <div class="col">
        <button class="btn btn-primary" id="ftPinjaman">
            <i class="bx bx-filter"></i>
        </button>
    </div>
</div>
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
        var tbPinjaman = $('#pinjaman').DataTable({
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
            ajax: '{{ route('laporan.pinjaman') }}',
            columns: columns
        });
        $('#ftPinjaman').on('click', function() {
            tbPinjaman.ajax.reload();
        });
    </script>
@endpush
