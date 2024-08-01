<x-t-input t="text" id="barcode" name="barcode" label="Barcode" value="{{ $product->barcode ?? '' }}">
    <small class="text-danger">Biarkan kosong jika produk tidak mempunyai kode bar</small>
</x-t-input>
<x-t-input t="text" id="name" name="name" label="Nama Barang" value="{{ $product->name ?? '' }}" />
<x-t-select id="category_id" name="category_id" label="Kategori Barang">
    <option value="" selected disabled>Kategori Barang</option>
    @foreach ($categories as $category)
        <option value="{{ $category->id }}"
            {{ isset($product) && $product->category_id == $category->id ? 'selected' : '' }}>
            {{ $category->name }}
        </option>
    @endforeach
</x-t-select>
<x-t-textarea id="description" name="description" label="Deskripsi" value="{{ $product->description ?? '' }}" />
<x-t-input t="text" id="purchase_price" name="purchase_price" label="Harga Beli"
    value="{{ $product->purchase_price ?? '' }}" />
<x-t-input t="text" id="margin" name="margin" label="Margin" value="{{ $product->margin ?? '' }}" />
<x-t-input t="text" id="stock" name="stock" label="Stok" value="{{ $product->stock ?? '' }}" />
<x-t-input t="text" id="shu" name="shu" label="SHU" value="{{ $product->shu ?? '' }}" />
<x-t-input t="text" id="price" name="price" label="Harga Tunai" value="{{ $product->price ?? '' }}" />
<x-t-input t="text" id="price_credit" name="price_credit" label="Harga Kredit"
    value="{{ $product->price_credit ?? '' }}" />
@push('js')
    <script>
        $('.modal').on('show.bs.modal', function() {
            setTimeout(() => {
                $('#barcode').focus();
            }, 500);
        });
        $(document).ready(function() {
            var input_id = ['purchase_price', 'margin', 'stock', 'shu', 'price', 'price_credit']
            input_id.forEach(element => {
                $(`#${element}`).on('keyup', function() {
                    let inputVal = $(this).val();
                    inputVal = inputVal.replace(/\D/g, '');
                    let formattedVal = formatCurrency(inputVal);
                    $(this).val(formattedVal);
                });
            });
            $('#margin').on('keyup', function() {
                let margin = $(this).val().replace(/\D/g, '');
                let purchase_price = $('#purchase_price').val().replace(/\D/g, '');
                let shu = $('#shu').val().replace(/\D/g, '');
                let price = parseInt(purchase_price) + parseInt(margin);
                let price_credit = parseInt(price) + parseInt(shu);
                $('#price').val(price);
            });
            $('#price_credit').on('keyup', function() {
                setTimeout(() => {
                    let price = $('#price').val().replace(/\D/g, '');
                    let price_credit = $(this).val().replace(/\D/g, '');

                    // Hapus pesan error sebelumnya
                    $(this).next('.invalid-tooltip').remove();
                    $(this).removeClass('is-invalid');
                    if (parseInt(price_credit) <= parseInt(price)) {
                        $(this).addClass('is-invalid');
                        var html =
                            `<div class="invalid-tooltip">Harga kredit tidak boleh lebih kecil dari harga cash</div>`;
                        $(this).after(html);
                    }
                }, 1000);
            });

            function formatCurrency(number) {
                if (number === '') return '';
                return number.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }
            @if (request()->routeIs('products.index'))
                function generate() {
                    return Math.floor(1000000000000 + Math.random() * 9000000000000);
                }
                $('#save').on('click', function() {
                    var barcode = $('#barcode').val();
                    barcode = barcode == '' ? generate() : barcode;
                    var name = $('#name').val();
                    var category_id = $('#category_id').val();
                    var description = $('#description').val();
                    var purchase_price = $('#purchase_price').val().replace(/\D/g, '');
                    var margin = $('#margin').val().replace(/\D/g, '');
                    var stock = $('#stock').val().replace(/\D/g, '');
                    var shu = $('#shu').val().replace(/\D/g, '');
                    var price = $('#price').val().replace(/\D/g, '');
                    var price_credit = $('#price_credit').val().replace(/\D/g, '');
                    var url = $('#createForm').attr('action');
                    var method = $('#createForm').attr('method');
                    $.ajax({
                        url: url,
                        method: method,
                        data: {
                            barcode: barcode,
                            name: name,
                            category_id: category_id,
                            description: description,
                            purchase_price: purchase_price,
                            margin: margin,
                            stock: stock,
                            shu: shu,
                            price: price,
                            price_credit: price_credit,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status == 'success') {
                                $('#modal').modal('hide');
                                $('#createForm').trigger('reset');
                                swal.fire({
                                    title: 'Berhasil',
                                    text: response.message,
                                    icon: 'success',
                                    showConfirmButton: false,
                                });
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1500);
                            } else {
                                swal.fire({
                                    title: 'Gagal',
                                    text: response.message,
                                    icon: 'error',
                                    showConfirmButton: false,
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            var err = JSON.parse(xhr.responseText);
                            //get error message and push to variable
                            var errMsg = '';
                            $.each(err.errors, function(key, value) {
                                errMsg += `<p class="text-danger">${value}</p>`;
                            });
                            swal.fire({
                                title: 'Gagal',
                                html: errMsg,
                                icon: 'error',
                                showConfirmButton: false,
                            });
                        }
                    })
                })
            @elseif (request()->routeIs('products.edit'))

                function generateBarcode() {
                    return Math.floor(1000000000000 + Math.random() * 9000000000000);
                }
                $('#update').on('click', function() {
                    var barcode = $('#barcode').val();
                    barcode = barcode == '' ? generateBarcode() : barcode;
                    var name = $('#name').val();
                    var category_id = $('#category_id').val();
                    var description = $('#description').val();
                    var purchase_price = $('#purchase_price').val().replace(/\D/g, '');
                    var margin = $('#margin').val().replace(/\D/g, '');
                    var stock = $('#stock').val().replace(/\D/g, '');
                    var shu = $('#shu').val().replace(/\D/g, '');
                    var price = $('#price').val().replace(/\D/g, '');
                    var price_credit = $('#price_credit').val().replace(/\D/g, '');
                    $.ajax({
                        url: "{{ route('products.update', $product->id) }}",
                        method: 'PUT',
                        data: {
                            barcode: barcode,
                            name: name,
                            category_id: category_id,
                            description: description,
                            purchase_price: purchase_price,
                            margin: margin,
                            stock: stock,
                            shu: shu,
                            price: price,
                            price_credit: price_credit,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status == 'success') {
                                $('#modal').modal('hide');
                                $('#createForm').trigger('reset');
                                swal.fire({
                                    title: 'Berhasil',
                                    text: response.message,
                                    icon: 'success',
                                    showConfirmButton: false,
                                });
                                setTimeout(() => {
                                    window.location.href =
                                        "{{ route('products.index') }}";
                                }, 1500);
                            } else {
                                swal.fire({
                                    title: 'Gagal',
                                    text: response.message,
                                    icon: 'error',
                                    showConfirmButton: false,
                                });
                            }
                        },
                        error: function(xhr, status, error) {
                            swal.fire({
                                title: 'Gagal',
                                text: 'Terjadi kesalahan saat menyimpan data',
                                icon: 'error',
                                showConfirmButton: false,
                            });
                        }
                    })
                })
            @endif
        })
    </script>
@endpush
