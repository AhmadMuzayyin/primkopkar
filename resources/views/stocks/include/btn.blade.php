<button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-{{ $loop->iteration }}">
    <i class="bx bx-plus"></i>
</button>
<x-t-modal id="modal-{{ $loop->iteration }}" title="Edit Stok Barang" lg="modal-sm">
    <div class="modal-body">
        <form action="{{ route('stocks.update', $stock->id) }}" method="post">
            @csrf
            @method('PUT')
            <input type="hidden" name="product_id" value="{{ $stock->product_id }}">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-3">
                            <x-t-input t="text" id="product" name="product" label="Produk"
                                value="{{ $stock->product->name }}" r="disabled" />
                        </div>
                        <div class="mb-3">
                            <x-t-input t="text" id="last_stock" name="last_stock" label="Stok saat ini"
                                value="{{ $stock->stock }}" r="disabled" />
                        </div>
                        <div class="mb-3">
                            <x-t-input t="number" id="stock" name="stock" label="Tambahan Stok"
                                value="{{ $stock->stock }}" min="1" />
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Perbarui</button>
            </div>
        </form>
    </div>
</x-t-modal>
{{-- @if (Auth::user()->role == App\Role::Admin->value || Auth::user()->role == App\Role::Kasir->value)
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
                            url: '{{ route('stocks.destroy', $stock->id) }}',
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
@endif --}}
