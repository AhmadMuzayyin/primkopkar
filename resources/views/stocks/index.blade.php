<x-app-layout>
    <x-slot name="page">Kategori Produk</x-slot>
    <div class="row">
        <div class="col-sm col-md-12">
            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal">
                        <i class="bx bx-plus"></i> Tambah Kategori
                    </button>
                    <x-t-modal title="Tambah Kategori">
                        <form action="{{ route('category.store') }}" method="post">
                            <div class="modal-body">
                                @csrf
                                @include('categories.include.form')
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
                                <th>Slug</th>
                                <th>Nama</th>
                                <th>
                                    <i class="bx bx-cog"></i>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->slug }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>
                                        @include('categories.include.btn')
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
