@extends('admin.layouts.app')
@section('content')
    <div class="col py-3 pe-5">
        <div class="h2 p-2 "><b>Customer</b></div>
        <div class="input-group rounded mt-3 mb-4">
            <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search"
                aria-describedby="search-addon" />
            <span class="input-group-text border-0" id="search-addon">
                <i class="fas fa-search"></i>
            </span>
            <div class="dropdown">
                <button class="btn btn-greenlight dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    Status
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                </ul>
            </div>
        </div>
        <table class="mt-2 table table-striped">

            <thead>
                <tr class='table-greenlight table-border-td'>
                    <th scope="col">ID Customer</th>
                    <th scope="col">Username</th>
                    <th scope="col">Nama Lengkap</th>
                    <th scope="col">Email</th>
                    <th scope="col">No Telepon</th>
                    <th scope="col">Status</th>
                    <th scope="col">Opsi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($user as $users)
                    <tr>
                        <th scope="row">1</th>
                        <td>{{ $users->username }}</td>
                        <td>{{ $users->nama_lengkap }}</td>
                        <td>{{ $users->email }}</td>
                        <td>{{ $users->telp_user }}</td>
                        @if ($users->status == 1)
                            <td> <span class="badge p-2 bg-success">Aktif</span></td>
                        @else
                            <td> <span class="badge p-2 bg-secondary">Tidak Aktif</span></td>
                        @endif
                        <td>
                            <div class="dropdown">
                                <i class='bi-three-dots btn ' data-bs-toggle="dropdown" aria-expanded="false"></i>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item"
                                            href="{{ route('customer.detail', ['id' => $users->id]) }}">Detail</a></li>
                                </ul>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
