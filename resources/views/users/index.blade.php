<x-app-layout>
    <x-slot name="page">Pengguna</x-slot>
    <div class="row">
        <div class="col-sm col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table dt-responsive nowrap w-100" id="basic-datatable">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
