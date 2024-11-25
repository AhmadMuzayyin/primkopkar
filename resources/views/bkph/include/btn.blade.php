<button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal"
    data-bs-target="#modal-edit-bkph-{{ $loop->iteration }}">
    <i class="bx bx-edit"></i>
</button>

<x-t-modal id="modal-edit-bkph-{{ $loop->iteration }}" title="Edit BKPH">
    <div class="modal-body">
        <form action="{{ route('bkph.update', $bkph->id) }}" method="post">
            @csrf
            @method('PATCH')
            <div class="mb-3">
                <label for="nama">Nama</label>
                <input type="text" name="nama" id="nama"
                    class="form-control @error('nama') is-invalid @enderror" value="{{ $bkph->nama }}">
                @error('nama')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="wilayah">Wilayah</label>
                <input type="text" name="wilayah" id="wilayah"
                    class="form-control @error('wilayah') is-invalid @enderror" value="{{ $bkph->wilayah }}">
                @error('wilayah')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="alamat">Alamat</label>
                <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror">{{ $bkph->alamat }}</textarea>
                @error('alamat')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="kontak">Kontak</label>
                <input type="number" name="kontak" id="kontak"
                    class="form-control @error('kontak') is-invalid @enderror" value="{{ $bkph->kontak }}"
                    min="62">
                @error('kontak')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="jenis_hutan">Jenis Hutan</label>
                <input name="jenis_hutan" id="jenis_hutan"
                    class="form-control @error('jenis_hutan') is-invalid @enderror" value="{{ $bkph->jenis_hutan }}">
                @error('jenis_hutan')
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
@if (auth()->user()->role == App\Role::Admin->value || auth()->user()->role == App\Role::Jasa->value)
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
                            url: '{{ route('bkph.destroy', $bkph->id) }}',
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
