<x-t-modal id="modal-{{ $loan->id }}" title="{{ $loan->status == 'Belum Lunas' ? 'Angsuran' : 'Tidak Ada Angsuran' }}"
    lg="">
    @php
        $angsuran_dibayar = 0;
        foreach ($loan->loan_payment as $payment) {
            $angsuran_dibayar += $payment->nominal_installment;
        }
        $sisa_angsuran = $loan->loan_nominal - $angsuran_dibayar;
    @endphp
    <div class="modal-body">
        @if ($loan->status == 'Belum Lunas')
            <div class="row">
                <div class="col-9">
                    <x-t-input id="nominal-{{ $loan->id }}" name="nominal-{{ $loan->id }}"
                        value="{{ old('nominal') }}" t="text" label="Sisa Angsuran"
                        value="{{ number_format($sisa_angsuran) }}" readonly />
                    <x-t-input id="nominal-{{ $loan->id }}" name="nominal-{{ $loan->id }}"
                        value="{{ old('nominal') }}" t="text" label="Nominal Pembayaran" placeholder="Nominal" />
                </div>
                <div class="col text-end">
                    <button class="btn btn-primary" id="btn-{{ $loan->id }}"><i class="bx bx-save"></i></button>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-striped dt-responsive nowrap w-100" id="table-{{ $loan->id }}">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nominal</th>
                                <th>Tanggal Pembayaran</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($loan->loan_payment as $payment)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>Rp.{{ number_format($payment->nominal_installment) }}</td>
                                    <td>{{ date('d F Y', strtotime($payment->return_date)) }}</td>
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
                $('#modal-{{ $loan->id }}').on('hidden.bs.modal', function() {
                    $('#table-{{ $loan->id }}').DataTable().destroy();
                });
                $('#modal-{{ $loan->id }}').on('shown.bs.modal', function() {
                    $('#table-{{ $loan->id }}').DataTable({
                        searching: false,
                    });
                    var btn = $('#btn-{{ $loan->id }}');
                    btn.on('click', function() {
                        var nominal = $('#nominal-{{ $loan->id }}').val();
                        $.ajax({
                            url: "{{ route('loans.payment', $loan->id) }}",
                            type: 'POST',
                            data: {
                                _token: '{{ csrf_token() }}',
                                nominal: nominal
                            },
                            success: function(data) {
                                if (data.status == 'success') {
                                    swal.fire({
                                        title: 'Berhasil',
                                        text: data.message,
                                        icon: 'success',
                                        showConfirmButton: false,
                                        timer: 1500
                                    }).then(function() {
                                        window.location.reload();
                                    });
                                }
                                if (data.status == 'error') {
                                    swal.fire({
                                        text: data.message,
                                        icon: 'error',
                                        showConfirmButton: false,
                                        timer: 1500
                                    });
                                }
                            }
                        });
                    });
                });
            });
        </script>
    @endpush
</x-t-modal>
