<x-app-layout>
    <x-slot name="page">Stok Barang</x-slot>
    <div class="row">
        <div class="col-sm col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table dt-responsive nowrap w-100" id="basic-datatable">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Harga Beli</th>
                                <th>Harga Jual</th>
                                <th>Harga Kredit</th>
                                <th>Stok</th>
                                <th>Margin</th>
                                <th>SHU</th>
                                <th>
                                    <i class="bx bx-cog"></i>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stocks as $stock)
                                <tr>
                                    <td>{{ $stock->product->name }}</td>
                                    <td>Rp.{{ number_format($stock->product->purchase_price) }}</td>
                                    <td>Rp.{{ number_format($stock->product->price) }}</td>
                                    <td>Rp.{{ number_format($stock->product->price_credit) }}</td>
                                    <td>{{ $stock->stock }}</td>
                                    <td>{{ $stock->product->margin }}</td>
                                    <td>Rp.{{ number_format($stock->product->shu) }}</td>
                                    <td>
                                        @include('stocks.include.btn')
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
