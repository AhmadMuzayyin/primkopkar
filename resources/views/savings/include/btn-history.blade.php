<button type="button" class="btn btn-danger btn-sm" id="btn-history-{{ $model->id }}">
    <i class="bx bx-trash"></i>
</button>
<script>
    $('#btn-history-{{ $model->id }}').on('click', function() {
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
                    url: '{{ route('savings.history.destroy', $model->id) }}',
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
