<button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#piutang-{{ $model->id }}">
    <i class="bx bx-show"></i>
</button>
<x-t-modal id="piutang-{{ $model->id }}" title="Pelunasan" lg="">
    <div class="modal-body">
        <div class="form-group">
            <x-t-input id="nama" name="nama" value="{{ $model->name }}" label="Nama Anggota" t="text"
                readonly />
        </div>
        <div class="form-group">
            <x-t-input id="nominal" name="nominal" value="" label="Masukan Nominal Pembayaran" t="number"
                r="" />
        </div>
        <div class="form-group">
            <button class="btn btn-primary" id="piutangbtn-{{ $model->id }}"><i class="bx bx-save"></i>
                Simpan</button>
        </div>
    </div>
</x-t-modal>
<script>
    $('#piutang-{{ $model->id }}').on('show.bs.modal', function() {
        var nominal = $('#nominal');
        var btn = $('#piutangbtn-{{ $model->id }}');
        btn.on('click', function() {
            $.ajax({
                url: '{{ route('laporan.piutang_member.update') }}',
                type: 'POST',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'member_id': '{{ $model->id }}',
                    'nominal': nominal.val()
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
                    var errorNominal = err.responseJSON.errors
                    var message = errorNominal ? errorNominal.nominal[0] : err.responseJSON
                        .message
                    Swal.fire({
                        icon: 'error',
                        title: message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            })
        })
    });
</script>
