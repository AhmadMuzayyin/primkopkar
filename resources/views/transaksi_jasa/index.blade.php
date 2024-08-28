<x-app-layout>
    <x-slot name="page">Data Transaksi Jasa Angkutan</x-slot>
    <div class="row">
        <div class="col-sm col-md-12">
            <div class="card">
                <div class="card-header">
                    <h1>Transaksi Jasa Angkutan</h1>
                </div>
                <div class="card-body">
                    <table class="table dt-responsive nowrap w-100" id="basic-datatable">
                        <thead>
                        </thead>
                        <tbody>
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
