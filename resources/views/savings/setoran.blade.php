<div class="row">
    <div class="col-6">
        <form action="">
            <x-t-select id="setoranSelect" name="" value="" label="">
                <option value="" selected disabled>Pilih Member</option>
                @foreach ($members as $member)
                    <option value="{{ $member->id }}">{{ $member->name }}</option>
                @endforeach
            </x-t-select>
        </form>
        @include('savings.include.setoranModal')
    </div>
</div>
<div class="table-responsive">
    <table id="tableSetoran" class="table table-striped">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Saldo</th>
                <th>
                    <i class="bx bx-cog"></i>
                </th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
@push('js')
    <script>
        var columns = [{
                data: 'member_name',
                name: 'member.name'
            },
            {
                data: 'saving_category_name',
                name: 'saving_category.name',
            },
            {
                data: 'nominal',
                name: 'nominal'
            }, {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ];
        var table = $('#tableSetoran').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('savings.index') }}",
                type: 'GET',
                data: {
                    type: 'Setoran'
                }
            },
            columns: columns
        });
        $('#setoranSelect').on('change', function() {
            var id = $(this).val()
            var type = 'Setoran'
            $.ajax({
                url: `/savings/${id}/show`,
                type: 'GET',
                data: {
                    id: id,
                    type: type
                },
                success: function(data) {
                    if (data.status == 'success') {
                        var modal = $('#modalSetoran')
                        modal.modal('show')
                        modal.on('shown.bs.modal', function() {
                            var value = data.data[0] && data.data[0].member && data.data[0]
                                .member.name ?
                                data.data[0].member.name :
                                data.data.name;
                            var inputHtml = `
                            <div class="row">
                                <div class="col-9">
                                    <x-t-input id="member" name="member" value="${value}" t="text" r="" readonly/>
                                    <x-t-select id="setoranKategori" name="" value="">
                                        <option value="" selected disabled>Pilih Kategori</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </x-t-select>
                                    <x-t-input id="nominal" name="nominal" value="" min="1000" t="number" min="1" placeholder="Nominal Setoran" />
                                </div>
                                <div class="col text-end">
                                    <button class="btn btn-primary" id="btnSaveSetoran"><i class="bx bx-save"></i></button>
                                </div>
                            </div>
                        `
                            $('#showInput').html(inputHtml)
                        })
                    }
                },
                error: function(err) {
                    swal.fire({
                        icon: 'error',
                        title: err.message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            })
        })
        $('#nominal').on('input', function() {
            var value = $(this).val()
            if (value < 0) {
                $(this).val(0)
            }
        })
        $('#showInput').on('click', '#btnSaveSetoran', function() {
            var member_id = $('#setoranSelect').val()
            var category_id = $('#setoranKategori').val()
            var nominal = $('#nominal').val()
            $.ajax({
                url: "{{ route('savings.store') }}",
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    member_id: member_id,
                    saving_category_id: category_id,
                    nominal: nominal,
                },
                success: function(data) {
                    if (data.status == 'success') {
                        swal.fire({
                            title: 'Berhasil',
                            text: data.message,
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        setTimeout(() => {
                            window.location.reload()
                        }, 1500)
                    }
                },
                error: function(err) {
                    swal.fire({
                        icon: 'error',
                        title: err.message,
                        showConfirmButton: false,
                        timer: 1500
                    })
                }
            })
        });
    </script>
@endpush
