<x-t-select id="product_id" name="product_id" label="Nama Barang">
    <option value="" selected disabled>Barang</option>
    @foreach ($products as $product)
        <option value="{{ $product->id }}"
            {{ isset($restocking) && $restocking->product_id == $product->id ? 'selected' : '' }}>
            {{ $product->name }}
        </option>
    @endforeach
</x-t-select>
<x-t-input t="number" id="purchase_price" name="purchase_price" label="Harga Beli"
    value="{{ $restocking->purchase_price ?? '' }}" />
<x-t-input t="number" id="stock" name="stock" label="Stok" value="{{ $restocking->stock ?? '' }}" />
@push('js')
    <script>
        $(document).ready(function() {
            $('#product_id').on('change', function() {
                var id = $(this).val();
                $.ajax({
                    url: `/restocking/${id}/get-product`,
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id
                    },
                    success: function(response) {
                        $('#purchase_price').val(response.purchase_price);
                        $('#stock').val(response.stock);
                    }
                });
            });
        });
    </script>
@endpush
