<x-app-layout>
    <x-slot name="page">Kategori Pinjaman</x-slot>
    <div class="row">
        <div class="col-sm col-md-12">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('loan_categories.index') }}" class="btn btn-primary">
                        <i class="bx bx-left-arrow-circle"></i> Kembali
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('loan_categories.update', $loan_category->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        @include('loan_categories.include.form')
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary">Perbarui</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
