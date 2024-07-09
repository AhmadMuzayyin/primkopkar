<x-app-layout>
    <x-slot name="page">Data Barang</x-slot>
    <div class="row">
        <div class="col-sm col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-3">
                            <x-t-input id="search" name="barcode" t="search" label='' placeholder="Barcode" />
                        </div>
                        <div class="col">
                        </div>
                        <div class="col text-end">
                            @php
                                $total = 0;
                                foreach ($transactions as $transaction) {
                                    $total += $transaction->amount;
                                }
                            @endphp
                            <h1 class="fw-bold mt-4">Rp. <span id="total">{{ number_format($total) }}</span></h1>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <button class="btn btn-danger my-3" type="button" id="deleteTransaction"
                        data-transactionid="{{ isset($transactions) && $transactions->count() > 0 ? $transactions[0]->id : '' }}"
                        {{ isset($transactions) && $transactions->count() > 0 ? '' : 'disabled' }}>
                        <i class="bx bx-trash"></i>
                        Transaksi
                    </button>
                    <table class="table dt-responsive nowrap w-100" id="basic-datatable">
                        <thead>
                            <tr>
                                <th>Barcode</th>
                                <th>Item</th>
                                <th>Qty</th>
                                <th>Harga Satuan</th>
                                <th>Total</th>
                                <th>
                                    <i class="bx bx-cog"></i>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transactions as $transaction)
                                @foreach ($transaction->items as $product)
                                    <tr>
                                        <th>{{ $product->product->barcode }}</th>
                                        <th>{{ $product->product->name }}</th>
                                        <th>{{ $product->quantity }}</th>
                                        <th>{{ number_format($product->price) }}</th>
                                        <th>{{ number_format($product->price * $product->quantity) }}</th>
                                        <th>
                                            <button type="button" class="btn btn-danger"
                                                onclick="deleteItem({{ $product->product_id }},{{ $transaction->id }})">
                                                <i class="bx bx-trash"></i>
                                            </button>
                                        </th>
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-3">
                            <table>
                                <tr>
                                    <td>Tanggal Transaksi:</td>
                                    <td>
                                        <input class="form-control mx-2"
                                            value="{{ isset($transactions) && $transactions->count() > 0 ? $transactions[0]->transaction_date : '' }}"
                                            readonly>
                                    </td>
                                </tr>
                                <tr class="mt-2">
                                    <td>Kode Nota:</td>
                                    <td>
                                        <input class="form-control mx-2"
                                            value="{{ isset($transactions) && $transactions->count() > 0 ? $transactions[0]->code : '' }}"
                                            readonly>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col">
                            <button class="btn btn-primary"
                                {{ isset($transactions) && $transactions->count() > 0 ? '' : 'disabled' }}
                                data-bs-toggle="modal" data-bs-target="#bayar">
                                <i class='bx bx-check-double'></i>Bayar
                            </button>
                            <x-t-modal id="bayar" title="Bayar" lg="modal-dialog-centered">
                                <div class="modal-body">
                                    <h1 id="change">Kembalian : Rp.<span id="kembalian"></span></h1>
                                    <form action="" method="post" id="formbayar"
                                        data-transactionid="{{ isset($transactions) && $transactions->count() > 0 ? $transactions[0]->id : '' }}">
                                        @csrf
                                        <x-t-select id="member_id" name="member_id" label="Member">
                                            <option value="" selected disabled>Member</option>
                                            @foreach ($members as $member)
                                                <option value="{{ $member->id }}">{{ $member->name }}</option>
                                            @endforeach
                                        </x-t-select>
                                        <x-t-input id="price" name="price" value="" label="Pembayaran"
                                            t="text" min="1000" placeholder="Pembayaran" />
                                    </form>
                                </div>
                            </x-t-modal>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-t-modal id="saveProduct" title="Tambah barang" lg="modal-dialog-centered">
        <div class="modal-body">
            <form action="" method="post" id="formSaveProduct">
                @csrf
                <x-t-input id="qty" name="qty" value="" label="QTY" t="number" min="1"
                    placeholder="Qty" />
            </form>
        </div>
    </x-t-modal>
    @push('js')
        <script>
            $(document).ready(function() {
                var search = $('#search');
                setTimeout(() => {
                    search.focus();
                }, 500);
                search.on('change', () => {
                    setTimeout(() => {
                        var value = search.val();
                        $.ajax({
                            url: "/product_transactions/find/" + value,
                            type: 'GET',
                            success: function(response) {
                                console.log(response);
                                var form = $('#formSaveProduct');
                                form.attr('action', '/product_transactions/store/' +
                                    response.data.barcode);
                                var modal = new bootstrap.Modal(document.getElementById(
                                    'saveProduct'));
                                modal.show();
                                modal._element.addEventListener('shown.bs.modal',
                                    function() {
                                        $('#qty').focus();
                                    });
                            }
                        })
                    }, 500);
                })
                // delete transaction
                var deleteTransaction = $('#deleteTransaction')
                var transactionid = deleteTransaction.data('transactionid')
                deleteTransaction.on('click', function() {
                    // request ajaq to route product_transaction.destroy
                    Swal.fire({
                        title: 'Apakah Anda Yakin?',
                        text: 'Data yang dihapus tidak dapat dikembalikan!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "/product_transactions/destroy/" + transactionid,
                                type: 'DELETE',
                                data: {
                                    _token: "{{ csrf_token() }}"
                                },
                                success: (res) => {
                                    Swal.fire({
                                        icon: 'success',
                                        title: res.message,
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                    setTimeout(() => {
                                        window.location.reload();
                                    }, 1500);
                                },
                                error: function(err) {
                                    Swal.fire({
                                        icon: 'error',
                                        title: err.message,
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                }
                            })
                        }
                    });
                })
            })
            // delete product
            function deleteItem(productid, transactionid) {
                Swal.fire({
                    title: 'Apakah Anda Yakin?',
                    text: 'Data yang dihapus tidak dapat dikembalikan!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "/product_transactions/delete/" + transactionid + "/" +
                                productid,
                            type: 'DELETE',
                            data: {
                                _token: "{{ csrf_token() }}"
                            },
                            success: (res) => {
                                Swal.fire({
                                    icon: 'success',
                                    title: res.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1500);
                            },
                            error: function(err) {
                                Swal.fire({
                                    icon: 'error',
                                    title: err.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                            }
                        })
                    }
                });
            }
            // bayar
            $(document).ready(function() {
                let total = $('#total').text();
                var modal = $('#bayar');
                modal.on('show.bs.modal', function(e) {
                    var input = $('#price');
                    let typingTimer; // Timer identifier
                    const doneTypingInterval = 1000;
                    input.on('keyup', function() {
                        clearTimeout(typingTimer);
                        var input = $(this);
                        var value = input.val();
                        value = value.replace(/\D/g, '');
                        let formattedVal = formatCurrency(value);
                        input.val(formattedVal);
                        typingTimer = setTimeout(function() {
                            let price = input.val().replace(/\D/g, '');
                            let change = price - parseInt(total.replace(/\D/g, ''));
                            if (change >= 0) {
                                $('#change').text('Kembalian: Rp. ' + formatCurrency(change
                                    .toString()));
                            } else {
                                $('#change').text('Uang tidak cukup');
                            }
                        }, doneTypingInterval);
                    })
                    var form = $('#formbayar');
                    var transactionid = form.data('transactionid');
                    form.attr('action', '/product_transactions/bayar/' + transactionid);
                })
            })

            function formatCurrency(number) {
                if (number === '') return '';
                return number.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }
        </script>
    @endpush
</x-app-layout>
