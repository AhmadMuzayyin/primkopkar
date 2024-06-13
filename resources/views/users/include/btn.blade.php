<button type="button" class="btn btn-primary btn-sm">
    <i class="bx bx-show"></i>
</button>
<button type="button" class="btn btn-warning btn-sm" id="edit-{{ $loop->iteration }}" data-bs-toggle="modal"
    data-bs-target="#edit-{{ $loop->iteration }}">
    <i class="bx bx-edit"></i>
</button>
<x-t-modal id="edit-{{ $loop->iteration }}" title="Edit Pengguna">
    <form action="{{ route('users.update', $user->id) }}" method="post">
        <div class="modal-body">
            @csrf
            @method('PUT')
            @include('users.include.form')
        </div>
        <div class="modal-footer">
            <button class="btn btn-primary mt-3" type="submit">Simpan</button>
        </div>
    </form>
</x-t-modal>
<button type="button" class="btn btn-danger btn-sm" id="delete-{{ $loop->iteration }}">
    <i class="bx bx-trash"></i>
</button>
@push('js')
    <script>
        $('#delete-{{ $loop->iteration }}').on('click', function() {
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
                        url: '{{ route('users.destroy', $user->id) }}',
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
@endpush
