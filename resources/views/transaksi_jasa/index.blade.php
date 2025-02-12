<x-app-layout>
    <x-slot name="page">Data Transaksi Jasa Angkutan</x-slot>

    <div class="row">
        <div class="col-sm col-md-12">
            <div class="card">
                <div class="card-header">
                    <h1>Transaksi Jasa Angkutan</h1>
                </div>
                <div class="card-body">
                    <!-- Form Input -->
                    <form id="formJasa" method="POST">
                        @csrf
                        <input type="hidden" id="wood_shipping_order_id" name="wood_shipping_order_id">

                        <div class="row">
                            <!-- Customer -->
                            <div class="col-md-6">
                                <x-t-select id="customer_id" name="customer_id" label="Pelanggan" required>
                                    <option value="">-- Pilih Pelanggan --</option>
                                    @foreach ($customers as $customer)
                                        <option value="{{ $customer->id }}">{{ $customer->nama }}</option>
                                    @endforeach
                                </x-t-select>
                            </div>

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
                                <x-t-input id="tgl_kirim" name="tgl_kirim" t="date" label="Tanggal Kirim" required />
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
                                <x-t-input id="berat" name="berat" t="text" label="Berat Kayu" required />
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
                                <th>Pelanggan</th>
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
                                    <td>{{ $order->customer->nama }}</td>
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

                </div>
            </div>
        </div>
    </div>
    <x-t-modal id="prosesTransaksiModal" title="Proses Transaksi" lg="modal-lg">
        <form id="prosesTransaksiForm" method="POST">
            @csrf
            <div class="modal-body">
                <div class="row">
                    <!-- Tanggal Jatuh Tempo -->
                    <div class="col-md-12 mt-3">
                        <x-t-select id="tgl_jatuh_tempo" name="tgl_jatuh_tempo" label="Tanggal Jatuh Tempo" required>
                            <option value="">-- Pilih Jatuh Tempo --</option>
                            <option value="1">Cash</option>
                            @foreach (['7' => '7 Hari', '14' => '14 Hari', '30' => '30 Hari'] as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </x-t-select>
                    </div>

                    <!-- Status Pembayaran -->
                    <div class="col-md-12 mt-3">
                        <label class="form-label">Status Pembayaran</label>
                        <div class="d-flex">
                            <div class="form-check me-3">
                                <input class="form-check-input" type="radio" name="status" value="Lunas"
                                    required id="lunas">
                                <label class="form-check-label" for="lunas">Lunas</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" value="Belum Lunas"
                                    required id="belum_lunas">
                                <label class="form-check-label" for="belum_lunas">Belum Lunas</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success">Proses</button>
            </div>
        </form>
    </x-t-modal>

    @push('js')
        <script>
            $(document).ready(function() {
                $('#basic-datatable').DataTable();
                $("#formJasa").submit(function(e) {
                    e.preventDefault();

                    let id = $("#wood_shipping_order_id").val();
                    let formData = $(this).serialize();
                    let url = id ? `/jasa/${id}` : `{{ route('jasa.store') }}`;
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
            });

            function editData(id) {
                $.ajax({
                    url: `/jasa/${id}/edit`, // Endpoint untuk mengambil data transaksi
                    type: "GET",
                    success: function(data) {
                        // Isi form dengan data yang diterima
                        $("#wood_shipping_order_id").val(data.id);
                        $("#customer_id").val(data.customer_id);
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

                        // Ubah tombol submit
                        $("#formJasa").attr("action", `/jasa/${id}`).append(
                            '<input type="hidden" name="_method" value="PUT">');
                        $("#formJasa button[type='submit']").text("Update Transaksi");
                    }
                });
            }
        </script>
    @endpush

</x-app-layout>
