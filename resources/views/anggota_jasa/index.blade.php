<x-app-layout>
    <x-slot name="page">Data Pelanggan Jasa</x-slot>
    <div class="row">
        <div class="col-sm col-md-12">
            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#modal-tambah-customer">
                        <i class="bx bx-plus"></i> Tambah Pelanggan
                    </button>
                    @include('anggota_jasa.include.form')
                </div>
                <div class="card-body">
                    <table class="table dt-responsive nowrap w-100" id="basic-datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Kontak</th>
                                <th><i class="bx bx-cog"></i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $cust)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $cust->nama }}</td>
                                    <td>{{ $cust->alamat }}</td>
                                    <td>{{ $cust->telepon }}</td>
                                    <td>
                                        @include('anggota_jasa.include.btn')
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @push('js')
        <script></script>
    @endpush
</x-app-layout>
