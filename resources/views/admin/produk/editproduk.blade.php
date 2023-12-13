@extends('admin.layouts.app')
@section('content')
    <div class="col py-3 pe-5">
        <div class="h5 p-2 "><a>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb fw-bold">
                        <li class="breadcrumb-item "><a class="text-decoration-none text-dark"
                                href="{{ route('produk.index') }}"><i class="bi bi-chevron-left"></i> Produk</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit Produk</li>
                    </ol>
                </nav>
                <form id="main-form" enctype="multipart/form-data" method="POST"
                    action="{{ route('produk.update', ['produk' => $produk->id]) }}">
                    <div class="row my-2">
                        @csrf
                        @method('put')
                        <div class="row">
                            <div class="col">
                                <div class="fw-bold"><span>Nama Produk</span>
                                    <input type="text" name='nama_produk' id='nama_produk' required
                                        class="form-control my-2 @error('nama_produk') is-invalid @enderror"
                                        value='{{ $errors->any() ? old('nama_produk') : $produk->nama_produk }}'
                                        placeholder="Isi Nama Produk">
                                    @error('nama_produk')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="fw-bold"><span>Umur Simpan</span>
                                    <input type="text" name='umur_simpan' id='umur_simpan' required
                                        class="form-control my-2 @error('umur_simpan') is-invalid @enderror"
                                        value='{{ $errors->any() ? old('umur_simpan') : $produk->umur_simpan }}'
                                        placeholder="Isi Umur Simpan">
                                    @error('umur_simpan')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="fw-bold"><span>Tanggal Pengambilan </span>
                                    <input type="date" name='tanggal_ambil' id='tanggal_ambil' required
                                        class="form-control my-2 @error('tanggal_ambil') is-invalid @enderror"
                                        value='{{ $errors->any() ? old('tanggal_ambil') : $produk->tanggal_pengambilan }}'
                                        placeholder="Isi Umur Simpan"> @error('tanggal_ambil')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="fw-bold"><span>Lokasi Pengambilan</span>
                                    <input type="text" name='lokasi_ambil' id='lokasi_ambil' required
                                        class="form-control my-2 @error('lokasi_ambil') is-invalid @enderror"
                                        value='{{ $errors->any() ? old('lokasi_ambil') : $produk->lokasi_pengambilan }}'placeholder="Isi Lokasi Pengambilan">
                                    @error('lokasi_ambil')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="fw-bold"><span>Status Produk</span>
                                    <select required name="status_produk" class="form-select my-2"
                                        aria-label="Default select example">
                                        <option value="1" <?php echo $produk->status == 1 ? 'selected' : ''; ?>>Aktif</option>
                                        <option value="0" <?php echo $produk->status == 0 ? 'selected' : ''; ?>>Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="fw-bold"><span>Pengiriman</span>
                                    <select required name='jenis_pengiriman' class="form-select my-2"
                                        aria-label="Default select example">
                                        <option value="0" <?php echo $produk->status_pengambilan == 0 ? 'selected' : ''; ?>>Hanya Bisa Ambil Ditempat</option>
                                        <option value="1" <?php echo $produk->status_pengambilan == 1 ? 'selected' : ''; ?>>Bisa Dikirim</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="formFile" class="form-label fw-bold">Edit Foto Produk</label>
                                <input class="form-control"
                                    value="{{ $errors->any() ? old('foto_produk') : $produk->original_filename }}"
                                    name='foto_produk' id='foto_produk' type="file" id="formFile">
                            </div>
                            <div class="col">
                                <div class="fw-bold"><span>Stok</span>
                                    <input type="number" name='stok' id='stok' required
                                        class="form-control my-2 @error('stok') is-invalid @enderror"
                                        value='{{ $errors->any() ? old('stok') : $produk->stok }}'placeholder="Isi Stok">
                                    @error('stok')
                                        <div class="text-danger"><small>{{ $message }}</small></div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <label for="formFile" class="form-label fw-bold">Foto Produk </label>
                        <div class="row">
                            <div class="col-5 mb-2"><img src="{{ asset('storage/files/' . $produk->encrypted_filename) }}"
                                    alt="test" class="image-fluid w-25 border border-dark-subtle rounded-3"></div>
                        </div>
                    </div>
                    <div class="form-label fw-bold my-2 "><span>Deskripsi Produk</span>
                        <div class="form-floating">
                            <textarea class="form-control my-2 @error('deskripsi') is-invalid @enderror" name='deskripsi' id='deskripsi' required
                                placeholder="Leave a comment here" id="floatingTextarea2" style="height: 175px">{{ $errors->any() ? old('deskripsi') : $produk->deskripsi }} </textarea>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-3"><a href="" class="btn btn-greenlight fw-bold"
                            style="color:#598420 ;" data-bs-toggle="modal" data-bs-target="#modal-add-varian"> Add Varian
                        </a></div>
                    <div class="input-group rounded">
                        <table class="mt-2 table table-striped">
                            <thead>
                                <tr style="color:#598420 ;" class='table-greenlight table-border-td'>
                                    <th scope="col">No</th>
                                    <th scope="col">Berat</th>
                                    <th scope="col">Harga</th>
                                    <th scope="col">Opsi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($varian as $varians)
                                    <tr>
                                        <td scope="row">PV-000{{ $loop->iteration }}</td>
                                        <td>{{ $varians->berat . ' Kg' }}</td>
                                        <td>{{ 'Rp' . '.' . number_format($varians->harga_produk) }}</td>

                                        <td>
                                            <form action=""></form>
                                            <div class="dropdown ">
                                                <i class='bi-three-dots btn ' data-bs-toggle="dropdown"
                                                    aria-expanded="false"></i>
                                                <ul class="dropdown-menu">
                                                    <li><button type="button" class="dropdown-item edit-varian"
                                                            data-varian_id="{{ $varians->id }}"
                                                            data-id_produk="{{ $varians->id_produk }}"
                                                            data-berat="{{ $varians->berat }}"
                                                            data-harga="{{ $varians->harga_produk }}">Edit</button></li>
                                                    {{-- <form id="nested-form"
                                                        action="{{ route('varian.destroy', ['id' => $varians->id, 'id_produk' => $varians->id_produk]) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('delete')
                                                        <li><button type="submit"
                                                                class="dropdown-item btn-delete">Delete</button>
                                                        </li>
                                                    </form> --}}
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <hr class="mt-3">
                    <div class="input-group rounded d-flex justify-content-between">
                        <div class="col-1 d-grid "><a href="{{ route('produk.index') }}"
                                class="btn btn-outline-greenlight fw-bold" style="color:#598420 ;">Kembali</a></div>
                        <div class="col-1 d-grid "><button form="main-form" type="submit"
                                class="btn btn-greenlight fw-bold" style="color:#598420 ;">Edit</button></div>
                    </div>
        </div>
        </form>
    </div>
    <div class="modal fade" id="modal-add-varian" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Varian</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="add-varian" action="{{ route('varian.store') }}">
                        @csrf
                        <div class="h4 text-center">Tambah Varian</div>
                        <div class="my-4">
                            <input type="number" class="form-control my-2" name='id_produk' id='id_produk'required
                                hidden placeholder="" value="{{ $produk->id }}">
                            <div class=" fw-bold"><span>Harga</span>
                                <input type="number" class="form-control my-2" name='harga_produk' id='harga_produk'
                                    required placeholder="Isi Harga Varian">
                            </div>
                            <div class=" fw-bold"><span>Berat</span>
                                <input type="number" step="0.1" class="form-control my-2" name='berat'
                                    id='berat' required placeholder="Isi Berat Varian">
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        aria-label="Close">Close</button>
                    <button type="submit" form="add-varian" class="btn btn-primary">Add</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edit-varian-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Varian</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- {{ route('varian.update', ['varian' => varianIdInput]) }} --}}
                    <form method="POST" action="" id="edit-varian-form">
                        @csrf
                        @method('put')
                        <div class="h4 text-center">Tambah Varian</div>
                        <div class="my-4">
                            <input type="hidden" name="varian_id" id="edit_varian_id">
                            <input type="number" class="form-control my-2" name='id_produk' id='edit_id_produk'required
                                hidden placeholder="" value="{{ $produk->id }}">
                            <div class=" fw-bold"><span>Harga</span>
                                <input type="number" class="form-control my-2" name='harga_produk'
                                    id='edit_harga_produk' required placeholder="Isi Harga Varian">
                            </div>
                            <div class=" fw-bold"><span>Berat</span>
                                <input type="number" step="0.1" class="form-control my-2" name='berat'
                                    id='edit_berat' required placeholder="Isi Berat Varian">
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>

                </form>
            </div>
        </div>
    </div>

    <script type="module">
        console.log(window.Swal)
    </script>
@endsection

<script type="module">
    document.addEventListener('click', function(event) {
        if (event.target.matches('.edit-varian')) {
            var varianId = event.target.dataset.varian_id;
            var berat = event.target.dataset.berat;
            var idProduk = event.target.dataset.id_produk;
            var harga = event.target.dataset.harga;

            var editVarianForm = document.getElementById('edit-varian-form');
            var varianIdInput = document.getElementById('edit_varian_id');
            var beratInput = document.getElementById('edit_berat');
            var idProdukInput = document.getElementById('edit_id_produk');
            var hargaInput = document.getElementById('edit_harga_produk');


            varianIdInput.value = varianId;
            idProdukInput.value = idProduk;
            beratInput.value = berat;
            hargaInput.value = harga;
            editVarianForm.action = '/varian/edit/' + varianId;


            var modal = document.getElementById('edit-varian-modal');
            var bootstrapModal = new bootstrap.Modal(modal);
            bootstrapModal.show();
        }
    });



    // function submitNestedForm() {
    //     var confirmation = confirm('Apakah Anda yakin ingin menghapus varian?');
    //     if (confirmation) {
    //         document.getElementById('nested-form').submit();
    //     }
    // }
</script>
</td>
{{-- 
<script type="module">
    $(document).on('click', '.edit-varian', function() {
           var varianId = $(this).data('varian-id');
           $.ajax({
               url: '/varian/edit/' + varianId,
               method: 'GET',
               success: function(response) {
                   $('#editVarianModal').html(response);
                   $('#editVarianModal').modal('show');
               }
           });
       });
   </script> --}}
