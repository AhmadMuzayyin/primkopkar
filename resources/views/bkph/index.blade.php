<x-app-layout>
    <x-slot name="page">Data BKPH</x-slot>
    <div class="row">
        <div class="col-sm col-md-12">
            <div class="card">
                <div class="card-header">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-tambah-bkph">
                        <i class="bx bx-plus"></i> Tambah
                    </button>
                </div>
                <div class="card-body">
                    <table class="table dt-responsive nowrap w-100" id="basic-datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Wilayah</th>
                                <th>Alamat</th>
                                <th>Kontak</th>
                                <th>Jenis Hutan</th>
                                <th>
                                    <i class="bx bx-cog"></i>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($bkphs as $bkph)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $bkph->nama }}</td>
                                    <td>{{ $bkph->wilayah }}</td>
                                    <td>{{ $bkph->alamat }}</td>
                                    <td>{{ $bkph->kontak }}</td>
                                    <td>{{ $bkph->jenis_hutan }}</td>
                                    <td>
                                        @include('bkph.include.btn')
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <x-t-modal id="modal-tambah-bkph" title="Tambah BKPH">
        <div class="modal-body">
            <form action="{{ route('bkph.store') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" id="nama"
                        class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}">
                    @error('nama')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="wilayah">Wilayah</label>
                    <input type="text" name="wilayah" id="wilayah"
                        class="form-control @error('wilayah') is-invalid @enderror" value="{{ old('wilayah') }}">
                    @error('wilayah')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="alamat">Alamat</label>
                    <textarea name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="kontak">Kontak</label>
                    <input type="number" name="kontak" id="kontak"
                        class="form-control @error('kontak') is-invalid @enderror" value="{{ old('kontak') ?? '62' }}"
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
                        class="form-control @error('jenis_hutan') is-invalid @enderror"
                        value="{{ old('jenis_hutan') }}">
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
    @push('js')
        <script></script>
    @endpush
</x-app-layout>
