<a href="{{ route('loan_categories.edit', $category->id) }}" class="btn btn-warning btn-sm">
    <i class="bx bx-edit"></i>
</a>
@if ($category->role != App\Role::Admin->value)
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
                            url: '{{ route('loan_categories.destroy', $category->id) }}',
                            type: 'DELETE',
                            data: {
                                '_token': '{{ csrf_token() }}'
                            },
                            success: function(res) {
                                Swal.fire({
                                    icon: res.status,
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
                                    icon: err.status,
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
