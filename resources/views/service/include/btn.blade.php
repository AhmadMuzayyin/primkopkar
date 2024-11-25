<button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal-{{ $service->id }}">
    <i class="bx bx-edit"></i>
</button>
<x-t-modal id="editModal-{{ $service->id }}" title="Edit Layanan">
    <div class="modal-body">
        <form action="{{ route('service.update', $service->id) }}" method="POST">
            @csrf
            @method('PATCH')
            @include('service.include.form')
            <div class="modal-footer">
                <button class="btn btn-primary mt-3" type="submit">Simpan</button>
            </div>
        </form>
    </div>
</x-t-modal>
@if (Auth::user()->role == App\Role::Admin->value)
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
                            url: '{{ route('service.destroy', $service->id) }}',
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
@endif
