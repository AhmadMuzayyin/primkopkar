<x-app-layout>
    <x-slot name="page">Service</x-slot>
    <div class="row">
        <div class="col-sm col-md-12">
            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal">
                        <i class="bx bx-plus"></i> Tambah Service
                    </button>
                    <x-t-modal title="Tambah Service">
                        <form action="{{ route('service.store') }}" method="post">
                            <div class="modal-body">
                                @csrf
                                @include('service.include.form')
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
                                <th>Nama</th>
                                <th>Deskripsi</th>
                                <th>Harga Per M3</th>
                                <th>Harga Per Angkutan</th>
                                <th>Volume Maksimal</th>
                                <th>Persentase Komisi</th>
                                <th>
                                    <i class="bx bx-cog"></i>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($services as $service)
                                <tr>
                                    <td>{{ $service->nama }}</td>
                                    <td>{{ $service->deskripsi }}</td>
                                    <td>Rp. {{ number_format($service->harga_per_m3, 0, ',', '.') }}</td>
                                    <td>Rp. {{ number_format($service->harga_per_angkutan, 0, ',', '.') }}</td>
                                    <td>{{ $service->volume_max }}</td>
                                    <td>{{ $service->persentase_komisi }}%</td>
                                    <td>
                                        @include('service.include.btn')
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
