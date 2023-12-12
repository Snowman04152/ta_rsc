@extends('admin.layouts.app')
@section('content')
    <div class="col py-3 pe-5">
        <div class="h5 p-2 ">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb fw-bold">
                    <li class="breadcrumb-item "><a class="text-decoration-none text-dark"
                            href="{{ route('lelang.index') }}"><i class="bi bi-chevron-left"></i> Lelang</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Add Lelang</li>
                </ol>
            </nav>
        </div>
        <div class="row my-2">
            <div class="col-md-2 fw-bold"><span>
                    <img src="{{ asset('storage/files/' . $lelang->encrypted_filename) }}" alt="sss"
                        class="image-fluid w-100 ">
                </span> </div>
            <div class="col-md-6 ">
                <span class="h3 fw-bold">{{ $lelang->nama_produk_lelang }}</span>
                <div class="row">
                    <div class="col"><span class="fw-bold "> Penawaran Mulai : </span><span
                            class="p-2">{{ 'Rp' . '.' . number_format($lelang->harga_lelang) }}</span></div>
                </div>
                <div class="col"><span class="fw-bold">Waktu Mulai : </span><span
                        class="p-2">{{ toIndoDate($lelang->tanggal_mulai_lelang) }} WIB</span></div>
                <div class="col"><span class="fw-bold">Waktu Berakhir : </span><span
                        class="p-2">{{ toIndoDate($lelang->tanggal_selesai_lelang) }} WIB</span></div>
                @if ($lelang->status_lelang === 0)
                    <div class="col"><span class="fw-bold">Status : </span><span class="p-2">Belum Dimulai</span>
                    </div>
                    <form action="{{ route('lelang.start', ['id' => $lelang->id]) }}" method="POST">
                        @csrf
                        <button type='submit' class="btn btn-greenlight fw-bold my-2 " style="color:#598420 ;">Mulai
                            Lelang</button>
                    </form>
                @elseif($lelang->status_lelang === 1)
                    <div class="col"><span>Status : </span><span class="p-2">Berjalan</span></div>
                    <form action="{{ route('lelang.end', ['id' => $lelang->id]) }}" method="POST">
                        @csrf
                        <button type='submit' class="btn btn-greenlight fw-bold my-2 " style="color:#598420 ;">Tutup
                            Pelelangan</button>
                    </form>
                @else
                    <div class="col"><span>Status : </span><span class="p-2">Selesai</span></div>
                @endif
            </div>
        </div>
        <div class="h4 fw-bold mt-4">Spesifikasi </div>
        <div class="text">Umur Simpan</div>
        <div class="text">{{ $lelang->umur_simpan }}</div>
        <div class="h5 mt-3  fw-bold "><span>Deskripsi</span></div>
        <div class="mt-0">{{ $lelang->deskripsi }}</div>

        @if ($lelang->status_lelang === 0)
            <div class="row my-4">
                <div class="col-xl-0 fw-bold"><span class='fw-bold'>List Pengingat User </span><span class="">(
                        {{ count($pengingat) }} Pengingat)</span>
                    <table class="mt-2 table table-striped">
                        <thead>
                            <tr class='table-greenlight table-border-td '>
                                <th scope="col">No</th>
                                <th scope="col">Username</th>
                                <th scope="col">No Telp</th>
                                <th scope="col">Opsi</th>

                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 0;
                            @endphp
                            @foreach ($pengingat as $pengingats)
                                <tr>
                                    <th scope="row">{{ ++$no }}</th>
                                    <td>{{ $pengingats->user->username }}</td>
                                    <td>{{ $pengingats->user->telp_user }}</td>
                                    @php

                                        if (substr($pengingats->user->telp_user, 0, 1) === '0') {
                                            $telp_user = '62' . substr($pengingats->user->telp_user, 1);
                                        } elseif (substr($pengingats->user->telp_user, 0, 1) === '+') {
                                            $telp_user = substr($pengingats->user->telp_user, 1);
                                        }

                                    @endphp
                                    <td><a class="btn btn-outline-success btn-sm"
                                        href="https://api.whatsapp.com/send?phone={{ $telp_user }}&text=Selamat Anda Telah Menang Lelang">Hubungi
                                        Pelanggan </a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @elseif($lelang->status_lelang === 1)
            <div class="row my-4">
                <div class="col-xl-0 fw-bold"><span class='fw-bold'>Penawaran </span><span
                        class="">({{ count($penawaran) }} Kali
                        Ditawar)</span>
                    <table class="mt-2 table text-center  table-bordered">
                        <thead>
                            <tr class="table-greenlight table-border-td ">
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
                                <tr>
                                    <th scope="row">{{ ++$rank }}</th>
                                    <td>{{ $penawarans->user->username }}</td>
                                    <td>{{ 'Rp.' . number_format($penawarans->penawaran_harga) }}</td>
                                    <td>{{ toIndoDate($penawarans->created_at) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="row my-4">
                <div class="col-xl-0 fw-bold"><span class='fw-bold'>Penawaran </span><span
                        class="">({{ count($penawaran) }} Kali
                        Ditawar)</span>
                    <table class="mt-2 table text-center  table-bordered">
                        <thead>
                            <tr class="table-greenlight table-border-td">
                                <th scope="col">Rank</th>
                                <th scope="col">Username</th>
                                <th scope="col">Penawaran</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Opsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $rank = 0;
                                $penawaranEnd = $penawaran->sortByDesc('penawaran_harga');

                            @endphp
                            @foreach ($penawaranEnd as $penawarans)
                                <tr>
                                    <th scope="row">{{ ++$rank }}</th>
                                    <td>{{ $penawarans->user->username }}</td>
                                    <td>{{ 'Rp.' . number_format($penawarans->penawaran_harga) }}</td>
                                    <td>{{ toIndoDate($penawarans->created_at) }}</td>
                                    @php

                                        if (substr($penawarans->user->telp_user, 0, 1) === '0') {
                                            $telp_user = '62' . substr($penawarans->user->telp_user, 1);
                                        } elseif (substr($penawarans->user->telp_user, 0, 1) === '+') {
                                            $telp_user = substr($penawarans->user->telp_user, 1);
                                        }

                                    @endphp
                                    @if ($rank == 1)
                                        <td><a class="btn btn-outline-success btn-sm"
                                                href="https://api.whatsapp.com/send?phone={{ $telp_user }}&text=Selamat Anda Telah Menang Lelang">Hubungi
                                                Pelanggan </a></td>
                                    @else
                                    <td></td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
    @endif

    {{-- <div class="modal fade" id="modal-add-varian" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="h4 text-center">Tambah Varian</div>
                <div class="my-4">
                    <div class="fw-bold"><span>Nama Produk</span>
                        <input type="email" class="form-control my-2" placeholder="Isi Nama Produk">
                    </div>
                    <div class=" fw-bold"><span>Umur Simpan</span>
                        <input type="email" class="form-control my-2" placeholder="Isi Umur Simpan">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div> --}}
    </div>
@endsection
