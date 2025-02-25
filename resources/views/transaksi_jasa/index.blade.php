<x-app-layout>
    <x-slot name="page">Data Transaksi Jasa Angkutan</x-slot>

    <div class="row">
        <div class="col-sm col-md-12">
            <div class="card">
                <div class="card-header">
                    <h1>Transaksi Jasa Angkutan</h1>
                </div>
                <div class="card-body">
                    <!-- Customer Selection Section -->
                    @if (!session('active_customer_id'))
                        <div class="row mb-4" id="customerSelectionSection">
                            <div class="col-md-8">
                                <x-t-select id="select_customer_id" name="customer_id"
                                    label="Pilih Pelanggan untuk Transaksi" required>
                                    <option value="">-- Pilih Pelanggan --</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->nama }}</option>
                                    @endforeach
                                </x-t-select>
                            </div>
                            <div class="col-md-4" style="margin-top: 32px;">
                                <button type="button" class="btn btn-primary" id="selectCustomerBtn">Pilih
                                    Pelanggan</button>
                            </div>
                        </div>
                    @else
                        <!-- Active Customer Info -->
                        <div class="row mb-4">
                            <div class="col-md-12">
                                <div class="alert alert-info">
                                    <strong>Pelanggan aktif:</strong> {{ $activeCustomer->nama }}
                                    <button type="button" class="btn btn-sm btn-warning float-end"
                                        id="changeCustomerBtn">Ganti Pelanggan</button>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Form Input (hanya tampil jika customer sudah dipilih) -->
                    @if (session('active_customer_id'))
                        <form id="formJasa" method="POST">
                            @csrf
                            <input type="hidden" id="wood_shipping_order_id" name="wood_shipping_order_id">
                            <!-- Customer ID dari session -->
                            <input type="hidden" name="customer_id" value="{{ session('active_customer_id') }}">

                            <div class="row">
                                <!-- Provider -->
                                <div class="col-md-6">
                                    <x-t-select id="provider_id" name="provider_id" label="Penyedia Jasa" required>
                                        <option value="">-- Pilih Penyedia --</option>
                                        @foreach ($providers as $provider)
                                            <option value="{{ $provider->id }}">{{ $provider->nama }}</option>
                                        @endforeach
                                    </x-t-select>
                                </div>

                                <!-- Tanggal Pesanan -->
                                <div class="col-md-6 mt-3">
                                    <x-t-input id="tgl_pesanan" name="tgl_pesanan" t="date" label="Tanggal Pesanan"
                                        required />
                                </div>

                                <!-- Tanggal Kirim -->
                                <div class="col-md-6 mt-3">
                                    <x-t-input id="tgl_kirim" name="tgl_kirim" t="date" label="Tanggal Kirim"
                                        required />
                                </div>

                                <!-- Jenis Kayu -->
                                <div class="col-md-6 mt-3">
                                    <x-t-input id="jenis_kayu" name="jenis_kayu" t="text" label="Jenis Kayu" required />
                                </div>

                                <!-- Volume M3 -->
                                <div class="col-md-6 mt-3">
                                    <x-t-input id="volume_m3" name="volume_m3" t="number" label="Volume M3" required />
                                </div>

                                <!-- Berat Kayu -->
                                <div class="col-md-6 mt-3">
                                    <x-t-input id="berat" name="berat" t="number" label="Berat Kayu" required />
                                </div>

                                <!-- Panjang Kayu -->
                                <div class="col-md-6 mt-3">
                                    <x-t-input id="panjang" name="panjang" t="number" label="Panjang Kayu" required />
                                </div>

                                <!-- Lokasi Pengambilan -->
                                <div class="col-md-6 mt-3">
                                    <x-t-textarea id="lokasi_pengambilan" name="lokasi_pengambilan"
                                        label="Lokasi Pengambilan" rows="2" required />
                                </div>

                                <!-- Lokasi Pengantaran -->
                                <div class="col-md-6 mt-3">
                                    <x-t-textarea id="lokasi_pengantaran" name="lokasi_pengantaran"
                                        label="Lokasi Pengantaran" rows="2" required />
                                </div>

                                <!-- Jenis Pengiriman -->
                                <div class="col-md-6 mt-3">
                                    <label class="form-label">Jenis Pengiriman</label>
                                    <div class="d-flex">
                                        <div class="form-check me-3">
                                            <input class="form-check-input" type="radio" name="jenis_pengiriman"
                                                value="Per M3" required id="per_m3">
                                            <label class="form-check-label" for="per_m3">Per Meter Kubik</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="jenis_pengiriman"
                                                value="Per Angkutan" required id="per_angkutan">
                                            <label class="form-check-label" for="per_angkutan">Per Angkutan</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tombol Submit -->
                                <div class="col-md-12 mt-4">
                                    <button type="submit" class="btn btn-primary" id="submitButton">Simpan</button>
                                    <button type="button" class="btn btn-warning" id="prosesButton">Proses
                                        Transaksi</button>
                                </div>
                            </div>
                        </form>

                        <hr>

                        <!-- Tabel Data Transaksi -->
                        <table class="table dt-responsive nowrap w-100" id="basic-datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Jenis Kayu</th>
                                    <th>Penyedia</th>
                                    <th>Tgl Pesanan</th>
                                    <th>Tgl Kirim</th>
                                    <th>Lokasi Pengambilan</th>
                                    <th>Lokasi Pengantaran</th>
                                    <th>Jenis Pengiriman</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $order->wood->jenis_kayu }}</td>
                                        <td>{{ $order->provider->nama }}</td>
                                        <td>{{ $order->tgl_pesanan }}</td>
                                        <td>{{ $order->tgl_kirim }}</td>
                                        <td>{{ $order->lokasi_pengambilan }}</td>
                                        <td>{{ $order->lokasi_pengantaran }}</td>
                                        <td>{{ $order->jenis_pengiriman }}</td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-warning"
                                                onclick="editData({{ $order->id }})">Edit</button>
                                            @if (Auth::user()->role == App\Role::Admin->value || Auth::user()->role == App\Role::Jasa->value)
                                                <button type="button" class="btn btn-danger btn-sm"
                                                    id="delete-{{ $loop->iteration }}">
                                                    <i class="bx bx-trash"></i>
                                                </button>
                                                @push('js')
                                                    <script>
                                                        $('#delete-{{ $loop->iteration }}').on('click', function() {
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
                                                                        url: '{{ route('jasa.destroy', $order->id) }}',
                                                                        type: 'DELETE',
                                                                        data: {
                                                                            '_token': '{{ csrf_token() }}'
                                                                        },
                                                                        success: function(res) {
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
                                                                    });
                                                                }
                                                            });
                                                        });
                                                    </script>
                                                @endpush
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <x-t-modal id="prosesTransaksiModal" title="Proses Transaksi" lg="modal-lg">
        <form id="prosesTransaksiForm" method="POST">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 mt-3">
                        <x-t-input t="number" id="biaya_operasional" name="biaya_operasional"
                            label="Biaya Operasional" required />
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 mt-3">
                        <x-t-select id="metode_bayar" name="metode_bayar" label="Metode Pembayaran" required>
                            <option value="" selected disabled>-- Pilih Metode Pembayaran --</option>
                            <option value="Cash">Cash</option>
                            <option value="Transfer">Transfer</option>
                        </x-t-select>
                    </div>
                </div>
            </div>

            <!-- Tombol Submit -->
            <div class="col-md-12 mt-4">
                <button type="submit" class="btn btn-primary" id="submitButton">Simpan</button>
                <button type="button" class="btn btn-warning" id="prosesButton">Proses Transaksi</button>
                <button type="button" class="btn btn-secondary" id="cancelEditButton" style="display: none;">Batal
                    Edit</button>
            </div>
        </form>
    </x-t-modal>

    @push('js')
        <script>
            $(document).ready(function() {
                $('#basic-datatable').DataTable();

                let isEditMode = false;

                // Handle customer selection
                $("#selectCustomerBtn").on("click", function() {
                    const customerId = $("#select_customer_id").val();
                    if (!customerId) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Silakan pilih pelanggan terlebih dahulu!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        return;
                    }

                    $.ajax({
                        url: "{{ route('jasa.set-customer') }}",
                        type: "POST",
                        data: {
                            'customer_id': customerId,
                            '_token': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: response.message,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                setTimeout(() => location.reload(), 1500);
                            }
                        },
                        error: function(err) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Terjadi kesalahan saat memilih pelanggan',
                                showConfirmButton: false,
                                timer: 2000
                            });
                        }
                    });
                });

                // Handle change customer
                $("#changeCustomerBtn").on("click", function() {
                    Swal.fire({
                        title: 'Ganti Pelanggan?',
                        text: 'Mengganti pelanggan akan menghapus semua item dalam transaksi saat ini!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, Ganti!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "{{ route('jasa.reset-customer') }}",
                                type: "POST",
                                data: {
                                    '_token': '{{ csrf_token() }}'
                                },
                                success: function(response) {
                                    if (response.success) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: response.message,
                                            showConfirmButton: false,
                                            timer: 1500
                                        });
                                        setTimeout(() => location.reload(), 1500);
                                    }
                                }
                            });
                        }
                    });
                });

                $("#formJasa").submit(function(e) {
                    e.preventDefault();

                    let id = $("#wood_shipping_order_id").val();
                    let formData = $(this).serialize();
                    let url = id ? `/jasa/${id}/update` : `/jasa/store`;
                    let method = id ? "PATCH" : "POST";

                    $.ajax({
                        url: url,
                        type: method,
                        data: formData,
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: response.message,
                                showConfirmButton: false,
                                timer: 1500
                            });
                            setTimeout(() => location.reload(), 1500);
                        }
                    });
                });

                $("#cancelEditButton").on("click", function() {
                    resetFormToAddMode();
                });
            });

            function formatNumber(number) {
                return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }

            function printReceipt(paymentData) {
                paymentData.forEach(data => {
                    const printWindow = window.open('', '', 'height=600,width=800');

                    const html = `
                <!DOCTYPE html>
                <html>
                <head>
                    <title>Struk Pembayaran</title>
                    <style>
                        .receipt-container {
                            width: 80mm;
                            padding: 10px;
                            font-family: Arial;
                        }
                        .receipt-header {
                            text-align: center;
                            margin-bottom: 15px;
                        }
                        .receipt-item {
                            margin: 5px 0;
                        }
                        .receipt-total {
                            font-weight: bold;
                            border-top: 1px dashed #000;
                            margin-top: 10px;
                            padding-top: 10px;
                        }
                        .order-details {
                            margin: 10px 0;
                            padding: 5px 0;
                            border-bottom: 1px dashed #000;
                        }
                    </style>
                </head>
                <body onload="window.print()">
                    <div class="receipt-container">
                        <div class="receipt-header">
                            <h2>STRUK PEMBAYARAN</h2>
                            <p>Sistem Jasa Angkutan</p>
                            <p>${data.tgl_bayar}</p>
                        </div>
                        
                        <div class="receipt-item">
                            <p>No. Transaksi: ${data.payment_reference}</p>
                            <p>Customer: ${data.customer.nama}</p>
                            <p>Alamat: ${data.customer.alamat}</p>
                            <p>Metode Bayar: ${data.metode_bayar}</p>
                        </div>

                        <div class="receipt-item">
                            <h3>Detail Pesanan:</h3>
                            ${data.orders.map(order => `
                                                                                                                                                                                        <div class="order-details">
                                                                                                                                                                                            <p>Jenis Kayu: ${order.jenis_kayu}</p>
                                                                                                                                                                                            <p>Volume: ${order.volume_m3} m³</p>
                                                                                                                                                                                            <p>Jenis Pengiriman: ${order.jenis_pengiriman}</p>
                                                                                                                                                                                            <p>Biaya: Rp ${Number(order.biaya).toLocaleString()}</p>
                                                                                                                                                                                        </div>
                                                                                                                                                                                    `).join('')}
                        </div>

                        <div class="receipt-total">
                            <p>Total Biaya: Rp ${Number(data.total_biaya).toLocaleString()}</p>
                            <p>Biaya Operasional: Rp ${Number(data.biaya_operasional).toLocaleString()}</p>
                            <h3>TOTAL: Rp ${Number(data.total_keseluruhan).toLocaleString()}</h3>
                        </div>

                        <div class="receipt-footer" style="text-align: center; margin-top: 20px;">
                            <p>Terima kasih telah menggunakan jasa kami</p>
                            <p>** Struk ini merupakan bukti pembayaran yang sah **</p>
                        </div>
                    </div>
                </body>
                </html>
            `;

                    printWindow.document.write(html);
                    printWindow.document.close();

                    printWindow.onafterprint = function() {
                        printWindow.close();
                    };
                });
            }

            function editData(id) {
                isEditMode = true;
                updateButtonsVisibility();
                $.ajax({
                    url: `/jasa/${id}/edit`,
                    type: "GET",
                    success: function(data) {
                        // Isi form dengan data yang diterima
                        $("#wood_shipping_order_id").val(data.id);
                        $("#provider_id").val(data.provider_id);
                        $("#tgl_pesanan").val(data.tgl_pesanan);
                        $("#tgl_kirim").val(data.tgl_kirim);
                        $("#jenis_kayu").val(data.wood.jenis_kayu);
                        $("#volume_m3").val(data.wood.volume_m3);
                        $("#berat").val(data.wood.berat);
                        $("#panjang").val(data.wood.panjang);
                        $("#lokasi_pengambilan").val(data.lokasi_pengambilan);
                        $("#lokasi_pengantaran").val(data.lokasi_pengantaran);
                        $(`input[name="jenis_pengiriman"][value="${data.jenis_pengiriman}"]`).prop("checked", true);

                        // Ubah tombol submit dan form action
                        $("#formJasa").attr("action", `/jasa/${id}/update`);
                        // Tambahkan method override untuk PATCH
                        $("#formJasa").find('input[name="_method"]').remove(); // Hapus dulu jika sudah ada
                        $("#formJasa").append('<input type="hidden" name="_method" value="PATCH">');
                        $("#submitButton").text("Update Transaksi");

                        // Toggle button visibility
                        $("#prosesButton").hide();
                        $("#cancelEditButton").show();
                    }
                });
            }

            function updateButtonsVisibility() {
                if (isEditMode) {
                    $("#prosesButton").hide();
                    $("<button>")
                        .attr("type", "button")
                        .attr("id", "cancelEditButton")
                        .addClass("btn btn-secondary mx-2")
                        .text("Batal Edit")
                        .insertAfter("#submitButton")
                        .on("click", resetFormToAddMode);
                } else {
                    $("#prosesButton").show();
                    $("#cancelEditButton").remove();
                }
            }

            // Function to reset form to "add mode"
            function resetFormToAddMode() {
                $("#wood_shipping_order_id").val("");
                $("#formJasa")[0].reset();
                $("#formJasa").attr("action", "{{ route('jasa.store') }}");
                $("#formJasa").find("input[name='_method']").remove();
                $("#submitButton").text("Simpan");

                // Toggle button visibility
                $("#prosesButton").show();
                $("#cancelEditButton").hide();
            }
            $("#prosesButton").on("click", function() {
                // Tampilkan modal
                $("#prosesTransaksiModal").modal("show");
            });
            // Saat form diproses
            $("#prosesTransaksiForm").submit(function(e) {
                e.preventDefault();

                let formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('jasa.proses') }}",
                    type: "POST",
                    data: formData,
                    success: function(response) {
                        Swal.fire({
                            icon: "success",
                            title: "Transaksi berhasil diproses!",
                            showConfirmButton: false,
                            timer: 1500
                        });

                        if (response.success && response.data) {
                            printReceipt(response.data);
                        }

                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    },
                    error: function(err) {
                        Swal.fire({
                            icon: "error",
                            title: "Terjadi kesalahan!",
                            text: err.responseJSON.message,
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
