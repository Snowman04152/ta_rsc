@extends('customer.layouts.app')
@section('content')
    <div class="container ">
        <div class="row ">
            <div class="h4 fw-bold my-4">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a class='text-decoration-none text-dark'
                                href="{{ route('lelangprod') }}"><i class="bi bi-chevron-left"></i>Lelang</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Detail Lelang</li>
                    </ol>
                </nav>
            </div>
            <div class="col-12 col-md-6 col-lg-8">
                <div class="row ">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="row">
                            <div class="col-12 col-md-8 col-lg-4 my-3 my-md-0 my-lg-0">
                                <div class="text-center">
                                    <img src="{{ asset('storage/files/' . $lelang->encrypted_filename) }}" alt=""
                                        class='image-fluid w-100 rounded-3'>
                                </div>
                            </div>
                            <div class="col-12 col-md-12 col-lg-7">
                                <div class="h4  fw-bold">{{ $lelang->nama_produk_lelang }}</div>
                                <div class="row">
                                    <div class="col greendark  ">
                                        <span class="fw-bold h5">Harga Mulai </span>
                                        <span class="fw-bold h5">{{ 'Rp.' . number_format($lelang->harga_lelang) }}</span>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col ">
                                        <span class="fw-bold ">Mulai :</span>
                                        <span class="">{{ toIndoDate($lelang->tanggal_mulai_lelang) }} WIB</span>
                                    </div>
                                    <div class="col">
                                        <span class="fw-bold ">Berakhir:</span>
                                        <span class="">{{ toIndoDate($lelang->tanggal_selesai_lelang) }} WIB</span>
                                    </div>
                                </div>
                                <div class="row ">
                                    <div class="col">
                                        <div class="fw-bold">Umur Simpan</div>
                                        <div>{{ $lelang->umur_simpan }}</div>
                                    </div>
                                    <div class="col">

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-12 col-lg-11 my-3">
                        <div class="h4 my-2 fw-bold"> Deskripsi</div>
                        <p class="para-w">{{ $lelang->deskripsi }}</p>
                    </div>
                </div>
            </div>
            @if ($user->status == 1)
                @if ($lelang->status_lelang == 0)
                    <div class="col-8 col-md-6 col-lg-4 ms-0 ">
                        <div class="card rounded-3 card-w-md p-4 gap-1 border-secondary">
                            <div class="text-center fw-bold h5">Lelang belum dibuka!</div>
                            <div class="text-center">Akan dibuka pada {{ toIndoDate($lelang->tanggal_mulai_lelang) }} WIB.
                                Silakan buat pengingat agar tidak tertinggal disesi lelang ini.</div>
                            @if ($pengingat == null)
                                <form action="{{ route('lelang.pengingat.detail', ['id_produk_lelang' => $lelang->id]) }}"
                                    method="POST">
                                    @csrf
                                    <div class="d-grid">
                                        <button type="submit" class="btn btn-outline-greenlight  my-3">
                                            <div class="greendark fw-bold">
                                                Atur Pengingat
                                            </div>
                                        </button>
                                    </div>
                                </form>
                            @else
                                <div class="text-center my-2 fw-bold greendark">Pengingat Telah Diatur</div>
                            @endif
                        </div>
                    @elseif($lelang->status_lelang == 1)
                        @if ($penawaran->isEmpty())
                            <div class="col-8 col-md-6 col-lg-3 ms-0 ">
                                <div class='h4 fw-bold'>Penawaran Teratas</div>
                                <div class="card card-w-md border-secondary my-2">
                                    <div class="card-body">
                                        <div class="text-center  ">
                                            <div class="h5 fw-bold">Belum ada penawaran </div>
                                            <div>Jadilah yang pertama melakukan penawaran ! </div>
                                        </div>
                                    </div>
                                </div>
                                <div class='h5 fw-bold'>Penawaran Teratas Anda</div>
                                <div class="card card-w-md border-secondary my-2">
                                    <div class="card-body">
                                        <div class="text-center  ">
                                            <div class="h4 fw-bold">Belum ada penawaran </div>
                                            <div>Anda Belum Melakukan Penawaran Apapun</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card rounded-3 card-w-md p-3 border-secondary my-2 p-3">
                                    <div class="d-flex">
                                        <span class="h5 fw-bold">Buat Penawaran Baru</span>
                                    </div>

                                    <form action="{{ route('lelang.penawaran', ['id' => $lelang->id]) }}" method="POST">
                                        @csrf
                                        <div class="d-flex justify-content-start ">
                                            <div class="input-group d-flex justify-content-center my-3">
                                                <input type="button" id="btn-minus-lelang"
                                                    value="- {{ 'Rp.' . number_format($lelang->kelipatan) }}"
                                                    class="button-minus btn fw-bold btn-greenlight btn-sm icon-shape"
                                                    data-field="quantity">
                                                <input type="number" id="qty-lelang"
                                                    min="{{ $lelang->harga_lelang_process + $lelang->kelipatan }}" readonly
                                                    value="{{ $lelang->harga_lelang_process + $lelang->kelipatan }}"
                                                    name="qty_lelang" class="quantity-field border text-center"
                                                    style="width: 40%;">
                                                <input type="button" id="btn-plus-lelang"
                                                    value="+ {{ 'Rp.' . number_format($lelang->kelipatan) }}"
                                                    class="button-plus btn fw-bold btn-greenlight btn-sm "
                                                    data-field="quantity">
                                            </div>
                                        </div>
                                        <div>
                                            <div class="d-grid"> <button type="submit" class="btn btn-outline-greenlight">
                                                    <div class="greendark fw-bold">
                                                        Buat Penawaran
                                                    </div>
                                                </button></div>
                                        </div>
                                    </form>
                                </div>
                                <div>
                                    <div class="card rounded-3 card-w-md p-3 border-secondary my-2 p-3">
                                        <h5 class="fw-bold " >Rule Lelang</h5>
                                        <span class="fs-6">1. Pelelang <b> tidak dapat</b> melakukan penawaran dibawah harga tertinggi</span>
                                        <span class="fs-6">2. <b>Penawar Pertama harus menawar diatas</b> harga mulai</span>
                                        <span class="fs-6">3. <b>Pemenang wajib untuk menyelesaikan pesanan</b>, Jika tidak maka akan dibanned pada kegiatan lelang selanjutnya</span>
                                        <span class="fs-6">4. Jika Pemenang Pertama <b> membatalkan tawaran</b>, maka pemenang kedua otomatis akan menang</span>
                                        <span class="fs-6">5. Halaman akan <b> Refresh 3 detik </b> secara otomatis , pastikan mengecek dahulu sebelum melakukan penawaran</span>
                                    </div>
                                </div>
                            @else
                                <div class="col-8 col-md-6 col-lg-4">
                                    <div class='h4 fw-bold'>Penawaran Teratas</div>
                                    <div class="card card-w-md border-secondary my-2">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between fw-bold ">
                                                @php
                                                    $userId = auth()->id();
                                                    // $penawaranTertinggiUser = App\Models\PenawaranLelang::where('id_user',$userId)->max('penawaran_harga');
                                                    // $penawaranUser = App\Models\PenawaranLelang::where('id_user',$userId)->where('penawaran_harga', $penawaranTertinggiUser)->first();
                                                    $penawaranUser = $penawaran->where('id_user', $userId);
                                                    $penawaranTertinggiUser = $penawaranUser->max('penawaran_harga');
                                                    $sortedPenawaran = $penawaran->sortByDesc('penawaran_harga');

                                                    $penawaranTertinggi = collect($penawaran)->max('penawaran_harga');
                                                    $dataTertinggi = $penawaran->where('penawaran_harga', $penawaranTertinggi)->first();
                                                    $dataTertinggiUser = $penawaranUser->sortByDesc('penawaran_harga')->first();
                                                    // dd($dataTertinggiUser);
                                                    $rankAll = $sortedPenawaran->pluck('penawaran_harga')->search($penawaranTertinggi);
                                                    $rank = $sortedPenawaran->pluck('id_user')->search($userId);
                                                    $penawaranTotal = count($penawaran);
                                                @endphp
                                                <div class="row">
                                                    <div class="col-2">
                                                        <div class="d-grid text-center">
                                                            <span class="fw-bold">Rank</span>
                                                            <span>{{ $rankAll + 1 }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-10 d-flex align-items-center ">
                                                        <a
                                                            class="h4 fw-bold text-decoration-none   my-auto " id="penawaranTertinggiMax">{{ 'Rp.' . number_format($penawaranTertinggi) }}</a>
                                                        <a style="font-size: 90%;"
                                                            class="text-decoration-none text-secondary my-auto ms-5">{{ time_elapsed_string($dataTertinggi->created_at) }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card card-w-md border-light  my-2">
                                        <div class="col text-center mb-3">
                                            <a class="text-decoration-none h6 text-secondary fw-bold my-auto">{{ $penawaranTotal }}
                                                Kali
                                                Ditawar</a>
                                        </div>
                                    </div>
                                    <div class='h5 fw-bold '>Penawaran Teratas Anda</div>
                                    @if ($penawaranUser->isNotEmpty())
                                        <div class="card card-w-md border-secondary fw-bold">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-2">
                                                        <div class="d-grid text-center">
                                                            <span class="">Rank</span>
                                                            <span>{{ $rank + 1 }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-10 d-flex align-items-center">
                                                        <a
                                                            class="h4 fw-bold text-decoration-none   my-auto ">{{ 'Rp.' . number_format($dataTertinggiUser->penawaran_harga) }}</a>
                                                        <a style="font-size: 90%;"
                                                            class="text-decoration-none text-secondary my-auto ms-5">{{ time_elapsed_string($dataTertinggiUser->created_at) }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    @else
                                        <div class="card card-w-md border-secondary my-2">
                                            <div class="card-body">
                                                <div class="text-center  ">
                                                    <div class="h4 fw-bold">Belum ada penawaran</div>
                                                    <div>Anda Belum Melakukan Penawaran Apapun</div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    @endif
                                    <div class="card rounded-3 card-w-md p-3 border-secondary my-2 p-3">
                                        <div class="d-flex">
                                            <span class="h5 fw-bold">Buat Penawaran Baru</span>
                                        </div>
                                        <form action="{{ route('lelang.penawaran', ['id' => $lelang->id]) }}"
                                            method="POST">
                                            @csrf
                                            <div class="d-flex justify-content-start ">
                                                <div class="input-group d-flex justify-content-center my-3">
                                                    <input type="button" id="btn-minus-lelang"
                                                        value="- {{ 'Rp.' . number_format($lelang->kelipatan) }}"
                                                        style="color:#598420 ;"
                                                        class="button-minus btn fw-bold btn-outline-greenlight btn-sm icon-shape"
                                                        data-field="quantity">
                                                    <input type="number" id="qty-lelang"
                                                        min="{{ $lelang->harga_lelang_process + $lelang->kelipatan }}"
                                                        readonly
                                                        value="{{ $lelang->harga_lelang_process + $lelang->kelipatan }}"
                                                        name="qty_lelang" class="quantity-field border text-center"
                                                        style="width: 40%;">
                                                    <input type="button" id="btn-plus-lelang" style="color:#598420 ;"
                                                        value="+ {{ 'Rp.' . number_format($lelang->kelipatan) }}"
                                                        class="button-plus fw-bold btn btn-outline-greenlight btn-sm "
                                                        data-field="quantity">
                                                </div>
                                            </div>
                                            <div>
                                                <div class="d-grid"> <button type="submit" class="btn btn-greenlight ">
                                                        <div class="fw-bold greendark">
                                                            Buat Penawaran
                                                        </div>
                                                    </button></div>
                                            </div>
                                        </form>
                                    </div>
                                    <div>
                                        <div class="card rounded-3 card-w-md p-3 border-secondary my-2 p-3">
                                            <h5 class="fw-bold " >Rule Lelang</h5>
                                            <span class="fs-6">1. Pelelang <b> tidak dapat</b> melakukan penawaran dibawah harga tertinggi</span>
                                            <span class="fs-6">2. <b>Penawar Pertama harus menawar diatas</b> harga mulai</span>
                                            <span class="fs-6">3. <b>Pemenang wajib untuk menyelesaikan pesanan</b>, Jika tidak maka akan dibanned pada kegiatan lelang selanjutnya</span>
                                            <span class="fs-6">4. Jika Pemenang Pertama <b> membatalkan tawaran</b>, maka pemenang kedua otomatis akan menang</span>
                                            <span class="fs-6">5. Halaman akan <b> Refresh 3 detik </b> secara otomatis , pastikan mengecek dahulu sebelum melakukan penawaran</span>
                                        </div>
                                    </div>
                        @endif
                    @else
                        @php
                            $penawaranTertinggi = $penawaran->where('status_tawaran', 1)->max('penawaran_harga');
                            $penawaranUser = $penawaran->where('id_user', auth()->id());
                            $penawaranUserId = $penawaran
                                ->where('status_tawaran', 1)
                                ->where('penawaran_harga', $penawaranUser->max('penawaran_harga'))
                                ->first();
                        @endphp
                        @if ($penawaranUser->isNotEmpty())
                            @if ($penawaranUser->max('penawaran_harga') == $penawaranTertinggi)
                                @if ($penawaranUserId->status_konfirmasi == 1)
                                    <div class="col-8 col-md-6 col-lg-4 ms-0 ">

                                        <div class="card rounded-3 card-w-md p-4 gap-1 border-secondary">

                                            <div class="text-center fw-bold h5">Selamat ! Anda
                                                Berhasil Memenangkan Lelang
                                            </div>
                                            <div class="text-center">Penawaran Telah Dikonfirmasi , Segera Selesaikan
                                                Pembayaran Pada Menu Riwayat
                                                Terima Kasih </div>

                                        </div>
                                    @else
                                        <div class="col-8 col-md-6 col-lg-4 ms-0 ">

                                            <div class="card rounded-3 card-w-md p-4 gap-1 border-secondary">

                                                <div class="text-center fw-bold h5">Selamat ! Anda
                                                    Berhasil Memenangkan Lelang
                                                </div>
                                                <div class="text-center">Konfirmasi Penawaran Anda Sebelum
                                                    {{ toIndoDate($lelang->tanggal_konfirmasi_lelang) }} WIB.</div>
                                                <div class="my-2 h6 fw-bold">
                                                    Total Harga:
                                                    {{ 'Rp.' . number_format($penawaranUser->max('penawaran_harga')) }}
                                                </div>
                                                <div class="d-grid">
                                                    <form method="POST" class="d-grid"
                                                        action="{{ route('lelang.confirm', ['id' => $penawaranUserId->id, 'id_lelang' => $penawaranUserId->id_produk_lelang]) }}">
                                                        @csrf
                                                        <button type="submit" class="btn btn-greenlight  my-1">
                                                            <div class="greendark fw-bold">
                                                                Konfirmasi
                                                                Penawaran
                                                            </div>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                @endif
                            @else
                                <div class="col-8 col-md-6 col-lg-4 ms-0 ">
                                    <div class='h3 fw-bold'>Penawaran Teratas</div>
                                    <div class="card card-w-md border-secondary ">
                                        <button class="btn " data-bs-toggle="modal"
                                            data-bs-target="#modal-list-lelang">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between fw-bold">
                                                    @php

                                                        $penawaranTertinggiMax = collect($penawaran)->max('penawaran_harga');
                                                        $dataTertinggi = $penawaran->where('penawaran_harga', $penawaranTertinggiMax)->first();
                                                        $penawaranTertinggi = collect($penawaran->where('status_tawaran', 1))->max('penawaran_harga');
                                                        $penawaranTotal = count($penawaran);
                                                        $sortedPenawaran = $penawaran->sortByDesc('penawaran_harga');
                                                        $dataTertinggiUser = $penawaranUser->sortByDesc('penawaran_harga')->first();
                                                        $rankAll = $sortedPenawaran->pluck('penawaran_harga')->search($penawaranTertinggiMax);
                                                    @endphp
                                                    <div class="row">
                                                        <div class="col-2">
                                                            <div class="d-grid text-center">
                                                                <span class="fw-bold">Rank</span>
                                                                <span>{{ $rankAll + 1 }}</span>
                                                            </div>
                                                        </div>
                                                        <div class="col-10 d-flex align-items-center ">
                                                            <a class="h4 fw-bold text-decoration-none   my-auto "
                                                                id="penawaranTertinggiMax">{{ 'Rp.' . number_format($penawaranTertinggiMax) }}</a>
                                                            <a style="font-size: 90%;"
                                                                class="text-decoration-none text-secondary my-auto ms-5">{{ time_elapsed_string($dataTertinggi->created_at) }}
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </button>
                                    </div>
                                    <div class="card card-w-md border-light  my-2">
                                        <div class="col text-center mb-3">
                                            <a class="text-decoration-none h6 text-secondary fw-bold my-auto">{{ $penawaranTotal }}
                                                Kali
                                                Ditawar</a>
                                        </div>
                                        <div class='h5 fw-bold'>Penawaran Teratas Anda</div>
                                        @php
                                            $userId = auth()->id();
                                            // $penawaranTertinggiUser = App\Models\PenawaranLelang::where('id_user',$userId)->max('penawaran_harga');
                                            // $penawaranUser = App\Models\PenawaranLelang::where('id_user',$userId)->where('penawaran_harga', $penawaranTertinggiUser)->first();

                                            $penawaranUser = $penawaran->where('id_user', $userId);
                                            $penawaranTertinggiUser = $penawaranUser->max('penawaran_harga');
                                            $sortedPenawaran = $penawaran->sortByDesc('penawaran_harga');

                                            $rank = $sortedPenawaran->pluck('id_user')->search($userId);
                                        @endphp

                                        <div class="card card-w-md border-secondary mb-3">

                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-2">
                                                        <div class="d-grid text-center">
                                                            <span class="">Rank</span>
                                                            <span>{{ $rank + 1 }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-10 d-flex align-items-center">
                                                        <a
                                                            class="h4 fw-bold text-decoration-none   my-auto ">{{ 'Rp.' . number_format($dataTertinggiUser->penawaran_harga) }}</a>
                                                        <a style="font-size: 90%;"
                                                            class="text-decoration-none text-secondary my-auto ms-5">{{ time_elapsed_string($dataTertinggiUser->created_at) }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                            @endif
                        @else
                            <div class="col-8 col-md-6 col-lg-4 ms-0 ">
                                <div class="card card-w-md border-secondary my-2">
                                    <button class="btn " data-bs-toggle="modal" data-bs-target="#modal-list-lelang">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between fw-bold ">
                                                @php
                                                    $sortedPenawaran = $penawaran->sortByDesc('penawaran_harga');
                                                    $penawaranTertinggi = collect($penawaran)->max('penawaran_harga');
                                                    $penawaranTotal = count($penawaran);
                                                    $rankAll = $sortedPenawaran->pluck('penawaran_harga')->search($penawaranTertinggi);
                                                @endphp
                                                <a
                                                    class="h4 text-decoration-none  my-auto ">{{ 'Rp.' . number_format($penawaranTertinggi) }}</a>
                                                <a class="text-decoration-none text-dark my-auto">{{ $penawaranTotal }}
                                                    Kali
                                                    Ditawar</a>

                                            </div>
                                        </div>
                                    </button>
                                </div>
                                <div class="card card-w-md border-light  my-2">
                                    <div class="col text-center mb-3">
                                        <a class="text-decoration-none h6 text-secondary fw-bold my-auto">{{ $penawaranTotal }}
                                            Kali
                                            Ditawar</a>
                                    </div>
                                </div>
                        @endif
                @endif
            @else
                <div class="col-8 col-md-6 col-lg-4 ms-0 ">
                    <div class="card rounded-3 card-w-md p-4 gap-1 border-secondary">
                        <div class="text-center fw-bold h5">Anda Tidak dapat mengikuti Pelelangan</div>
                        <div class="text-center"> Anda Dilarang Mengikuti Pelelangan Karena Pernah Membatalkan Riwayat
                            Penawaran </div>
                    </div>
            @endif
        </div>
    </div>
    </div>
    <div class="modal modal-lg fade" id="modal-list-lelang" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">List Penawaran</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <table class="table table-bordered text-center">
                        <thead>
                            <tr>
                                <th scope="col">Rank</th>
                                <th scope="col">Username</th>
                                <th scope="col">Penawaran</th>
                                <th scope="col">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $rank = 0;
                                $penawaranEnd = $penawaran->sortByDesc('penawaran_harga');

                            @endphp
                            @foreach ($penawaranEnd as $penawarans)
                                @if ($penawarans->status_tawaran == 1)
                                    <tr class="table">
                                        <th scope="row">{{ ++$rank }}</th>
                                        <td>{{ $penawarans->user->username }}</td>
                                        <td>{{ 'Rp.' . number_format($penawarans->penawaran_harga) }}</td>
                                        <td>{{ toIndoDate($penawarans->created_at) }}</td>
                                    </tr>
                                @elseif($penawarans->status_tawaran == 0)
                                    <tr class="table-danger">
                                        <th scope="row">{{ ++$rank }}</th>
                                        <td>{{ $penawarans->user->username }}</td>
                                        <td>{{ 'Rp.' . number_format($penawarans->penawaran_harga) }}</td>
                                        <td>{{ toIndoDate($penawarans->created_at) }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        aria-label="Close">Close</button>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="modal fade " id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog  ">
            <div class="modal-content border border-danger">
                <div class="modal-header ">
                    <h5 class="modal-title text-danger " id="errorModalLabel">No Telepon Anda Kosong</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="errorMessage">Silahkan isi nomor telepon pada menu akun terlebih dahulu untuk melanjutkan.</p>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

{{-- <div class="modal fade" id="modal-lelang" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Buat Penawaran</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="">
                                    <div class="input-group d-flex justify-content-center my-3">
                                        <input type="button" id="btn-minus-lelang" value="- Rp.10000"
                                            class="button-minus border  icon-shape" data-field="quantity">
                                        <input type="number" id="qty-lelang" step="10000" value="0"
                                            name="qty-lelang" class="quantity-field border-0 text-center"
                                            style="width: 100px;">
                                        <input type="button" id="btn-plus-lelang" value="+ Rp.10000"
                                            class="button-plus border " data-field="quantity">
                                    </div>
                                </div>
                            </div> --}}


<script type="module">
    // window.onload = function() {
    //     var myModal = new bootstrap.Modal(document.getElementById('modal-list-lelang'));
    //     myModal.show();
    // };
    document.addEventListener('DOMContentLoaded', function() {
        @if (session()->has('error'))
            var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
            errorModal.show();
        @endif

        // setInterval(() => {
        //     fetch("http://127.0.0.1:8000/detail/{{ $lelang->id }}/api").then(async res => {
        //         let data = await res.json()
        //         const formattedPrice = data.penawaranTertinggiMax.toLocaleString('id', { style: 'currency', currency: 'IDR' });
        //         document.getElementById("penawaranTertinggiMax").innerText = formattedPrice
        //     })
        // }, 2000);
        setInterval(() => {
            window.location.reload();
        }, 3000);
    });

    let qty_lelang = document.getElementById('qty-lelang')
    let btn_minus_lelang = document.getElementById('btn-minus-lelang')
    let btn_plus_lelang = document.getElementById('btn-plus-lelang')
    if (btn_minus_lelang && btn_plus_lelang && qty_lelang) {
        btn_minus_lelang.addEventListener('click', reduce_qty)
        btn_plus_lelang.addEventListener('click', add_qty)

        function reduce_qty() {
            let qty = qty_lelang.value
            if (qty.trim() == "") {
                qty = {{ $lelang->harga_lelang_process + $lelang->kelipatan }}
            }

            if (qty > {{ $lelang->kelipatan + $lelang->harga_lelang_process }} && qty != qty_lelang.min) {
                qty_lelang.value = qty - {{ $lelang->kelipatan }}
            } else {
                qty_lelang.value = {{ $lelang->harga_lelang_process + $lelang->kelipatan }}
            }
        }

        function add_qty() {
            let qty = qty_lelang.value
            if (qty.trim() == "") {
                qty = {{ $lelang->kelipatan }}
            }
            qty_lelang.value = parseInt(qty) + {{ $lelang->kelipatan }}
        }
    }
</script>
