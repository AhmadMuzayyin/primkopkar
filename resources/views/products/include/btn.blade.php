<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-{{ $loop->iteration }}">
    <i class="bx bx-show"></i>
</button>
<x-t-modal id="modal-{{ $loop->iteration }}" title="Detail Barang" lg="modal-lg">
    <div class="modal-body">
        @csrf
        <div class="container">
            <table>
                <tr>
                    <td>Kategori</td>
                    <td>:</td>
                    <td>{{ $product->category->name }}</td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td>{{ $product->name }}</td>
                </tr>
                <tr>
                    <td>Deskripsi</td>
                    <td>:</td>
                    <td>{{ $product->description }}</td>
                </tr>
                <tr>
                    <td>Harga Beli</td>
                    <td>:</td>
                    <td>Rp.{{ number_format($product->purchase_price) }}</td>
                </tr>
                <tr>
                    <td>Margin</td>
                    <td>:</td>
                    <td>Rp. {{ number_format($product->margin) }}</td>
                </tr>
                <tr>
                    <td>Stok</td>
                    <td>:</td>
                    <td>{{ $product->stock }}</td>
                </tr>
                <tr>
                    <td>SHU</td>
                    <td>:</td>
                    <td>Rp.{{ number_format($product->shu) }}</td>
                </tr>
                <tr>
                    <td>Harga Tunai</td>
                    <td>:</td>
                    <td>Rp.{{ number_format($product->price) }}</td>
                </tr>
                <tr>
                    <td>Harga Kredit</td>
                    <td>:</td>
                    <td>Rp.{{ number_format($product->price_credit) }}</td>
                </tr>
            </table>
        </div>
    </div>
</x-t-modal>
<a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning btn-sm">
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
                            url: '{{ route('products.destroy', $product->id) }}',
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
