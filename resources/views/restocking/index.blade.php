<x-app-layout>
    <x-slot name="page">Data Kulakan</x-slot>
    <div class="row">
        <div class="col-sm col-md-12">
            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal">
                        <i class="bx bx-plus"></i> Tambah Kulakan
                    </button>
                    <x-t-modal title="Tambah Kulakan" lg="modal-lg">
                        <form action="{{ route('restocking.store') }}" id="createForm" method="post">
                            <div class="modal-body">
                                @csrf
                                <div class="container">
                                    @include('restocking.include.form')
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary mt-3" type="submit" id="save">Simpan</button>
                            </div>
                        </form>
                    </x-t-modal>
                </div>
                <div class="card-body">
                    <table class="table dt-responsive nowrap w-100" id="basic-datatable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Produk</th>
                                <th>Harga Beli</th>
                                <th>Stok Input</th>
                                <th>Stok Sekarang</th>
                                <th>
                                    <i class="bx bx-cog"></i>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($restockings as $restock)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $restock->product->name }}</td>
                                    <td>Rp.{{ number_format($restock->purchase_price) }}</td>
                                    <td>{{ $restock->stock }}</td>
                                    <td>{{ $restock->product->stock }}</td>
                                    <td>
                                        @include('restocking.include.btn')
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
