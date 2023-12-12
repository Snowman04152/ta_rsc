@extends('admin.layouts.app')
@section('content')
    <div class="col py-3 pe-5 " >
        <div class="h2 p-2 "><b>Transaksi</b></div>
        <div class="card rounded-4 bg-light">
            <div class="card-body ">
                <div class="row text-center">
                    <div class="col border-end border-black p-3 ">
                        <h5 class="card-title h2 fw-bold">26</h5>
                        <p class="card-text">Menunggu Pembayaran</p>
                    </div>
                    <div class="col  border-end border-black p-3">
                        <h5 class="card-title h2 fw-bold">619</h5>
                        <p class="card-text">Sedang Proses</p>
                    </div>
                    <div class="col border-end border-black p-3">
                        <h5 class="card-title h2 fw-bold">619</h5>
                        <p class="card-text">Dalam Perjalanan</p>
                    </div>
                    <div class="col border-end border-black p-3">
                        <h5 class="card-title h2 fw-bold">619</h5>
                        <p class="card-text">Selesai</p>
                    </div>
                    <div class="col p-3">
                        <h5 class="card-title h2 fw-bold">619</h5>
                        <p class="card-text">Dibatalkan</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="container bg-light p-3 mt-3 rounded-4">
            <div class="input-group rounded mt-3 mb-4">
                <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search"
                    aria-describedby="search-addon" />
                <span class="input-group-text border-0" id="search-addon">
                    <i class="fas fa-search"></i>
                </span>
                <div class="dropdown">
                    <button class="btn btn-greenlight dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Semua Status
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
                    <tr class='table-greenlight table-border-td '>
                        <th scope="col">No Transaksi</th>
                        <th scope="col">Pembeli</th>
                        <th scope="col">Produk</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Status</th>
                        <th scope="col">Opsi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaksi as $transaksis)
                        <tr>
                            <th scope="row">TR-000{{ $loop->iteration }}</th>
                            @php
                                $KeranjangProduk = App\Models\Keranjang::with('varian.produk')
                                    ->where('id_transaksi', $transaksis->id)
                                    ->first();
                                $jumlah = App\Models\Keranjang::where('id_transaksi', $transaksis->id)->count();
                            @endphp
                            <td >{{ $transaksis->user->username }}</td>
                            @if ($jumlah <= 1)
                                <td>{{ $KeranjangProduk->varian->produk->nama_produk }}</td>
                            @else
                                <td>{{ $KeranjangProduk->varian->produk->nama_produk . ' ' . $KeranjangProduk->varian->berat . ' Kg' . ' + ' . $jumlah - 1 . ' Lainnya' }}
                                </td>
                            @endif
                            <td>{{ toDate($transaksis->created_at) }}</td>
    
                            @if ($transaksis->status == 0)
                                <td><span class="badge bg-warning text-dark p-2" >Menunggu Pembayaran</span> </td>
                            @elseif($transaksis->status == 1)
                                <td > <span class="badge text-secondary p-2" style="background-color: #D9EFBD"> Sedang diproses</span></td>
                            @elseif($transaksis->status == 2)
                            <td ><span class="badge text-secondary p-2" style="background-color: #A3D95D">Belum Diambil</span></td>
                            @elseif($transaksis->status == 3)
                            <td><span class="badge text-secondary p-2" style="background-color: #A3D95D">Dalam Perjalanan</span></td>
                            @elseif($transaksis->status == 4)
                            <td><span class="badge  p-2" style="background-color: #598420">Selesai</span></td>
                            @else
                            <td><span class="badge text-danger p-2" style="background-color: #FFDCDC">Dibatalkan</span></td>
                            @endif
                            <td>
                                <div class="dropdown">
                                    <i class='bi-three-dots btn ' data-bs-toggle="dropdown" aria-expanded="false"></i>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item"
                                                href="{{ route('transaksi.detail', ['id' => $transaksis->id]) }}">Detail</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
