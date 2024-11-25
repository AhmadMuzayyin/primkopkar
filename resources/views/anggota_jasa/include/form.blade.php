<x-t-modal id="modal-tambah-customer" title="Tambah Pelanggan">
    <div class="modal-body">
        <form action="{{ route('anggota_jasa.store') }}" method="post">
            @csrf
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
