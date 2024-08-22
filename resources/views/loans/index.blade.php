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
                </div>
                <div class="card-body">
                    <table class="table dt-responsive nowrap w-100" id="basic-datatable">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Nominal</th>
                                <th>Bunga</th>
                                <th>Pengembalian</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th>
                                    <i class="bx bx-cog"></i>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($loans as $loan)
                                <tr>
                                    <td>{{ $loan->member->name }}</td>
                                    <td>Rp.{{ number_format($loan->loan_nominal) }}</td>
                                    <td>Rp.{{ number_format($loan->interest_rate) }}</td>
                                    <td>Rp.{{ number_format($loan->nominal_return) }}</td>
                                    <td>{{ date('d F Y', strtotime($loan->loan_date)) }}</td>
                                    <td>
                                        @if ($loan->status == 'Belum Lunas')
                                            <span class="badge bg-danger">{{ $loan->status }}</span>
                                        @else
                                            <span class="badge bg-success">{{ $loan->status }}</span>
                                        @endif
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
