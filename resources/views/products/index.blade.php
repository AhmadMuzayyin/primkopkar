<x-app-layout>
    <x-slot name="page">Data Barang</x-slot>
    <div class="row">
        <div class="col-sm col-md-12">
            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal">
                        <i class="bx bx-plus"></i> Tambah Barang
                    </button>
                    <x-t-modal title="Tambah Barang">
                        <form action="{{ route('products.store') }}" method="post">
                            <div class="modal-body">
                                @csrf
                                <div class="container">
                                    @include('products.include.form')
                                </div>
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
                                <th>Kategori</th>
                                <th>Nama</th>
                                <th>Deskripsi</th>
                                <th>Stok</th>
                                <th>
                                    <i class="bx bx-cog"></i>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->category->name }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>{{ $product->stock }}</td>
                                    <td>
                                        @include('products.include.btn')
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
