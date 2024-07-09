<x-app-layout>
    <x-slot name="page">Pengguna</x-slot>
    <div class="row">
        <div class="col-sm col-md-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('category.index') }}" class="btn btn-primary">
                        <i class="bx bx-left-arrow-circle"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('category.update', $category->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        @include('categories.include.form')
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary">Perbarui</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
