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
                    <div class="">
                        <div class="">
                            <input type="search" class="form-control rounded search-w" placeholder="Search"
                                aria-label="Search" aria-describedby="search-addon" />
                            {{-- <span class="input-group-text border-0" id="search-addon">
                                <i class="fas fa-search"></i>
                            </span> --}}
                        </div>
                    </div>
                </div>
                @foreach ($lelang as $lelangs)
                    @if ($penawaran->where('id_produk_lelang', $lelangs->id)->isNotEmpty())
                        @if ($lelangs->status_lelang == 1)
                            @php
                                $penawaranMax = $penawaran->where('id_produk_lelang', $lelangs->id)->max('penawaran_harga');
                            @endphp
                            <a class="text-decoration-none" href="{{ route('lelang.detail', ['id' => $lelangs->id]) }}">
                                <div class="card my-3">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <span class="fw-bold">Lelang - Dibuka Pada
                                                    {{ toIndoDate($lelangs->tanggal_mulai_lelang) }}</span>
                                            </div>
                                            <div>
                                                <span class="text-body-secondary">Sedang Berjalan</span>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-3 col-md-1 col-lg-1 my-lg-2 my-md-1 my-3">
                                                <img class="img-fluid mt-0 mt-md-0 mt-lg-0  w-100 w-md-100 w-lg-100 rounded"
                                                    src="{{ asset('storage/files/' . $lelangs->encrypted_filename) }}"
                                                    alt="">
                                            </div>
                                            <div class="col-8 col-md-9 col-lg-8 ">
                                                <div class="d-flex justify-content-between">
                                                    <div class="fw-bold">
                                                        {{ $lelangs->nama_produk_lelang }} </div>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <div class="fw-bold h5 " style="color:#598420 ;">
                                                        {{ 'Rp.' . number_format($penawaranMax) }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-8 col-md-9 col-lg-3 align-self-end">
                                                <div class="d-flex  justify-content-end">
                                                    <button class="btn btn-greenlight fw-bold" style="color:#598420 ;">Lihat
                                                        Pelelangan </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @elseif ($lelangs->status_lelang == 2)
                            @php
                                $penawaranTertinggi = App\Models\PenawaranLelang::where('status_tawaran', 1)
                                    ->where('id_produk_lelang', $lelangs->id)
                                    ->max('penawaran_harga');
                                $penawaranStatusUser = $penawaran->where('id_produk_lelang', $lelangs->id)->first();
                                $penawaranMaxUser = $penawaranStatusUser
                                    ->where('penawaran_harga', $penawaranTertinggi)
                                    ->where('id_produk_lelang', $lelangs->id)
                                    ->first();
                                $penawaranUserTertinggi = $penawaran
                                    ->where('status_tawaran', 1)
                                    ->where('id_produk_lelang', $lelangs->id)
                                    ->max('penawaran_harga');
                                // $penawaranUser = $penawaran->where('id_user', auth()->id());
                                // $penawaranUserId = $penawaran->where('penawaran_harga', $penawaranUser->max('penawaran_harga'))->first();
                            @endphp
                            @if ($penawaranUserTertinggi == $penawaranTertinggi && $penawaranMaxUser->status_tawaran == 1 && $user->status == 1)
                                @if ($penawaranMaxUser->status_konfirmasi == 1)
                                    <a class="text-decoration-none"
                                        href="{{ route('lelang.detail', ['id' => $lelangs->id]) }}">
                                        <div class="card my-3">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <span class="fw-bold">Lelang - Pesan Sebelum
                                                            {{ toIndoDate($lelangs->tanggal_pengambilan) }}</span>
                                                    </div>
                                                    <div>
                                                        <span class="text-body-secondary">Menunggu Pemesanan </span>
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-3 col-md-1 col-lg-1 my-lg-2 my-md-1 my-3">
                                                        <img class="img-fluid mt-0 mt-md-0 mt-lg-0  w-100 w-md-100 w-lg-100 rounded"
                                                            src="{{ asset('storage/files/' . $lelangs->encrypted_filename) }}"
                                                            alt="">
                                                    </div>
                                                    <div class="col-8 col-md-9 col-lg-8 ">
                                                        <div class="d-flex justify-content-between ">
                                                            <div class="fw-bold">
                                                                {{ $lelangs->nama_produk_lelang }} </div>
                                                        </div>

                                                        <div class="d-flex justify-content-between">
                                                            <div class="fw-bold h5 " style="color:#598420 ;">
                                                                {{ 'Rp.' . number_format($penawaranTertinggi) }}
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class=" col-8 col-md-9 col-lg-3 align-self-end ">
                                                        @php
                                                            $cekAlamat = App\Models\Alamat::where('id_user', auth()->id())->first();
                                                        @endphp
                                                        @if ($cekAlamat == null)
                                                            <button data-bs-toggle="modal" data-bs-target='#modal-alert'
                                                                class="btn btn-greenlight d-grid justify-content-end fw-bold"
                                                                style="color:#598420 ;">Pesan Sekarang!</button>
                                                        @else
                                                            <form class="d-grid justify-content-end" method="GET"
                                                                action="{{ route('lelang.pesanan', ['id' => $penawaranMaxUser->id]) }}">
                                                                {{-- @csrf --}}
                                                                <button
                                                                    class="btn btn-greenlight d-grid justify-content-end fw-bold"
                                                                    style="color:#598420 ;">Pesan Sekarang!</button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @elseif($penawaranMaxUser->status_konfirmasi == 2)
                                    <a class="text-decoration-none"
                                        href="{{ route('lelang.checkout.view', ['id' => $penawaranMaxUser->id]) }}">
                                        <div class="card my-3">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <span class="fw-bold">Lelang - Bayar Sebelum
                                                            {{ toIndoDate($lelangs->tanggal_konfirmasi_lelang) }}</span>
                                                    </div>
                                                    <div>
                                                        <span class="text-secondary fw-bold">Menunggu Pembayaran</span>
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-3 col-md-1 col-lg-1 my-lg-2 my-md-1 my-3">
                                                        <img class="img-fluid mt-0 mt-md-0 mt-lg-0  w-100 w-md-100 w-lg-100 rounded"
                                                            src="{{ asset('storage/files/' . $lelangs->encrypted_filename) }}"
                                                            alt="">
                                                    </div>
                                                    <div class="col-8 col-md-9 col-lg-11 ">
                                                        <div class="d-flex justify-content-between">
                                                            <div class="fw-bold">
                                                                {{ $lelangs->nama_produk_lelang }} </div>
                                                        </div>

                                                        <div class="d-flex justify-content-between">
                                                            <div class="fw-bold h5 " style="color:#598420 ;">
                                                                {{ 'Rp.' . number_format($penawaranTertinggi) }}
                                                            </div>
                                                            <div class=" col-8 col-md-9 col-lg-2 align-self-end ">

                                                                <form method="GET" class=" d-grid "
                                                                    action="{{ route('lelang.checkout.view', ['id' => $penawaranMaxUser->id]) }}">
                                                                    <button class="btn btn-greenlight fw-bold "
                                                                        style="color:#598420 ;">Bayar</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @elseif($penawaranMaxUser->status_konfirmasi == 3)
                                    @php

                                        $transaksilelang = App\Models\TransaksiLelang::where('id_penawaran', $penawaranMaxUser->id)->first();

                                    @endphp

                                    <a class="text-decoration-none"
                                        href="{{ route('lelang.checkout.view', ['id' => $penawaranMaxUser->id]) }}">
                                        <div class="card my-3">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">

                                                    <div>
                                                        <span class="fw-bold">Lelang - Dipesan Pada
                                                            {{ toIndoDate($lelangs->tanggal_konfirmasi_lelang) }}</span>
                                                    </div>
                                                    @if ($transaksilelang->status == 3)
                                                        <div>
                                                            @if ($transaksilelang->kurir == 'AMBIL_DITEMPAT')
                                                                <span class="text-secondary fw-bold">Belum Diambil</span>
                                                            @else
                                                                <span class="text-secondary fw-bold">Sedang Dikirim</span>
                                                            @endif
                                                        </div>
                                                    @elseif($transaksilelang->status == 4)
                                                        <span class="text-secondary fw-bold">Selesai</span>
                                                    @endif
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-3 col-md-1 col-lg-1 my-lg-2 my-md-1 my-3">
                                                        <img class="img-fluid mt-0 mt-md-0 mt-lg-0  w-100 w-md-100 w-lg-100 rounded"
                                                            src="{{ asset('storage/files/' . $lelangs->encrypted_filename) }}"
                                                            alt="">
                                                    </div>
                                                    <div class="col-8 col-md-9 col-lg-11 ">
                                                        <div class="d-flex justify-content-between">
                                                            <div class="fw-bold">
                                                                {{ $lelangs->nama_produk_lelang }} </div>
                                                        </div>

                                                        <div class="d-flex justify-content-between">
                                                            <div class="fw-bold h5 " style="color:#598420 ;">
                                                                {{ 'Rp.' . number_format($penawaranTertinggi) }}
                                                            </div>
                                                            <div class=" col-8 col-md-9 col-lg-2 align-self-end ">
                                                                @if ($transaksilelang->status == 3)
                                                                    @if ($transaksilelang->kurir == 'AMBIL_DITEMPAT')
                                                                        <form method="GET" class=" d-grid "
                                                                            action="{{ route('lelang.checkout.view', ['id' => $penawaranMaxUser->id]) }}">
                                                                            <button class="btn btn-greenlight fw-bold "
                                                                                style="color:#598420 ;">Diambil</button>
                                                                        </form>
                                                                    @else
                                                                        <form method="GET" class=" d-grid "
                                                                            action="{{ route('lelang.checkout.view', ['id' => $penawaranMaxUser->id]) }}">
                                                                            <button class="btn btn-greenlight fw-bold "
                                                                                style="color:#598420 ;">Diterima</button>
                                                                        </form>
                                                                    @endif
                                                                @elseif ($transaksilelang->status == 4)
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @else
                                    <a class="text-decoration-none"
                                        href="{{ route('lelang.detail', ['id' => $lelangs->id]) }}">
                                        <div class="card my-3">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <span class="fw-bold">Lelang - Konfirmasi Sebelum
                                                            {{ toIndoDate($lelangs->tanggal_konfirmasi_lelang) }}</span>
                                                    </div>
                                                    <div>
                                                        <span class="text-body-secondary">Menunggu Konfirmasi </span>
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-3 col-md-1 col-lg-1 my-lg-2 my-md-1 my-3">
                                                        <img class="img-fluid mt-0 mt-md-0 mt-lg-0  w-100 w-md-100 w-lg-100 rounded"
                                                            src="{{ asset('storage/files/' . $lelangs->encrypted_filename) }}"
                                                            alt="">
                                                    </div>
                                                    <div class="col-8 col-md-9 col-lg-8 ">
                                                        <div class="d-flex justify-content-between ">
                                                            <div class="fw-bold">
                                                                {{ $lelangs->nama_produk_lelang }} </div>
                                                        </div>

                                                        <div class="d-flex justify-content-between">
                                                            <div class="fw-bold h5 " style="color:#598420 ;">
                                                                {{ 'Rp.' . number_format($penawaranTertinggi) }}
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class=" col-8 col-md-9 col-lg-3 align-self-end ">

                                                        <form method="POST" class="d-grid justify-content-end"
                                                            action="{{ route('riwayatlelang.confirm', ['id' => $penawaranMaxUser->id]) }}">
                                                            @csrf
                                                            <button type="submit" class="btn btn-greenlight  my-1">
                                                                <div class="greendark fw-bold">
                                                                    Konfirmasi

                                                                </div>
                                                            </button>
                                                        </form>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                @endif
                            @elseif($penawaranUserTertinggi != $penawaranTertinggi && $penawaranMaxUser->status_tawaran == 1 && $user->status == 1)
                                <a class="text-decoration-none"
                                    href="{{ route('lelang.detail', ['id' => $lelangs->id]) }}">
                                    <div class="card my-3">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <span class="fw-bold">Lelang - Ditutup Pada
                                                        {{ toIndoDate($lelangs->tanggal_selesai_lelang) }}</span>
                                                </div>
                                                <div>
                                                    <span class="text-body-secondary">Gagal</span>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-3 col-md-1 col-lg-1 my-lg-2 my-md-1 my-3">
                                                    <img class="img-fluid mt-0 mt-md-0 mt-lg-0  w-100 w-md-100 w-lg-100 rounded"
                                                        src="{{ asset('storage/files/' . $lelangs->encrypted_filename) }}"
                                                        alt="">
                                                </div>
                                                <div class="col-8 col-md-9 col-lg-8 ">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="fw-bold">
                                                            {{ $lelangs->nama_produk_lelang }} </div>
                                                    </div>

                                                    <div class="d-flex justify-content-between">
                                                        <div class="fw-bold h5" style="color:#598420 ;">
                                                            {{ 'Rp.' . number_format($penawaranTertinggi) }}
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @elseif($penawaranUserTertinggi != $penawaranTertinggi && $penawaranMaxUser->status_tawaran == 0 && $user->status == 0)
                                <a class="text-decoration-none"
                                    href="{{ route('lelang.detail', ['id' => $lelangs->id]) }}">
                                    <div class="card my-3">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <span class="fw-bold">Lelang - Ditutup Pada
                                                        {{ toIndoDate($lelangs->tanggal_selesai_lelang) }}</span>
                                                </div>
                                                <div>
                                                    <span class="text-body-secondary">Dibatalkan </span>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-3 col-md-1 col-lg-1 my-lg-2 my-md-1 my-3">
                                                    <img class="img-fluid mt-0 mt-md-0 mt-lg-0  w-100 w-md-100 w-lg-100 rounded"
                                                        src="{{ asset('storage/files/' . $lelangs->encrypted_filename) }}"
                                                        alt="">
                                                </div>
                                                <div class="col-8 col-md-9 col-lg-8 ">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="fw-bold">
                                                            {{ $lelangs->nama_produk_lelang }} </div>
                                                    </div>

                                                    <div class="d-flex justify-content-between">
                                                        <div class="fw-bold h5">
                                                            {{ 'Rp.' . number_format($penawaranTertinggi) }}
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @else<a class="text-decoration-none"
                                    href="{{ route('lelang.detail', ['id' => $lelangs->id]) }}">
                                    <div class="card my-3">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <span class="fw-bold">Lelang - Ditutup Pada
                                                        {{ toIndoDate($lelangs->tanggal_selesai_lelang) }}</span>
                                                </div>
                                                <div>
                                                    <span class="text-body-secondary">Dibatalkan - User</span>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div class="col-3 col-md-1 col-lg-1 my-lg-2 my-md-1 my-3">
                                                    <img class="img-fluid mt-0 mt-md-0 mt-lg-0  w-100 w-md-100 w-lg-100 rounded"
                                                        src="{{ asset('storage/files/' . $lelangs->encrypted_filename) }}"
                                                        alt="">
                                                </div>
                                                <div class="col-8 col-md-9 col-lg-8 ">
                                                    <div class="d-flex justify-content-between">
                                                        <div class="fw-bold">
                                                            {{ $lelangs->nama_produk_lelang }} </div>
                                                    </div>

                                                    <div class="d-flex justify-content-between">
                                                        <div class="fw-bold h5">
                                                            {{ 'Rp.' . number_format($penawaranTertinggi) }}
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            @endif
                        @else
                            <div class="row">
                                <div class="col-2">
                                    <div class="d-grid">
                                        <div class="btn btn-outline-greenlight">Batal</div>
                                    </div>
                                </div>
                                <div class="col d-flex justify-content-end ">
                                    <div class="">
                                        <button class="btn btn-greenlight">Konfirmasi</button>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    <div class="modal border-warning fade " id="modal-alert" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header ">
                    <div class="h5 text-danger mt-2 fw-bold">
                        Tidak Dapat Membuat Pesanan
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="fw-bold mt-2">Data Anda Belum Lengkap ! </div> Lengkapi Data dan Alamat Anda Terlebih
                        Dahulu Pada Menu Profil Sebelum Melakukan Pemesanan!
                    </div>

                </div>
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
