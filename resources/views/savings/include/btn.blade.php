<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-{{ $model->id }}">
    <i class="bx bx-show"></i>
</button>
<x-t-modal id="modal-{{ $model->id }}" title="Riwayat Transaksi" lg="modal-lg">
    <div class="modal-body">
        <table class="table table-borderless table-striped table-nowrap table-hover table-centered m-0"
            id="table-{{ $model->id }}">
            <thead class="thead-light">
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Kategori</th>
                    <th>Nominal</th>
                    <th>Jenis</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
        <div class="table-responsive">
        </div>
    </div>
</x-t-modal>
<script>
    $('#modal-{{ $model->id }}').on('hidden.bs.modal', function() {
        $('#table-{{ $model->id }}').DataTable().destroy();
    });
    $('#modal-{{ $model->id }}').on('show.bs.modal', function() {
        var columns = [{
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'created_at',
                name: 'created_at',
                render: function(data) {
                    return moment(data).format('DD MMMM YYYY');
                }
            },
            {
                data: 'saving_category_name',
                name: 'saving_category.name'
            },
            {
                data: 'nominal',
                name: 'nominal'
            },
            {
                data: 'type',
                name: 'type'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ];
        var table = $('#table-{{ $model->id }}').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('savings.history', $model->id) }}",
                type: 'GET'
            },
            columns: columns
        });
    });
</script>
@if (\Auth::user()->role == App\Role::Admin->value)
    <button type="button" class="btn btn-danger btn-sm" id="delete-{{ $model->id }}">
        <i class="bx bx-trash"></i>
    </button>
    <script>
        $('#delete-{{ $model->id }}').on('click', function() {
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: 'Data yang dihapus tidak dapat dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ route('savings.destroy', $model->id) }}',
                        type: 'DELETE',
                        data: {
                            '_token': '{{ csrf_token() }}'
                        },
                        success: function(res) {
                            Swal.fire({
                                icon: 'success',
                                title: res.message,
                                showConfirmButton: false,
                                timer: 1500
                            });
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        },
                        error: function(err) {
                            Swal.fire({
                                icon: 'error',
                                title: err.message,
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    });
                }
            });
        });
    </script>
@endif
