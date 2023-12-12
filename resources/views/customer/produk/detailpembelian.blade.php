@extends('customer.layouts.app')
@section('content')
    <div class="container p-3">
        <div class="h4 mt-2">
            < Pembelian / Detail</div>
                <a>Alamat Pengiriman</a>
                <div class="row">
                    <div class="col-12 col-md-7 col-lg-9">
                        <div class="">
                            <div class="card p-3">
                                <div class="text-start btn-w">
                                    <div>
                                        <i class="bi bi-map"></i>
                                        <a> Alamat Rumah</a>
                                    </div>
                                    <div>
                                        <span class='fw-bold'> Daniel Saputra </span>
                                    </div>
                                    <div>
                                        <span>+6286278394045</span>
                                        <span>></span>
                                    </div>
                                    <div>
                                        <span>Hasanuddin No. 9 RT-005/ RW-003 Kel. Kariangau,</span>
                                        <span>Kec. Balikpapan Barat Kota Balikpapan,</span>
                                        <span>Kalimantan Timur,</span>
                                        <span>61226</span>
                                    </div>
                                    </button>
                                </div>
                            </div>
                            <a> Opsi Pengiriman </a>
                            <div class="card p-3">
                                <div class="text-start p-4">
                                    <div class="d-flex justify-content-between">
                                        <span>JNE</span>
                                        <span>Rp.5000</span>
                                    </div>
                                </div>
                            </div>

                            <a> Daftar Produk </a>
                            <div class="card rounded-3 mb-2">
                                <div class="card-body">
                                    <div class="row g-4">
                                        <div class="col-12 col-md-3 col-lg-2 ">
                                            <img src="{{ Vite::asset('resources/images/ghost.png') }}" alt=".."
                                                class="img-fluid rounded img-w ">
                                        </div>
                                        <div class="col-12 col-md-9 col-lg-10">
                                            <div class="d-flex justify-content-between">
                                                <p class="h5 fw-bold">Melon Segar Super</p>
                                                <div class="btn btn-secondary" data-bs-toggle="modal"
                                                    data-bs-target='#modal-ulasan'>
                                                    Ulasan</div>

                                            </div>
                                            <div>
                                                <span>Varian : 2 Kg</span>
                                            </div>
                                            <div class="d-flex justify-content-between">
                                                <span>Rp.20000</span>
                                                <span>x2</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-3 col-lg-2 ">
                        <div class="card card-w ">
                            <div class="card-body">
                                <h5 class="card-title">Ringkasan </h5>
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th scope="row" class="w-75">Jumlah Barang : </th>
                                            <th>5</th>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="w-50">Total Harga Barang : </th>
                                            <th>50000</th>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="w-50">Ongkos Kirim : </th>
                                            <th>50000</th>
                                        </tr>
                                        <tr>
                                            <th scope="row" class="w-50">Total Harga: </th>
                                            <th>50000</th>
                                        </tr>
                                    </tbody>
                                </table>
                                <div>
                                    <div class="btn btn-secondary mt-3 d-grid"> Bayar </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    <div class="modal fade" id="modal-ulasan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Ulasan</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="fw-bold">
                            <label for="formFile" class="form-label fw-bold">Foto Produk</label>
                            <input class="form-control" type="file" id="formFile">
                            <span>Penilaian</span>
                            <input type="range" class="form-control my-2" placeholder="Isi Penilaian">
                            <span>Review Produk</span>
                            <input type="text" class="form-control my-2" placeholder="Isi Review">
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>
    {{-- <script type="module">
        const modalKurir = new bootstrap.Modal('#modal-ulasan', {
            keyboard: false
        })
        window.onload = modalKurir.show();
    </script> --}}
@endsection
