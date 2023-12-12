@extends('customer.layouts.app')
@section('content')
    <div class="container p-3">
        <div class="h6 mt-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb fw-bold">
                    <li class="breadcrumb-item "><a class="text-decoration-none text-dark"
                            href="{{ route('keranjang.index') }}"><i class="bi bi-chevron-left fw-bold"></i>Detail Pesanan</a>
                    </li>
                </ol>
            </nav>
        </div>

        <div class="row">
            <div class="col-12 col-md-7 col-lg-9">
                <div class="card rounded-4 p-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="row">
                                <div class="col-8">Status</div>
                                <div class="col fw-bold">Pesanan Belum Dibuat</div>
                            </div>
                            <div class="row">
                                <div class="col-8">Tanggal Pembelian</div>
                                <div class="col fw-bold">Anda Belum Membuat Pesanan</div>
                            </div>
                            <div class="row">
                                <div class="col-8">Jenis Pesanan</div>
                                <div class="col  fw-bold"> Reguler </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="fw-bold mb-1">Alamat </div>

                @if ($alamatActive)
                    <button type="button" class="btn btn-outline-secondary border rounded-4 w-100 " data-bs-toggle="modal"
                        data-bs-target='#modal-alamat'>
                        <div class="row">
                            <div class="col-11">

                                <div class="text-start p-2 btn-w">
                                    <div>
                                        <a> {{ $alamatActive->label }} </a>
                                    </div>
                                    <div>
                                        <span class='fw-bold'> {{ $alamatActive->penerima }} </span>
                                    </div>
                                    <div>
                                        <span>{{ $alamatActive->telepon }}</span>
                                        <span></span>
                                    </div>
                                    <div>
                                        <span>{{ ucfirst($alamatActive->nama_jalan) }},</span>
                                        <span>{{ ucwords(strtolower($alamatActive->kecamatan)) }},</span>
                                        <span>{{ ucwords(strtolower($alamatActive->kabupaten)) }},</span>
                                        <span>{{ ucwords(strtolower($alamatActive->provinsi)) }},</span>
                                        <span>{{ $alamatActive->kode_pos }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col d-flex align-items-center">
                                <i class="bi bi-chevron-right fw-bold "></i>
                            </div>
                    </button>
                @else
                    <div class="card rounded-4 p-3">
                        <div class="card-body">
                            <div>Anda Belum Mengisi Alamat </div>
                        </div>
                    </div>
                @endif
                <div class="fw-bold my-2"> Opsi Pengiriman </div>
                <div class="">
                    @php

                    @endphp
                    <button type="button" class="btn btn-outline-secondary border rounded-4 w-100" data-bs-toggle="modal"
                        data-bs-target='#modal-kurir'>
                        <div class="text-start p-4">
                            <div class="d-flex justify-content-between">
                                <span>{{ $pengiriman ? $pengiriman->opsi . ' - ' . $pengiriman->service : 'Ambil di Lobby ITTS' }}</span>
                                <span>Rp.{{ $pengiriman ? number_format($pengiriman->cost[0]->value) : 0 }}</span>
                            </div>
                    </button>
                </div>
                <form action="{{ route('produk.beli') }}" method="POST" id='checkout'>
                    @csrf
                     <div class="fw-bold my-2"> Daftar Produk </div>
                    @foreach ($keranjang as $keranjangs)
                        <div class="card rounded-4 mb-2">

                            <input hidden type="number" name="keranjang[{{ $keranjangs->id }}][id_keranjang]"
                                value="{{ $keranjangs->id }}">
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-12 col-md-6 col-lg-1 ">
                                        <img src="{{ asset('storage/files/' . $keranjangs->varian->produk->encrypted_filename) }}"
                                            alt=".." class="img-fluid rounded w-100">
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-11 ">
                                        <p class="h5 fw-bold">{{ $keranjangs->varian->produk->nama_produk }}</p>
                                        <p>Varian: {{$keranjangs->varian->berat. ' Kg'}}</p>
                                        <div class="d-flex  justify-content-between">
                                            <h5 class=" fw-bold" style="color:#598420 ;">
                                                {{ 'Rp.' . number_format($keranjangs->varian->harga_produk) }}</h5>
                                            <div>x{{ $keranjangs->jumlah_produk }} Barang </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

            </div>
            @php
                $TotalHarga = 0;
                foreach ($keranjang as $item) {
                    $TotalHarga += $item->varian->harga_produk * $item->jumlah_produk ?? 0;
                }
                // $TotalBarang = 0
                // foreach ($keranjang as $item) {
                //     $TotalBarang += $item->varian->harga_produk ?? 0;
                // }
            @endphp
            <div class="col-12 col-md-3 col-lg-2">
                <div class="card card-w ">
                    <div class="card-body">
                        <h5 class="card-title">Ringkasan </h5>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th scope="row" class="w-75">Jumlah Barang : </th>
                                    <th>{{ $keranjang->sum('jumlah_produk') }}</th>
                                </tr>
                                <tr>
                                    <th scope="row" class="w-50">Total Harga Barang : </th>
                                    <th>{{ 'Rp.' . number_format($TotalHarga) }}</th>
                                </tr>
                                <tr>
                                    <th scope="row" class="w-50">Ongkos Kirim : </th>
                                    <th>Rp.{{ $pengiriman ? number_format($pengiriman->cost[0]->value) : 0 }}</th>
                                </tr>
                                <tr>
                                    <th scope="row" class="w-50">Total Harga: </th>
                                    @php
                                        $ongkir = $pengiriman ? $pengiriman->cost[0]->value : 0;

                                    @endphp
                                    <th>Rp.{{ number_format($TotalHarga + $ongkir) }}</th>
                                </tr>
                            </tbody>
                        </table>
                        <div>
                            {{-- <form method="POST" action="{{ route('lelang.checkout', ['id' => $penawaran->id]) }}"> --}}

                            <input hidden  type="number" name="id_alamat" value="{{ $alamatActive ? $alamatActive->id : '' }}">
                            <input hidden type="text" name="nama_kurir"
                                value="{{ $pengiriman ? $pengiriman->opsi . ' - ' . $pengiriman->service : 'AMBIL_DITEMPAT' }}">
                            <input hidden type="number" name="harga_ongkir"
                                value="{{ $pengiriman ? $pengiriman->cost[0]->value : 0 }}">
                            <input hidden type="number" name="total_harga" value="{{ $TotalHarga + $ongkir }}">
                            <div class="d-grid">
                                <button form='checkout' type="submit" class="btn btn-greenlight fw-bold mt-3 "
                                    style="color:#598420 ;">
                                    Buat
                                    Pesanan
                                </button>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
    </div>

    <div class="modal fade" id="modal-alamat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Alamat</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="">
                        <div class="fw-bold"> Pilih Alamat :</span>
                            @php
                                $alamats = $user && $user->alamat ? $user->alamat : [];
                            @endphp
                            @foreach ($alamats as $alamat)
                                <div class="my-2 card">
                                    <a class="text-decoration-none text-dark card-body"
                                        href="{{ route('produk.pesanan', ['alamat' => $alamat->id]) }}">
                                        <div class="text-start">
                                            <div>
                                                <span> {{ $alamat->label }} </span>
                                            </div>
                                            <div>
                                                <span class='fw-bold'> {{ $alamat->penerima }} </span>
                                            </div>
                                            <div>
                                                <span>{{ $alamat->telepon }}</span>
                                                <span></span>
                                            </div>
                                            <div>
                                                <span>{{ $alamat->nama_jalan }},</span>
                                                <span>{{ $alamat->kecamatan }},</span>
                                                <span>{{ $alamat->provinsi }},</span>
                                                <span>{{ $alamat->kode_pos }}</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-kurir" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Pengiriman</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="">
                        <div class="fw-bold"> Pilih Opsi Pengiriman</span>
                            <div class="my-2">
                                @php
                                    $param = null;
                                    if ($alamatActive) {
                                        $param['alamat'] = $alamatActive->id;
                                    }
                                @endphp
                                <a href="{{ route('produk.pesanan', $param) }}" class="mb-3 btn border w-100">
                                    <div class="row">
                                        <div class="col-10">
                                            <div class="text-start">
                                                <div class='fw-bold'>
                                                    <span> Ambil Ditempat</span>
                                                </div>
                                                <div>
                                                    <span> Ambil di Lobby ITTS
                                                        pada
                                                        12 Agustus 2023
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div>
                                                <span> Rp.0 </span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                                @if ($alamatActive)
                                    @foreach ($rajaongkirpos->costs as $key => $ongkir)
                                        <a href="{{ route('produk.pesanan', ['alamat' => $alamatActive->id, 'kurir' => 'pos', 'opsi_pengiriman' => $key]) }}"
                                            class="mb-3 btn border w-100">
                                            <div class="row g-2">
                                                <div class="col">
                                                    <div class="text-start">
                                                        <div class='fw-bold'>
                                                            <span>{{ $rajaongkirpos->name }}</span>
                                                        </div>
                                                        <div>
                                                            <span>{{ $ongkir->service }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col ">
                                                    <div>
                                                        <span> Rp. {{ number_format($ongkir->cost[0]->value) }} </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach

                                    @foreach ($rajaongkirjne->costs as $ongkir)
                                        <a href="{{ route('produk.pesanan', ['alamat' => $alamatActive->id, 'kurir' => 'pos', 'opsi_pengiriman' => $key]) }}"
                                            class="mb-3 btn border w-100">
                                            <div class="row g-2">
                                                <div class="col">
                                                    <div class="text-start">
                                                        <div class='fw-bold'>
                                                            <span>{{ $rajaongkirjne->name }}</span>
                                                        </div>
                                                        <div>
                                                            <span>{{ $ongkir->description }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col ">
                                                    <div>
                                                        <span> Rp. {{ number_format($ongkir->cost[0]->value) }} </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- <script type="module">
        const modalKurir = new bootstrap.Modal('#modal-kurir', {
            keyboard: false
        })
        window.onload = modalKurir.show();
    </script> --}}
@endsection
