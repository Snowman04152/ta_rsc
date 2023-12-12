@extends('customer.layouts.app')
@section('content')
    <div class="container p-4">
        <h3>Profil</h3>
        <div class="row">
            <div class="col-12 col-md-4 col-lg-4 ">
                @include('customer.layouts.side_profile')
            </div>
            <div class="col">
                <div class="rounded ">
                    <div class="row ">
                        <div class="col-12 col-md-12 col-lg-12">
                            <input type="search" class="form-control rounded search-w" placeholder="Search"
                                aria-label="Search" aria-describedby="search-addon" />
                            {{-- <span class="input-group-text border-0" id="search-addon">
                                <i class="fas fa-search"></i>
                            </span> --}}
                        </div>
                        {{-- <div class="col-12 col-md-9 col-lg-5 mt-3 mt-md-3 mt-lg-0">
                            <div class="d-flex gap-2">
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle  " type="button" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        Semua Pembelian
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="#">Action</a></li>
                                        <li><a class="dropdown-item" href="#">Another action</a></li>
                                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                                    </ul>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-secondary dropdown-toggle pe-5 ms-2 ms-md-0 ms-lg-0" type="button" data-bs-toggle="dropdown"
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
                        </div> --}}
                    </div>
                </div>
                @foreach ($transaksi as $transaksis)
                    <a class="text-decoration-none" href="{{ route('produk.beli.view', ['id' => $transaksis->id]) }}">
                        <div class="card my-3">
                            @if ($transaksis->status == 0)
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <span class="fw-bold">Produk - Dipesan
                                                pada {{ ToIndoDate($transaksis->created_at) }} </span>
                                        </div>
                                        <div>
                                            <span class="text-body-secondary fw-bold">Menunggu Pembayaran </span>
                                        </div>
                                    @elseif($transaksis->status == 1)
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <span class="fw-bold">Produk - Dipesan
                                                        pada {{ ToIndoDate($transaksis->updated_at) }} </span>
                                                </div>
                                                <div>
                                                    <span class="text-body-secondary fw-bold">Sedang Diproses </span>
                                                </div>
                                            @elseif($transaksis->status == 2)
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between">
                                                        <div>
                                                            <span class="fw-bold">Produk - Dipesan
                                                                pada {{ ToIndoDate($transaksis->updated_at) }} </span>
                                                        </div>
                                                        {{-- @if ($transaksis->kurir == 'AMBIL_DITEMPAT') --}}
                                                        <div><span class="text-body-secondary fw-bold">Belum
                                                                Diambil</span>
                                                        </div>
                                                        {{-- @else
                                                            <div><span class="text-body-secondary fw-bold">Sedang
                                                                    Dikirim</span>
                                                            </div>
                                                        @endif --}}
                                                    @elseif($transaksis->status == 3)
                                                        <div class="card-body">
                                                            <div class="d-flex justify-content-between">
                                                                <div>
                                                                    <span class="fw-bold">Produk - Dipesan
                                                                        pada {{ ToIndoDate($transaksis->updated_at) }}
                                                                    </span>
                                                                </div>
                                                                <div>
                                                                    <span class="text-body-secondary fw-bold">Sedang Dikirim
                                                                    </span>
                                                                </div>
                                                            @elseif($transaksis->status == 5)
                                                                <div class="card-body">
                                                                    <div class="d-flex justify-content-between">
                                                                        <div>
                                                                            <span class="fw-bold">Produk - Dipesan
                                                                                pada
                                                                                {{ ToIndoDate($transaksis->updated_at) }}
                                                                            </span>
                                                                        </div>
                                                                        <div>
                                                                            @php
                                                                                $ulasanExists = App\Models\Ulasan::where('id_transaksi', $transaksis->id)->exists();
                                                                                // dd($ulasanExists);
                                                                            @endphp

                                                                                <span
                                                                                    class="text-body-secondary fw-bold">Dibatalkan
                                                                                </span>
                                                                        
                                                                        </div>
                                                                    @else
                                                                        <div class="card-body">
                                                                            <div class="d-flex justify-content-between">
                                                                                <div>
                                                                                    <span class="fw-bold">Produk - Dipesan
                                                                                        pada
                                                                                        {{ ToIndoDate($transaksis->updated_at) }}
                                                                                    </span>
                                                                                </div>
                                                                                <div>
                                                                                    @php
                                                                                        $ulasanExists = App\Models\Ulasan::where('id_transaksi', $transaksis->id)->exists();
                                                                                        // dd($ulasanExists);
                                                                                    @endphp
                                                                                    @if (!$ulasanExists)
                                                                                        <span
                                                                                            class="text-body-secondary fw-bold">Belum
                                                                                            Diulas
                                                                                        </span>
                                                                                    @else
                                                                                        <span
                                                                                            class="text-body-secondary fw-bold">Selesai
                                                                                        </span>
                                                                                    @endif
                                                                                </div>
                            @endif
                        </div>
                        @php
                            $KeranjangProduk = App\Models\Keranjang::with('varian.produk')
                                ->where('id_transaksi', $transaksis->id)
                                ->first();
                            $jumlah = App\Models\Keranjang::where('id_transaksi', $transaksis->id)->count();
                        @endphp
                        <div class="row mt-3">
                            <div class="col-3 col-md-1 col-lg-1 my-lg-2 my-md-1 my-3">
                                <img class="img-fluid mt-0 mt-md-0 mt-lg-0  w-100 w-md-100 w-lg-100 rounded"
                                    src="{{ asset('storage/files/' . $KeranjangProduk->varian->produk->encrypted_filename) }}"
                                    alt="">
                            </div>
                            <div class="col-8 col-md-9 col-lg-9 ">
                                <div class="d-flex justify-content-between ">

                                    @if ($jumlah <= 1)
                                        <div class="fw-bold">{{ $KeranjangProduk->varian->produk->nama_produk }} </div>
                                    @else
                                        <div class="fw-bold">
                                            {{ $KeranjangProduk->varian->produk->nama_produk . ' ' . $KeranjangProduk->varian->berat . ' Kg' . ' + ' . $jumlah - 1 . ' Lainnya' }}
                                        </div>
                                    @endif
                                </div>

                                <div class="d-flex justify-content-between">
                                    <div class="fw-bold h5 " style="color:#598420 ;">
                                        {{ 'Rp.' . number_format($transaksis->total_harga) }}
                                    </div>

                                </div>
                            </div>
                            <div class=" col-8 col-md-9 col-lg-2 align-self-end ">

                                @if ($transaksis->status == 0)
                                    <form method="GET" class=" d-grid "
                                        action="{{ route('produk.beli.view', ['id' => $transaksis->id]) }}">
                                        <button class="btn btn-greenlight fw-bold " style="color:#598420 ;">Bayar</button>
                                    </form>
                                @elseif ($transaksis->status == 1)

                                @elseif($transaksis->status == 2)
                                    {{-- @if ($transaksis->kurir == 'AMBIL_DITEMPAT') --}}
                                    <form method="GET" class=" d-grid "
                                        action="{{ route('produk.beli.view', ['id' => $transaksis->id]) }}">
                                        <button class="btn btn-greenlight fw-bold " style="color:#598420 ;">Diambil</button>
                                    </form>
                                    {{-- @endif --}}
                                @elseif($transaksis->status == 3)
                                    <form method="GET" class=" d-grid "
                                        action="{{ route('produk.beli.view', ['id' => $transaksis->id]) }}">
                                        <button class="btn btn-greenlight fw-bold "
                                            style="color:#598420 ;">Diterima</button>
                                    </form>
                                @elseif($transaksis->status == 4)
                                    @php
                                        $ulasanExists = App\Models\Ulasan::where('id_transaksi', $transaksis->id)->exists();
                                        // dd($ulasanExists);
                                    @endphp
                                    @if (!$ulasanExists)
                                        <form method="GET" class=" d-grid "
                                            action="{{ route('produk.beli.view', ['id' => $transaksis->id]) }}">
                                            <button class="btn btn-greenlight fw-bold "
                                                style="color:#598420 ;">Ulas</button>
                                        </form>
                                    @else
                                    @endif
                                @endif
                            </div>
                        </div>
            </div>
        </div>
        </a>
        @endforeach
    </div>
    </div>
    </div>
    {{-- <script type="module">
        const modaledit = new bootstrap.Modal('#modal-add-alamat', {
            keyboard: false
        })
        window.onload = modaledit.show();
    </script> --}}
    </div>
@endsection
