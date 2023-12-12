@extends('admin.layouts.app')
@section('content')
    <div class="col py-3 pe-5">
        <div class="h2 p-2 "><b>Pembeli / Detail Pembeli / Riwayat Transaksi</b></div>
        
        <div class="input-group rounded mt-3 mb-4">
            <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search"
                aria-describedby="search-addon" />
            <span class="input-group-text border-0" id="search-addon">
                <i class="fas fa-search"></i>
            </span>
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
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
                <tr class='table-secondary'>
                    <th scope="col">ID Transaksi</th>
                    <th scope="col">Pembeli</th>
                    <th scope="col">Produk</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Status</th>
                    <th scope="col">Opsi</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>Risa Andini</td>
                    <td>Jeruk Madu</td>
                    <td>13 Juni 2023, 08:46</td>
                    <td>Sedang Proses</td>
                    <td>
                        <div class="dropdown">
                            <i class='bi-three-dots btn ' data-bs-toggle="dropdown" aria-expanded="false" ></i>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Detail</a></li>
                            </ul>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
@endsection
