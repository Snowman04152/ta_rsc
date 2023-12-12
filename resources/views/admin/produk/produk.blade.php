@extends('admin.layouts.app')
@section('content')
    <div class="col py-3 pe-5">
        <div class="h4 p-2 "><b>Produk Reguler</b></div>
        <div class="input-group rounded">
            <input type="search" class="form-control border-greenlight rounded" placeholder="Search" aria-label="Search"
                aria-describedby="search-addon" />
            <span class="input-group-text border-0" id="search-addon">
                <i class="fas fa-search"></i>
            </span>
            <div class="dropdown">
                <button class="btn btn-greenlight fw-bold dropdown-toggle" style="color:#598420 ;" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    Semua Status
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                </ul>
            </div>
            <div class="mx-3">
                <div><a class="text-decoration-none btn btn-greenlight fw-bold" style="color:#598420 ;" href="{{ route('produk.create') }}">Add Produk </a>
                </div>
            </div>
        </div>
        <table class="mt-2 table table-striped">
            <thead>
                <tr class='table-greenlight table-border-td text-center'>
                    <th class="text-start" scope="col">No</th>
                    <th scope="col">Nama Produk</th>
                    <th scope="col">Umur Simpan</th>
                    <th scope="col">Varian</th>
                    <th scope="col">Status</th>
                    <th scope="col">Opsi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($produk as $produks)
                @php
                $variancheck = App\Models\Varian::where('id_produk', $produks->id)->exists();
                $variantotal = App\Models\Varian::where('id_produk', $produks->id)->count();
              
                @endphp
                    <tr class=" text-center">
                        <th class="text-start" scope="row">PR00{{ $loop->iteration }}</th>
                        <td>{{ $produks->nama_produk }}</td>
                        <td>{{ $produks->umur_simpan }}</td>
                        @if($variancheck)
                        <td class=" text-center"><span class="badge text-dark p-2" style="background-color: #c6ee92">{{ $variantotal }} Varian</span></td>
                        @else
                        <td ><span class="badge bg-danger text-light  p-2" >Belum Ada Varian</span></td>
                        @endif
                        @if($produks->status == 1 )
                        <td>Aktif</td>
                        @else
                        <td>Tidak Aktif</td>
                        @endif
                        <td>
                            <div class="dropdown">
                                <i class='bi-three-dots btn ' data-bs-toggle="dropdown" aria-expanded="false"></i>
                                <ul class="dropdown-menu">

                                    <li><a class="dropdown-item"
                                            href="{{ route('produk.edit', ['id' => $produks->id]) }}">Edit</a></li>
                                            <li><a class="dropdown-item"
                                                href="{{ route('produk.show', ['produk' => $produks->id]) }}">Detail</a></li>
                                    {{-- <form id="nested-form"
                                        action="{{ route('produk.destroy', ['produk' => $produks->id]) }}"
                                        method="POST">
                                        @csrf
                                        @method('delete')
                                        <li><button type="submit" class="dropdown-item" >Delete</button>
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
@endsection
