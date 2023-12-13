@extends('customer.layouts.app')
@section('content')
    <div class="container p-5">
        <div class="row">
            <div class="col-12">
                <img src="{{ Vite::asset('resources/images/banner.png') }}" class="img-fluid" alt="">
            </div>
        </div>

        <div class="row rounded mt-3 mb-4">
            <div class="col-10">
                <input type="search" class="form-control rounded border-greenlight" placeholder="Search" aria-label="Search"
                    aria-describedby="search-addon" />
            </div>
            <div class="col ">
                <div class="dropdown d-grid ">
                    <button class="btn btn-outline-greenlight dropdown-toggle" type="button" data-bs-toggle="dropdown"
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
        </div>
        <div class="row g-4">
            @foreach ($produk as $index => $produks)
                @if ($produks->status == 1 && $produks->stok > 0)
                    {{-- {{dd($produks->varian[0]->stok)}} --}}
                    <div class="col-12 col-md-6 col-lg-3">
                        <a class="text-decoration-none " href="{{ route('detailproduk', ['id' => $produks->id]) }}">
                            <div class="card">
                                <img src="{{ asset('storage/files/' . $produks->encrypted_filename) }}"
                                    class="card-img-top " alt="...">
                                <div class="position text-light w-100">
                                    <p class="p-2 m-0 bg-success">Tersedia</p>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">{{ $produks->nama_produk }}</h5>
                                    @php
                                        $ascHarga = App\Models\Varian::where('id_produk', $produks->id)
                                            ->orderBy('harga_produk', 'asc')
                                            ->first();

                                        $descHarga = App\Models\Varian::where('id_produk', $produks->id)
                                            ->orderBy('harga_produk', 'desc')
                                            ->first();

                                        if ($ascHarga !== null) {
                                            $ascHarga = $ascHarga->harga_produk;
                                        } else {
                                            // Lakukan sesuatu jika $ascHarga bernilai null
                                        }

                                        if ($descHarga !== null) {
                                            $descHarga = $descHarga->harga_produk;
                                        } else {
                                            // Lakukan sesuatu jika $descHarga bernilai null
                                        }
                                        $varian = App\Models\Varian::where('id_produk', $produks->id)->first();

                                        if ($varian && $varian->id !== null) {
                                            $ulasan = App\Models\Ulasan::with('transaksi.user', 'varian')
                                                ->where('id_varian', $varian->id)
                                                ->get();

                                            if ($ulasan->count() == 0) {
                                                $ratingTotal = 0;
                                                $transaksiTotal = 0;
                                                $ulasanTotal = 0;
                                            } else {
                                                $ratingTotal = $ulasan->sum('rating') / $ulasan->count();
                                                $transaksiTotal = App\Models\Keranjang::join('varians', 'keranjangs.id_varian', '=', 'varians.id')
                                                    ->where('varians.id_produk', $varian->id_produk)
                                                    ->whereNotNull('keranjangs.id_transaksi')
                                                    ->count();
                                                $ulasanTotal = $ulasan->count();
                                            }
                                        } else {
                                            $ulasan = null;
                                            $ratingTotal = 0;
                                            $transaksiTotal = 0;
                                            $ulasanTotal = 0;
                                        }

                                    @endphp
                                    <p class="card-text">
                                        {{ 'Rp' . '.' . number_format($ascHarga) . ' - ' . 'Rp' . '.' . number_format($descHarga) }}
                                    </p>
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <div><i
                                                    class=" fas fa-star amber-text active">&nbsp</i><span>{{ $ratingTotal }}</span>
                                            </div>

                                        </div>
                                        <div>
                                            <span class="ms-2">{{ $transaksiTotal }} Terjual</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @else
                    <div class="col-12 col-md-6 col-lg-3">
                        <a class="text-decoration-none " href="{{ route('detailproduk', ['id' => $produks->id]) }}">
                            <div class="card">

                                <img src="{{ asset('storage/files/' . $produks->encrypted_filename) }}" class="card-img-top"
                                    style="filter: grayscale(100%); -webkit-filter: grayscale(100%);">
                                <div class="position text-light w-100" style="background-color: rgba(0, 0, 0, 0.5)">
                                    <p class="p-2 m-0">Stok Habis</p>
                                </div>

                                <div class="card-body">
                                    <h5 class="card-title">{{ $produks->nama_produk }}</h5>
                                    @php
                                        $ascHarga = App\Models\Varian::where('id_produk', $produks->id)
                                            ->orderBy('harga_produk', 'asc')
                                            ->first();

                                        $descHarga = App\Models\Varian::where('id_produk', $produks->id)
                                            ->orderBy('harga_produk', 'desc')
                                            ->first();

                                        if ($ascHarga !== null) {
                                            $ascHarga = $ascHarga->harga_produk;
                                        } else {
                                            // Lakukan sesuatu jika $ascHarga bernilai null
                                        }

                                        if ($descHarga !== null) {
                                            $descHarga = $descHarga->harga_produk;
                                        } else {
                                            // Lakukan sesuatu jika $descHarga bernilai null
                                        }
                                        $varian = App\Models\Varian::where('id_produk', $produks->id)->first();

                                        if ($varian && $varian->id !== null) {
                                            $ulasan = App\Models\Ulasan::with('transaksi.user', 'varian')
                                                ->where('id_varian', $varian->id)
                                                ->get();

                                            if ($ulasan->count() == 0) {
                                                $ratingTotal = 0;
                                                $transaksiTotal = 0;
                                                $ulasanTotal = 0;
                                            } else {
                                                $ratingTotal = $ulasan->sum('rating') / $ulasan->count();
                                                $transaksiTotal = App\Models\Keranjang::where('id_varian', $varian->id)
                                                    ->whereNotNull('id_transaksi')
                                                    ->count();
                                                $ulasanTotal = $ulasan->count();
                                            }
                                        } else {
                                            $ulasan = null;
                                            $ratingTotal = 0;
                                            $transaksiTotal = 0;
                                            $ulasanTotal = 0;
                                        }

                                    @endphp
                                    <p class="card-text">
                                        {{ 'Rp' . '.' . number_format($ascHarga) . ' - ' . 'Rp' . '.' . number_format($descHarga) }}
                                    </p>
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <div><i
                                                    class=" fas fa-star amber-text active">&nbsp</i><span>{{ $ratingTotal }}</span>
                                            </div>

                                        </div>
                                        <div>
                                            <span class="ms-2">{{ $transaksiTotal }} Terjual</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endsection
