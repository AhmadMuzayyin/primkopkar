<x-app-layout>
    <x-slot name="page">Pengguna</x-slot>
    <div class="row">
        <div class="col-sm col-md-12">
            <div class="card">
                <div class="card-header">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal">
                        <i class="bx bx-plus"></i> Tambah Pengguna
                    </button>
                    <x-t-modal title="Tambah Pengguna">
                        <form action="{{ route('users.store') }}" method="post">
                            <div class="modal-body">
                                @csrf
                                @include('users.include.form')
                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-primary mt-3" type="submit">Simpan</button>
                            </div>
                        </form>
                    </x-t-modal>
                </div>
                <div class="card-body">
                    <table class="table dt-responsive nowrap w-100" id="basic-datatable">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>
                                    <i class="bx bx-cog"></i>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role }}</td>
                                    <td>
                                        @include('users.include.btn')
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
