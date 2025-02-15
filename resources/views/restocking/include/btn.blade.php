<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-{{ $loop->iteration }}">
    <i class="bx bx-show"></i>
</button>
<x-t-modal id="modal-{{ $loop->iteration }}" title="Detail Barang" lg="modal-lg">
    <div class="modal-body">
        @csrf
        <div class="container">
            <table>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td>{{ $restock->product->name }}</td>
                </tr>
                <tr>
                    <td>Harga Beli</td>
                    <td>:</td>
                    <td>Rp.{{ number_format($restock->purchase_price) }}</td>
                </tr>
                <tr>
                    <td>Stok Input</td>
                    <td>:</td>
                    <td>{{ $restock->stock }}</td>
                </tr>
                <tr>
                    <td>Stok Sekarang</td>
                    <td>:</td>
                    <td>{{ $restock->product->stock }}</td>
                </tr>
            </table>
        </div>
    </div>
</x-t-modal>
<a href="{{ route('restocking.edit', $restock->id) }}" class="btn btn-warning btn-sm">
    <i class="bx bx-edit"></i>
</a>
@if (Auth::user()->role == App\Role::Admin->value || Auth::user()->role == App\Role::Kasir->value)
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
                            url: '{{ route('products.destroy', $restock->id) }}',
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
