@extends('admin.layouts.app')
@section('content')
    <div class="col py-3 pe-5">
        <div class="h5 p-2 "><a>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb fw-bold">
                        <li class="breadcrumb-item "><a class="text-decoration-none text-dark"
                                href="{{ route('produk.index') }}"><i class="bi bi-chevron-left"></i> Produk</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Add Produk</li>
                    </ol>
                </nav>
                <div class="row ">
                    <form enctype="multipart/form-data" method="POST" action="{{ route('produk.store') }}">
                        @csrf
                        <div class="row my-2">
                            <div class="col">
                                <div class="fw-bold"><span>Nama Produk</span>
                                    <input type="text" name='nama_produk' id='nama_produk' required
                                        class="form-control my-2 " placeholder="Isi Nama Produk">
                                </div>
                            </div>
                            <div class="col">
                                <div class="fw-bold"><span>Umur Simpan</span>
                                    <input type="text" name='umur_simpan' id='umur_simpan' required
                                        class="form-control my-2" placeholder="Isi Umur Simpan">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="fw-bold"><span>Tanggal Pengambilan</span>
                                    <input type="date" name='tanggal_ambil' id='tanggal_ambil' required
                                        class="form-control my-2" placeholder="Isi Umur Simpan">
                                </div>
                            </div>
                            <div class="col">
                                <div class="fw-bold"><span>Lokasi Pengambilan</span>
                                    <input type="text" name='lokasi_ambil' id='lokasi_ambil' required
                                        class="form-control my-2" placeholder="Isi Lokasi Pengambilan">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="fw-bold"><span>Status Produk</span>
                                    <select required name="status_produk" class="form-select my-2"
                                        aria-label="Default select example">
                                        <option value="1">Aktif</option>
                                        <option value="0">Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="fw-bold"><span>Pengiriman</span>
                                    <select required name='jenis_pengiriman' class="form-select my-2"
                                        aria-label="Default select example">
                                        <option value="0">Hanya Bisa Ambil Ditempat</option>
                                        <option value="1">Bisa Dikirim</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="formFile" class="form-label fw-bold">Input Foto Produk</label>
                                <input class="form-control" name='foto_produk' id='foto_produk' required type="file"
                                    id="formFile">
                            </div>
                            <div class="col">
                                <div class="fw-bold"><span>Stok</span>
                                    <input type="number" name='stok' step='0.1' id='stok' required
                                        class="form-control my-2" placeholder="Isi Stok">
                                </div>
                            </div>
                        </div>

                </div>
        </div>
        <div class="h5 my-3 "><span class="fw-bold">Deskripsi Produk</span>
            <div class="form-floating">
                <textarea class="form-control my-2" name='deskripsi' id='deskripsi' required placeholder="Leave a comment here"
                    id="floatingTextarea2" style="height: 135px"></textarea>
                <label for="floatingTextarea2">Isi Deskripsi Produk</label>
            </div>
        </div>
        {{-- <div class="input-group rounded">
                <select class="form-select" aria-label="Default select example">
                    <option selected>Varian</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
                <div class="mx-3">
                    <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modal-add-varian">Tambah Varian</button>
                </div>
            </div> --}}
        <hr class="mt-3">
        <div class="input-group rounded d-flex justify-content-between">
            <div class="col-1 d-grid "><a href="{{ route('produk.index') }}" class="btn btn-outline-greenlight fw-bold"
                    style="color:#598420 ;">Cancel</a></div>
            <div class="col-1 d-grid "><button type="submit" class="btn btn-greenlight fw-bold"
                    style="color:#598420 ;">Tambah</button></div>
        </div>
    </div>
    </form>
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
                        <form method="POST" action="varian.store">
                            @csrf
                            <div class="fw-bold"><span>Stok</span>
                                <input type="number" class="form-control my-2" placeholder="Isi Stok">
                            </div>
                            <div class=" fw-bold"><span>Harga Produk</span>
                                <input type="number" class="form-control my-2" placeholder="Isi Harga">
                            </div>
                            <div class=" fw-bold"><span>Berat</span>
                                <input type="number" class="form-control my-2" placeholder="Isi Berat">
                            </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
            </div>
        </div>
    </div> --}}
@endsection

{{-- @section('custom-js')
<script type="module">
    // const modal = new bootstrap.Modal("#modal-add-varian")
</script> --}}
