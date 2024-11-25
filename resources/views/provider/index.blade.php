<x-app-layout>
    <x-slot name="page">Provider</x-slot>
    <div class="row">
        <div class="col-sm col-md-12">
            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal">
                        <i class="bx bx-plus"></i> Tambah Provider
                    </button>
                    <x-t-modal title="Tambah Provider">
                        <form action="{{ route('provider.store') }}" method="post">
                            <div class="modal-body">
                                @csrf
                                @include('provider.include.form')
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary mt-3" type="submit">Simpan</button>
                            </div>
                        </form>
                    </x-t-modal>
                </div>
                <div class="card-body">
                    <table class="table dt-responsive nowrap w-100" id="basic-datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Service</th>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>No Telp</th>
                                <th>
                                    <i class="bx bx-cog"></i>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($providers as $provider)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $provider->service->nama }}</td>
                                    <td>{{ $provider->nama }}</td>
                                    <td>{{ $provider->alamat }}</td>
                                    <td>{{ $provider->no_telp }}</td>
                                    <td>
                                        @include('provider.include.btn')
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
