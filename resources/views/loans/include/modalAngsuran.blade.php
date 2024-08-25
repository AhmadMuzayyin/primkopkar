<x-t-modal id="modal-{{ $loan->id }}" title="Angsuran" lg="">
    <div class="modal-body">
        @if ($loan->status == 'Belum Lunas')
            <div class="row">
                <div class="col-9">
                    <x-t-input id="nominal-{{ $loan->id }}" name="nominal-{{ $loan->id }}"
                        value="{{ old('nominal') }}" t="text" r=""></x-t-input>
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
                                swal.fire({
                                    title: 'Berhasil',
                                    text: data.message,
                                    icon: 'success',
                                    button: 'OK'
                                }).then(function() {
                                    window.location.reload();
                                });
                            }
                        });
                    });
                });
            });
        </script>
    @endpush
</x-t-modal>
