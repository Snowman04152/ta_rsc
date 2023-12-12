@extends('admin.layouts.app')
@section('content')
    <div class="col py-3 pe-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb  fw-bold">
                <li class="breadcrumb-item h6 fw-bold "><a class="text-decoration-none text-dark"
                        href="{{ route('customer.index') }}"><i class="bi bi-chevron-left"></i> Customer</a></li>
                <li class="breadcrumb-item h6  active" aria-current="page">Detail Customer</li>
            </ol>
        </nav>
        {{-- <div class="d-flex justify-content-end ">
            <div class=" my-2 "><a class="btn btn-secondary" href="">Riwayat Transaksi</a></div>
        </div> --}}
        <div class="card  p-3">
            <div class="row">
                <div class="col-12 col-md-4 col-lg-3">
                    <img src="{{ asset('storage/files/' . $user->encrypted_filename) }}" class="img-fluid w-75">
                </div>
                <div class="col-12 col-md-8 col-lg-8">
                    <table class="table table-sm ">
                        <tbody>
                            <tr>
                                <th>Nama Lengkap </th>
                                <th>:</th>
                                <th>{{ $user->nama_lengkap }}</th>
                            </tr>
                            <tr>
                                <th>Username </th>
                                <th>:</th>
                                <th>{{ $user->username }} </th>
                            </tr>
                            <tr>
                                <th>Jenis Kelamin</th>
                                <th>:</th>
                                @if ($user->jenis_kelamin === 1)
                                    <th>Laki Laki</th>
                                @elseif($user->jenis_kelamin === 0)
                                    <th>Perempuan</th>
                                @else
                                    <th></th>
                                @endif
                            </tr>
                            <tr>
                                <th>Tanggal Lahir</th>
                                <th>:</th>
                                <th>{{ $user->tanggal_lahir }}</th>
                            </tr>
                            <tr>
                                <th>No Telepon</th>
                                <th>:</th>
                                <th>{{ $user->telp_user }}</th>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <th>:</th>
                                <th>{{ $user->email }}</th>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-between my-2">
            <div class="h5  fw-bold ">Daftar Alamat</div>
        </div>
        @foreach ($user->alamat as $alamats)
                    <div class="card mb-2 p-3">
                        <div class="d-flex justify-content-between">
                            <div class="text-start btn-w">
                                <div>
                                    <i class="bi bi-map"></i>
                                    <a> Alamat {{ $alamats->label }}</a>
                                </div>
                                <div>
                                    <span class='fw-bold'> {{ $alamats->penerima }} </span>
                                </div>
                                <div>
                                    <span>{{ $alamats->telepon }}</span>
                                </div>
                                <div>
                                    <span>{{ $alamats->nama_jalan }},</span>
                                    <span>Kecamatan {{ ucwords(strtolower($alamats->kecamatan)) }},
                                        {{ ucwords(strtolower($alamats->kabupaten)) }},</span>
                                    <span>{{ ucwords(strtolower($alamats->provinsi)) }},</span>
                                    <span>{{ $alamats->kode_pos }}</span>
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>
                @endforeach
    </div>
@endsection
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
