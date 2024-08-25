<x-app-layout>
    <x-slot name="page">Transaksi Pinjaman</x-slot>
    <div class="row">
        <div class="col-sm col-md-12">
            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal">
                        <i class="bx bx-plus"></i> Tambah Pinjaman
                    </button>
                    <x-t-modal title="Tambah Kategori">
                        <form action="{{ route('loans.store') }}" method="post">
                            <div class="modal-body">
                                @csrf
                                @include('loans.include.form')
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary mt-3" type="submit">Simpan</button>
                            </div>
                        </form>
                    </x-t-modal>

                    <ul class="mt-2">
                        <li class="fw-bold text-success">Hijau: Lunas</li>
                        <li class="fw-bold text-danger">Merah: Belum Lunas</li>
                    </ul>
                </div>
                <div class="card-body">
                    <table class="table dt-responsive nowrap w-100" id="basic-datatable">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Nominal</th>
                                <th>Pengembalian + Bunga</th>
                                <th>Tanggal Pinjaman</th>
                                <th>Tanggal Pelunasan</th>
                                <th>Angsuran</th>
                                <th>
                                    <i class="bx bx-cog"></i>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($loans as $loan)
                                <tr class="{{ $loan->status == 'Belum Lunas' ? 'bg-danger' : 'bg-success' }}">
                                    <td class="text-white">{{ $loan->member->name }}</td>
                                    <td class="text-white">Rp.{{ number_format($loan->loan_nominal) }}</td>
                                    <td class="text-white">Rp.{{ number_format($loan->nominal_return) }}</td>
                                    <td class="text-white">{{ date('d F Y', strtotime($loan->loan_date)) }}</td>
                                    <td class="text-white">{{ date('d F Y', strtotime($loan->loan_period)) }}</td>
                                    <td class="text-white">
                                        <button class="btn btn-xs bg-primary" data-bs-toggle="modal"
                                            data-bs-target="#modal-{{ $loan->id }}">
                                            <i class="bx bx-show text-white"></i>
                                        </button>
                                        @include('loans.include.modalAngsuran')
                                    </td>
                                    <td>
                                        @include('loans.include.btn')
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
