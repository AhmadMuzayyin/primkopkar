<x-app-layout>
    <x-slot name="page">Data Barang</x-slot>
    <div class="row">
        <div class="col-sm col-md-12">
            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal">
                        <i class="bx bx-plus"></i> Tambah Barang
                    </button>
                    <button id="printBarcode" type="button" class="btn btn-warning">
                        <i class='bx bx-printer'></i> Print Barcode
                    </button>
                    <x-t-modal title="Tambah Barang" lg="modal-lg">
                        <form action="{{ route('products.store') }}" id="createForm" method="post">
                            <div class="modal-body">
                                @csrf
                                <div class="container">
                                    @include('products.include.form')
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary mt-3" type="button" id="save">Simpan</button>
                            </div>
                        </form>
                    </x-t-modal>
                </div>
                <div class="card-body">
                    <table class="table dt-responsive nowrap w-100" id="basic-datatable">
                        <thead>
                            <tr>
                                <th>
                                    <input type="checkbox" name="" id="" class="checkbox">
                                </th>
                                <th>Barcode</th>
                                <th>Nama</th>
                                <th>Harga Beli</th>
                                <th>Harga Jual</th>
                                <th>Harga Kredit</th>
                                <th>Stok</th>
                                <th>
                                    <i class="bx bx-cog"></i>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="" data-barcode="{{ $product->barcode }}"
                                            id="" class="checkbox">
                                    </td>
                                    <td>{{ $product->barcode }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>Rp.{{ number_format($product->purchase_price) }}</td>
                                    <td>Rp.{{ number_format($product->price) }}</td>
                                    <td>Rp.{{ number_format($product->price_credit) }}</td>
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
    @push('js')
        <script>
            $(document).ready(function() {
                $('thead input[type="checkbox"]').on('change', function() {
                    var checked = $(this).is(':checked');
                    $('tbody input[type="checkbox"]').prop('checked', checked);
                });

                // Handle the individual checkbox selection
                $('#printBarcode').on('click', function() {
                    var selectedBarcodes = [];
                    $('tbody input[type="checkbox"]:checked').each(function() {
                        selectedBarcodes.push($(this).data('barcode'));
                    });

                    if (selectedBarcodes.length > 0) {
                        // Call a function to handle printing barcodes
                        // printBarcodes(selectedBarcodes);
                        var url = "{{ route('product.print') }}" + "?barcodes=" + selectedBarcodes.join(',');
                        $.ajax({
                            url: url,
                            type: 'GET',
                            success: function(response) {
                                var win = window.open('', '_blank');
                                win.document.write(response);
                                win.document.close();
                                win.print();
                            }
                        });
                    } else {
                        swal.fire('Peringatan', 'Pilih barang terlebih dahulu', 'warning');
                    }
                })
            })
        </script>
    @endpush
</x-app-layout>
