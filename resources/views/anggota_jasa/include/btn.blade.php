<button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
    data-bs-target="#modal-edit-customer-{{ $loop->iteration }}">
    <i class="bx bx-edit"></i>
</button>
<x-t-modal id="modal-edit-customer-{{ $loop->iteration }}" title="Edit Pelanggan">
    <div class="modal-body">
        <form action="{{ route('anggota_jasa.update', $cust->id) }}" method="post">
            @csrf
            @method('PATCH')
            <div class="mb-3">
                <label for="nama">Nama</label>
                <input type="text" name="nama" id="nama"
                    class="form-control @error('nama') is-invalid @enderror" value="{{ $cust?->nama ?? old('nama') }}">
                @error('nama')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="alamat">Alamat</label>
                <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror">{{ $cust?->alamat ?? old('alamat') }}</textarea>
                @error('alamat')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="telepon">Telepon</label>
                <input type="number" name="telepon" id="telepon"
                    class="form-control @error('telepon') is-invalid @enderror"
                    value="{{ $cust?->telepon ?? old('telepon') }}" min="62">
                @error('telepon')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</x-t-modal>

@if (Auth::user()->role == App\Role::Admin->value || Auth::user()->role == App\Role::Jasa->value)
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
                            url: '{{ route('anggota_jasa.destroy', $cust->id) }}',
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
