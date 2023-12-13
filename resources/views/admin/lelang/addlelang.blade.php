@extends('admin.layouts.app')
@section('content')
    <div class="col py-3 pe-5">
        <div class="h5 p-2 "><a>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb fw-bold">
                        <li class="breadcrumb-item "><a class="text-decoration-none text-dark"
                                href="{{ route('lelang.index') }}"><i class="bi bi-chevron-left"></i> Lelang</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add Lelang</li>
                    </ol>
                </nav>
                <form enctype="multipart/form-data" method="POST" action="{{ route('lelang.store') }}">
                    @csrf
                    <div class="row my-2">
                        <div class="row">
                            <div class="col-md-6 fw-bold"><span>Nama Produk Lelang</span>
                                <input type="text" name='nama_lelang' id='nama_lelang' class="form-control my-2" required
                                    placeholder="Isi Nama Produk Lelang">
                            </div>
                            <div class="col-md-6  fw-bold"><span>Umur Simpan</span>
                                <input type="text" name='umur_simpan' id='umur_simpan' class="form-control my-2" required
                                    placeholder="Isi Umur Simpan Lelang">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6  fw-bold"><span>Harga Mulai</span>
                                <input type="number" name='harga_mulai' id='harga_mulai' class="form-control my-2" required
                                    placeholder="Isi Harga Mulai">
                            </div>
                            <div class="col-md-6  fw-bold"><span>Kelipatan</span>
                                <input type="number" name='kelipatan' id='kelipatan' class="form-control my-2" required
                                    placeholder="Kelipatan">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 fw-bold"><span>Waktu Mulai</span>
                                <input type="datetime-local" name='time_start' id='time_start' class="form-control my-2"
                                    required placeholder="Isi Nama Produk">
                            </div>
                            <div class="col-md-6  fw-bold"><span>Waktu Selesai</span>
                                <input type="datetime-local" name='time_end' id='time_end' class="form-control my-2"
                                    required placeholder="Isi Umur Simpan">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="fw-bold"><span>Tanggal Konfirmasi</span>
                                    <input type="datetime-local" name='tanggal_konfirmasi' id='tanggal_konfirmasi' required
                                        class="form-control my-2" placeholder="Isi Umur Simpan">
                                </div>
                            </div>
                            <div class="col">
                                <div class="fw-bold"><span>Tanggal Pengambilan</span>
                                    <input type="datetime-local" name='tanggal_ambil' id='tanggal_ambil' required
                                        class="form-control my-2" placeholder="Isi Umur Simpan">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="fw-bold"><span>Berat</span>
                                    <input type="number" step="0.1" name='berat' id='berat' required class="form-control my-2"
                                        placeholder="Isi berat ">
                                </div>
                            </div>
                            <div class="col">
                                <div class="fw-bold"><span>Lokasi Pengambilan</span>
                                    <input type="text" name='lokasi_ambil' id='lokasi_ambil' required
                                        class="form-control my-2" placeholder="Isi Lokasi Pengambilan">
                                </div>
                            </div>
                            <div class="">
                                <label for="formFile" class="form-label fw-bold">Foto Produk Lelang</label>
                                <input class="form-control" type="file" required name='foto_lelang' id='foto_lelang'
                                    id="formFile">
                            </div>
                            <div class="h5 my-4  "><span class="fw-bold">Deskripsi Produk</span>
                                <div class="form-floating">
                                    <textarea class="form-control my-2" name='deskripsi' id='deskripsi' required placeholder="Leave a comment here"
                                        style="height: 175px"></textarea>
                                    <label for="floatingTextarea2">Isi Deskripsi Produk Lelang</label>
                                </div>

                                <hr class="mt-3">
                                <div class="input-group rounded d-flex justify-content-between">
                                    <div class="col-1 d-grid "><a href="{{ route('lelang.index') }}"
                                            class="btn btn-outline-greenlight fw-bold" style="color:#598420 ;">Cancel</a>
                                    </div>
                                    <div class="col-1 d-grid "><button type="submit" class="btn btn-greenlight fw-bold"
                                            style="color:#598420 ;">Add</button></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
        </div>
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
                        <input type="text" class="form-control my-2" placeholder="Isi Nama Produk">
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
