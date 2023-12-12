@extends('admin.layouts.app')
@section('content')
    <div class="col py-3 pe-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb fw-bold mb-4">
                <li class="breadcrumb-item "><a class="h5 text-decoration-none text-dark"
                        href="{{ route('transaksi.index') }}"><i class="bi bi-chevron-left fw-bold"></i>Detail Pesanan</a>
                </li>
            </ol>
        </nav>
        <div class="fw-bold h6 my-3">Detail Transaksi</div>
        <div class="card rounded-4 me-5 fw-bold">
            <div class="row ms-3 mt-3">
                <div class="col-9 text-secondary">ID Transaksi</div>
                <div class="col-3">TR000{{ $transaksi->id }}</div>
            </div>
            <div class="row ms-3">
                <div class="col-9 text-secondary">Status</div>
                @if ($transaksi->status == 0)
                    <div class="col-3">Menunggu Pembayaran</div>
                @elseif($transaksi->status == 1)
                    <div class="col-3">Sedang di proses</div>
                @elseif($transaksi->status == 2)
                    @if ($transaksi->kurir == 'AMBIL_DITEMPAT')
                        <div class="col-3">Belum Diambil</div>
                    @else
                        <div class="col-3">Belum Diambil</div>
                    @endif
                @elseif($transaksi->status == 3)
                    <div class="col-3 ">Pesanan Sedang Dikirim</div>
                @elseif($transaksi->status == 4)
                    <div class="col-3 ">Selesai</div>
                @else
                    <div class="col-3 ">Dibatalkan</div>
                @endif
            </div>
            <div class="row ms-3">
                <div class="col-9 text-secondary">Tanggal Pembelian</div>
                <div class="col-3">{{ toIndoDate($transaksi->created_at) . ' WIB' }}</div>
            </div>
            @if ($transaksi->kurir == 'AMBIL_DITEMPAT')
                <div class="row ms-3 mb-3">
                    <div class="col-9 text-secondary">Metode Pembelian</div>
                    <div class="col-3">Reguler</div>
                </div>
            @else
                <div class="row ms-3 ">
                    <div class="col-9 text-secondary">Metode Pembelian</div>
                    <div class="col-3">Reguler</div>
                </div>
                <div class="row ms-3 mb-3">
                    <div class="col-9 text-secondary">Resi</div>
                    <div class="col-3">{{ $transaksi->resi }}</div>
                </div>
            @endif
        </div>
        <div class="fw-bold h6 my-3">Detail Pembeli</div>
        <div class="card rounded-4 me-5 fw-bold">
            <div class="row ms-3 mt-3">
                <div class="col-9 text-secondary">Nama</div>
                <div class="col-3">{{ $transaksi->user->nama_lengkap }}</div>
            </div>
            <div class="row ms-3 ">
                <div class="col-9 text-secondary">No Telepon</div>
                <div class="col-3">{{ $transaksi->user->telp_user }}</div>
            </div>
            <div class="row ms-3">
                <div class="col-9 text-secondary">Username</div>
                <div class="col-3">{{ $transaksi->user->username }}</div>
            </div>
            <div class="row ms-3 mb-3">
                <div class="col-9 text-secondary">Email</div>
                <div class="col-3">{{ $transaksi->user->email }}</div>
            </div>
        </div>
        <div class="fw-bold h6 my-3">Alamat Pengiriman</div>
        <div class="card rounded-4 me-5 p-3">
            <div class="row">
                <div class="col-11">

                    <div class="text-start p-2 btn-w">
                        <div>
                            <a> {{ $transaksi->alamat->label }} </a>
                        </div>
                        <div>
                            <span class='fw-bold'> {{ $transaksi->alamat->penerima }} </span>
                        </div>
                        <div>
                            <span>{{ $transaksi->alamat->telepon }}</span>
                            <span></span>
                        </div>
                        <div>
                            <span>{{ ucfirst($transaksi->alamat->nama_jalan) }},</span>
                            <span>{{ ucwords(strtolower('Kecamatan ' . $transaksi->alamat->kecamatan)) }},</span>
                            <span>{{ ucwords(strtolower($transaksi->alamat->kabupaten)) }},</span>
                            <span>{{ ucwords(strtolower($transaksi->alamat->provinsi)) }},</span>
                            <span>{{ $transaksi->alamat->kode_pos }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="fw-bold h6 my-3">Opsi Pengiriman</div>
        <div class="">
            @php
                $keranjang = App\Models\Keranjang::with('varian.produk')
                    ->where('id_transaksi', $transaksi->id)
                    ->get();
                $produk_first = $keranjang->first();
            @endphp
            <div class="card rounded-4 me-5">
                <div class="text-start p-4">
                    @if ($transaksi->kurir == 'AMBIL_DITEMPAT')
                        <div class="row">
                            <div class="col-11  ">
                                <div class="fw-bold">Ambil Ditempat</div>
                                <div>Ambil di {{ $produk_first->varian->produk->lokasi_pengambilan }} pada
                                    {{ toIndoDate($produk_first->varian->produk->tanggal_pengambilan) }}</div>
                            </div>
                            <div class="col d-grid align-items-center">Rp.0</div>
                        </div>
                    @else
                        <div class="row d-flex justify-content-between ">
                            <div class="col">
                                <div class="fw-bold">{{ $transaksi->kurir }}</div>
                            </div>
                            <div class="col align-items-center text-end">
                                Rp.{{ number_format($transaksi->harga_ongkir) }}</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="fw-bold h6 my-3">Daftar Produk</div>
        @foreach ($keranjang as $keranjangs)
            <div class="card rounded-4 me-5 mb-3">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-md-6 col-lg-1 ">
                            <img src="{{ asset('storage/files/' . $keranjangs->varian->produk->encrypted_filename) }}"
                                alt=".." class="img-fluid rounded w-100">
                        </div>
                        <div class="col-12 col-md-6 col-lg-11 ">
                            <div class="h5 fw-bold">{{ $keranjangs->varian->produk->nama_produk }}</div>

                            <div class="my-1">Varian: {{ $keranjangs->varian->berat . ' Kg' }}</div>

                            <div class="d-flex justify-content-between">
                                <h5 class=" fw-bold" style="color:#598420 ;">
                                    {{ 'Rp.' . number_format($keranjangs->varian->harga_produk) }}</h5>
                                <div>x{{ $keranjangs->jumlah_produk }} Barang </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="fw-bold h6 my-3">Detail Pembayaran</div>
        @php
            $TotalHarga = 0;
            foreach ($keranjang as $item) {
                $TotalHarga += $item->varian->harga_produk * $item->jumlah_produk ?? 0;
            }
        @endphp
        <div class="card rounded-4 me-5 fw-bold">
            <div class="row ms-3 mt-3">
                <div class="col-9 text-secondary">Total Harga Barang</div>
                <div class="col-3">{{ 'Rp.' . number_format($TotalHarga) }}</div>
            </div>
            <div class="row ms-3">
                <div class="col-9 text-secondary">Ongkos Kirim</div>
                <div class="col-3">Rp.{{ number_format($transaksi->harga_ongkir) }}</div>
            </div>
            <div class="row ms-3 mb-3">
                <div class="col-9 text-secondary">Total Harga</div>
                <div class="col-3">Rp.{{ number_format($transaksi->total_harga) }}</div>
            </div>
        </div>
        <div class=" my-4  me-5 ">
            @if ($transaksi->kurir == 'AMBIL_DITEMPAT')
                @if ($transaksi->status == 1 || $transaksi->status == 0)
                    <div class="d-flex gap-5 justify-content-between">
                        <a href="{{ route('cancel', ['id' => $transaksi->id]) }}"
                            class=" btn btn-outline-greenlight fw-bold w-50" style="color:#598420 ;" type="button">Batalkan
                            Pesanan</a>
                        <a href="{{ route('confirm', ['id' => $transaksi->id]) }}" class="btn btn-greenlight fw-bold  w-50"
                            style="color:#598420 ;" type="button">Konfirmasi</a>
                    </div>
                @elseif ($transaksi->status == 2)
                    <div class="d-flex gap-5 justify-content-between">
                        <a href="{{ route('end', ['id' => $transaksi->id]) }}"
                            class=" btn btn-outline-greenlight fw-bold w-50" style="color:#598420 ;" type="button">Telah
                            Diambil</a>
                        <a href="https://api.whatsapp.com/send?phone=62838393994&text=Admin" class="btn btn-greenlight fw-bold  w-50" style="color:#598420 ;"
                            type="button"><i class="bi bi-whatsapp">&nbsp</i> Hubungi Pelanggan</a>
                    </div>
                @else
                @endif
            @else
                @if ($transaksi->status == 1 || $transaksi->status == 0)
                    @if ($transaksi->resi == null)
                        <div class="d-flex gap-5 justify-content-between">
                            <a href="{{ route('cancel', ['id' => $transaksi->id]) }}"
                                class=" btn btn-outline-greenlight fw-bold w-50" style="color:#598420 ;"
                                type="button">Batalkan
                                Pesanan</a>
                            <button data-bs-toggle="modal" data-bs-target='#modal-resi'
                                class="btn btn-greenlight fw-bold  w-50" style="color:#598420 ;" type="button">Tambah
                                Resi</button>
                        </div>
                    @else
                    @endif
                @elseif($transaksi->status == 3)
                    <div class="d-flex gap-5 justify-content-between">
                        <a href="{{ route('end', ['id' => $transaksi->id]) }}"
                            class=" btn btn-outline-greenlight fw-bold w-50" style="color:#598420 ;" type="button">Telah
                            Diterima</a>
                        <a href="https://api.whatsapp.com/send?phone=62838393994&text=Admin" class="btn btn-greenlight fw-bold  w-50" style="color:#598420 ;"
                            type="button"><i class="bi bi-whatsapp">&nbsp</i> Hubungi Pelanggan</a>
                    </div>
                @else
                @endif
            @endif
        </div>
    </div>
    <div class="modal fade" id='modal-resi' tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title ">Tambah Resi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <form action="{{ route('addResi', ['id' => $transaksi->id]) }}" method="POST">
                            @csrf
                            <label class="my-2 h6 fw-bold" for="resi">Resi Pengiriman</label>
                            <input class="form-control" name='resi'
                                id='resi'placeholder="Masukkan Resi Pengiriman" required type="text">
                            <div class="d-grid gap-2 col-2 mx-auto mx-auto">
                                <button type="submit" class="btn btn-greenlight fw-bold my-4"
                                    style="color:#598420 ;">Kirim</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
