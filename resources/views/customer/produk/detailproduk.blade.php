@extends('customer.layouts.app')
@section('content')
    @if ($varian != null)
        <div class="container ">
            <div class="row ">
                <div class="h4 fw-bold my-4">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item "><a class="text-decoration-none text-dark"
                                    href="{{ route('produkreg') }}"><i class="bi bi-chevron-left"></i> Produk</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Detail Produk</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-12 col-md-12 col-lg-9">
                    <div class="row ">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="row">
                                <div class="col-12 col-md-4 col-lg-4 my-2">
                                    <div class="text-center">
                                        <img src="{{ asset('storage/files/' . $produk->encrypted_filename) }}"
                                            alt="" class='image-fluid w-100 rounded-3'>
                                    </div>
                                </div>
                                <div class="col-10 col-md-5 col-lg-5 mt-3">
                                    <div class="h2 fw-bold">{{ $produk->nama_produk }}</div>
                                    <div class="row g-0 my-3 h6">
                                        <div class="col-3 ">

                                            <div><i
                                                    class=" fas fa-star amber-text active">&nbsp</i><span>{{ $ratingTotal }}</span>
                                            </div>
                                        </div>
                                        <div class="col-3 ">
                                            <div class="">{{ $transaksiTotal }} <span
                                                    class=" text-secondary">Terjual</span> </div>
                                        </div>
                                        <div class="col-3 ">
                                            <div class="">{{ $ulasanTotal }} <span class=" text-secondary">Ulasan
                                                </span> </div>
                                        </div>

                                    </div>
                                    @if ($produk->status_pengambilan == 1)
                                        <div class="fw-bold fs-6">Produk Bisa Dikirim</div>
                                    @else
                                        <div class="fw-bold fs-6">Produk Tidak Dapat Dikirim</div>
                                    @endif
                                    @php
                                        $ascHarga = App\Models\Varian::where('id_produk', $produk->id)
                                            ->orderBy('harga_produk', 'asc')
                                            ->first();

                                        $descHarga = App\Models\Varian::where('id_produk', $produk->id)
                                            ->orderBy('harga_produk', 'desc')
                                            ->first();

                                        if ($ascHarga !== null) {
                                            $ascHarga = $ascHarga->harga_produk;
                                        } else {
                                            // Lakukan sesuatu jika $ascHarga bernilai null
                                        }

                                        if ($descHarga !== null) {
                                            $descHarga = $descHarga->harga_produk;
                                        } else {
                                            // Lakukan sesuatu jika $descHarga bernilai null
                                        }

                                    @endphp
                                    <div class="h4 my-4 fw-bold">
                                        <div class="greendark">
                                            {{ 'Rp' . '.' . number_format($ascHarga) . ' - ' . 'Rp' . '.' . number_format($descHarga) }}
                                        </div>
                                    </div>
                                    <div class="h6 my-1">Varian</div>
                                    <div class="d-flex gap-1">
                                        @foreach ($varian2 as $index => $varians2)
                                            @php
                                                $urlvarian = request('varian');
                                            @endphp

                                            <a class="btn btn-outline-greenlight {{ ($urlvarian === null && $index === 0) || $urlvarian == $varians2->id ? 'active' : '' }}"
                                                href="{{ route('detailproduk', ['id' => $produk->id, 'varian' => $varians2->id]) }}">
                                                {{ $varians2->berat . ' Kg' }}
                                            </a>
                                        @endforeach
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12 my-3">
                            <div class="h4 fw-bold"> Spesifikasi</div>
                            <div class="row fw-bold">
                                <div class="col">
                                    <span class="text-secondary">Stok</span>
                                </div>
                                <div class="col">
                                    <span class="text-secondary">Umur Simpan</span>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col">
                                    <span>{{ $produk->stok }} Kg</span>
                                </div>
                                <div class="col">
                                    <span>{{ $produk->umur_simpan }}</span>
                                </div>
                            </div>
                            <div class="h4 my-2 fw-bold"> Deskripsi</div>
                            <p class="text-break"> {{ $produk->deskripsi }}</p>
                        </div>
                    </div>
                </div>
                @php
                    $keranjangCek = App\Models\Keranjang::with('varian.produk')
                        ->where('id_user', auth()->id())
                        ->where('id_varian', $varian->id)
                        ->where('id_transaksi', null)
                        ->exists();
                @endphp
                @if ($produk->status != 0 && $produk->stok > 0)
                    @if ($keranjangCek)
                        <div class="col-8 col-md-6 col-lg-2">
                            <div class="card rounded-3 card-w p-3 border-secondary my-3">
                                <div class="card-title  text-center">
                                    <div class="fw-bold h5">
                                        Produk Sudah di keranjang
                                    </div>
                                    <div>
                                        Silahkan Cek Keranjang Anda Untuk Mengedit Produk
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-8 col-md-6 col-lg-2">
                            <div class="card border-success rounded-3 card-w p-3 border-secondary my-3">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <span>Varian dipilih :&nbsp </span>
                                        <span class="fw-bold ">{{ ' ' . $varian->berat . ' Kg' }}</span>
                                    </div>
                                    <form method="POST" action="{{ route('keranjang.store', ['id' => $varian->id]) }}">
                                        @csrf
                                        <div class="d-flex justify-content-start my-2">
                                            <div class="input-group d-flex align-items-center ">
                                                <div class="">
                                                    <input type="button" id="btn-minus" value="-"
                                                        class="button-minus border  icon-shape icon-sm mx-1 "
                                                        data-field="quantity">
                                                    <input readonly type="number" id="quantity" step="0.1"
                                                        max="{{ $varian->stok }}" value="1" name="quantity"
                                                        class="quantity-field border-0 text-center" style="width: 50px;">
                                                    <input type="button" id="btn-plus" value="+"
                                                        class="button-plus border icon-shape icon-sm "
                                                        data-field="quantity">
                                                </div>
                                                <div class="ms-2 my-2 fw-bold">
                                                    {{ $produk->stok . 'Kg Tersisa' }}
                                                </div>
                                                <div class="d-flex my-3">
                                                    <span>Total Harga : &nbsp </span>
                                                    <span id='total'
                                                        class="fw-bold h5">{{ 'Rp' . '.' . number_format($varian->harga_produk) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div>
                                            @if (Route::has('login'))
                                                @auth
                                                    <div class="d-grid"><button class="btn btn-greenlight fw-bold"
                                                            type="submit">
                                                            <div class="greendark">
                                                                Keranjang
                                                            </div>
                                                        </button>
                                                    </div>
                                                @else
                                                    <div class="d-grid">
                                                        <a class="btn btn-greenlight fw-bold" href="{{ route('loginuser') }}">
                                                            <div class="greendark"><i class="bi bi-plus-lg"></i>
                                                                Keranjang
                                                            </div>
                                                        </a>
                                                    </div>
                                                @endauth
                                            @endif
                                        </div>
                                    </form>
                                    <div>
                                        @php
                                            $cekAlamat = App\Models\Alamat::where('id_user', auth()->id())->first();

                                        @endphp
                                        @if ($cekAlamat != null)
                                            <form id="beli_langsung"
                                                 action="{{ route('produk.langsung', ['id' => $varian->id]) }}">
                                                <input hidden readonly type="number" value="1" name="quantityhid"
                                                    id="quantityhid">
                                                <div class=" mt-3 d-grid">
                                                    <button type="submit" id="beli"
                                                        class="btn btn-outline-greenlight text-decoration-none ">
                                                        <div class="greendark fw-bold">Beli Langsung</div>
                                                    </button>
                                                </div>
                                            </form>
                                        @else
                                            <div class="btn btn-outline-greenlight text-decoration-none d-grid"
                                                data-bs-toggle="modal" data-bs-target='#modal-alert'>
                                                <div class="greendark fw-bold">Beli Langsung</div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @else
                    <div class="col-8 col-md-6 col-lg-2">
                        <div class="card rounded-3 card-w p-3 border-secondary my-3">
                            <div class="card-body">
                                <div class="text-center">
                                    <span class="h5 fw-bold">
                                        Produk Tidak Tersedia!
                                    </span>
                                    <div class="mt-2">
                                        Produk Ini tidak tersedia karena Stok Habis / Tidak Aktif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

            </div>
            <div class="modal border-warning fade " id="modal-alert" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header ">
                            <div class="h5 text-danger mt-2 fw-bold">
                                Tidak Dapat Membuat Pesanan
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div>
                                <div class="fw-bold mt-2">Data Anda Belum Lengkap ! </div> Lengkapi Data dan Alamat Anda
                                Terlebih
                                Dahulu Pada Menu Profil Sebelum Melakukan Pemesanan!
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between my-3 align-items-center">
                <div><span class="h4 fw-bold ">Ulasan</span></div>
                {{-- <div>
                    <span class="fw-bold me-4">Urutkan</span>
                    <div class="dropdown d-inline-block align-items-center">
                        <button class="btn btn-outline-secondary dropdown-toggle btn-sm " type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Terbaru
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </div>
                </div> --}}
            </div>
            @foreach ($ulasan as $ulasans)
                <div class="card rounded-4 mb-3 shadow">
                    <div class="card-body">
                        <div class='row'>
                            <div class="col-1" style="width: 5%;">
                                <img src="{{ asset('storage/files/' . $ulasans->transaksi->user->encrypted_filename) }}"
                                    class="img-fluid  rounded-circle" style=" height: 35px; width:35px;" alt="..">
                            </div>
                            <div class="col">
                                <div class="d-flex  justify-content-between">
                                    <span class="fw-bold h5">{{ ucfirst($ulasans->transaksi->user->username) }}</span>
                                    <div>
                                        <i class="fas fa-star amber-text active">&nbsp</i>
                                        <span class="fw-bold"> {{ number_format($ulasans->rating, 1) }}
                                        </span>
                                    </div>
                                </div>
                                <div>
                                    @php
                                        $Date = date('d/m/Y, H:i', strtotime($ulasans->created_at));
                                    @endphp
                                    <div class="d-flex ">
                                        <h6 class="text-secondary" style="font-size: 100%;">Varian:
                                            {{ $ulasans->varian->berat }} Kg </h5>

                                            <h6 class="ms-4 text-secondary" style="font-size: 100%;">
                                                {{ $Date }}</h6>
                                    </div>
                                    <h6 class="fw-bold">{{ $ulasans->review_produk }}</h6>
                                    <div class="row my-2">
                                        <div class="col-1">
                                            <img src="{{ asset('storage/files/' . $ulasans->encrypted_filename) }}"
                                                class="img-fluid w-100 rounded" style="max-width: 100px;" alt="..">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="container ">
            <div class="row ">
                <div class="h4 fw-bold my-4">Detail Produk</div>
                <div class="col-12 col-md-12 col-lg-9">
                    <div class="row ">
                        <div class="col-12 col-md-12 col-lg-12">
                            <div class="row">
                                <div class="col-12 col-md-4 col-lg-3 my-2">
                                    <div class="text-center">
                                        <img src="{{ asset('storage/files/' . $produk->encrypted_filename) }}"
                                            alt="" class='image-fluid w-100 rounded-3'>
                                    </div>
                                </div>
                                <div class="col-10 col-md-5 col-lg-5">
                                    <div class="h5 fw-bold">{{ $produk->nama_produk }}</div>
                                    <div class="row g-0 my-3 h6">
                                        <div class="col-3 ">

                                            <div><i
                                                    class=" fas fa-star amber-text active">&nbsp</i><span>{{ $ratingTotal }}</span>
                                            </div>
                                        </div>
                                        <div class="col-3 ">
                                            <div class="">{{ $transaksiTotal }} <span
                                                    class=" text-secondary">Terjual</span> </div>
                                        </div>
                                        <div class="col-3 ">
                                            <div class="">{{ $ulasanTotal }} <span class=" text-secondary">Ulasan
                                                </span> </div>
                                        </div>

                                    </div>
                                    <div class="h5 my-3"></div>
                                    <div class="h5 fw-bold">Varian Belum Ditambahkan</div>
                                    <div class="d-flex gap-1">

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-12 col-lg-12 my-3">
                            <div class="h4 fw-bold"> Spesifikasi</div>
                            <div class="row fw-bold">
                                <div class="col">
                                    <span>Stok</span>
                                </div>
                                <div class="col">
                                    <span>Umur Simpan</span>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col">
                                    <span>Varian Belum Ditambahkan</span>
                                </div>
                                <div class="col">
                                    <span>{{ $produk->umur_simpan }}</span>
                                </div>
                            </div>
                            <div class="h4 my-2 fw-bold"> Deskripsi</div>
                            <p class="text-break">{{ $produk->deskripsi }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-8 col-md-6 col-lg-2">
                    <div class="card rounded-3 card-w p-3 border-secondary p-4">
                        <div class="card-title h6 text-center fw-bold">
                            Produk Belum Memiliki Varian!
                        </div>
                        <div class=" text-center">
                            Silahkan Tunggu Sampai Admin Menambahkan Varian ya!!
                        </div>
                    </div>
                </div>

            </div>
            <div class="d-flex justify-content-between my-2 align-items-center">

            </div>

        </div>
    @endif
    <script type="module">
        $(document).ready(function() {
    $(document).on('click', '#beli', function(e) {
        e.preventDefault();

        // Tampilkan konfirmasi SweetAlert sebelum melakukan tindakan
        Swal.fire({
            title: 'Apakah Anda Yakin ?',
            text: 'Anda Akan Masuk Halaman Pesanan',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya',
            cancelButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form secara otomatis saat pengguna mengonfirmasi
                document.getElementById('beli_langsung').submit();
            }
        });
    });
});

    </script>
@endsection
<script type="module">
    @if ($varian != null)
        let quantity = document.getElementById('quantity');
        let qtyhid = document.getElementById('quantityhid');
        let btn_minus = document.getElementById('btn-minus');
        let btn_plus = document.getElementById('btn-plus');
        let total = document.getElementById('total');

        const hargaSatuan = parseFloat("{{ $varian->harga_produk }}");
        const stok = parseFloat("{{ $produk->stok }}");
        const varianBerat = parseFloat("{{ $varian->berat }}"); // Berat dari varian
        function updateTotalHarga(qty) {
            let totalHarga = hargaSatuan * qty;
            total.textContent = `Rp.${totalHarga.toLocaleString()}`;
        }

        if (btn_minus && btn_plus && quantity) {
            btn_minus.addEventListener('click', reduce_qty);
            btn_plus.addEventListener('click', add_qty);

            function reduce_qty() {
                let qty = quantity.value.trim() === "" ? 1 : parseInt(quantity.value);
                if (qty > 1) {
                    quantity.value = qty - 1;
                    qtyhid.value = qty - 1
                    updateTotalHarga(qty - 1);
                } else {
                    quantity.value = 1;
                    qtyhid.value = 1;
                    updateTotalHarga(1);
                }
            }

            function add_qty() {
                let qty = quantity.value.trim() === "" ? 0 : parseInt(quantity.value);
                let totalBerat = qty * varianBerat;

                if (totalBerat < stok) {
                    if (totalBerat + varianBerat <= stok) {
                        console.log(totalBerat + varianBerat)
                        quantity.value = qty + 1;
                        qtyhid.value = qty + 1
                        updateTotalHarga(qty + 1);
                    } else {
                        // Jika penambahan 1 qty melebihi stok, maka tentukan jumlah maksimum qty yang bisa ditambahkan
                        let maxQty = Math.floor((stok - totalBerat) / varianBerat);
                        quantity.value = qty + maxQty;
                        qtyhid.value = qty + maxQty;
                        updateTotalHarga(qty + maxQty);
                    }
                }
            }

        }
    @else
    @endif
</script>
{{-- <script type="module">
    $(document).ready(function() {
        $(document).on('click', '#nonaktif', function(e) {
            e.preventDefault();
            var link = $(this).attr("href");
            // Tampilkan konfirmasi SweetAlert sebelum penghapusan
            Swal.fire({
                title: "Anda Yakin Ingin Menonaktifkan Lelang ini?",
                text: "",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya ",
                cancelButtonText: "Tidak ",
            }).then((result) => {
                if (result.isConfirmed) {
                    // Lakukan penghapusan di sini, misal dengan AJAX request ke server
                    // Setelah penghapusan berhasil, tampilkan pesan berhasil menggunakan SweetAlert
                    Swal.fire({
                        title: "Lelang Dinonaktifkan",
                        text: "",
                        icon: "success"
                    });
                }
            });
        });
    });
</script> --}}



{{-- <script type="module">
    let quantity = document.getElementById('quantity')
    let btn_minus = document.getElementById('btn-minus')
    let btn_plus = document.getElementById('btn-plus')
    let total = document.getElementById('total')

    const hargaSatuan = {{ $varian->harga_produk }};

    function updateTotalHarga(qty) {
        let totalHarga = hargaSatuan * qty;
        total.textContent = `Total Harga : Rp.${totalHarga.toLocaleString()}`;
    }

    if (btn_minus && btn_plus && quantity) {
        btn_minus.addEventListener('click', reduce_qty)
        btn_plus.addEventListener('click', add_qty)

        function reduce_qty() {
            let qty = quantity.value
            if (qty.trim() == "") {
                qty = 1

            }
            if (qty > 1) {
                quantity.value = qty - 1
                updateTotalHarga(qty - 1);
            } else {
                quantity.value = 1
                updateTotalHarga(1);
            }
        }

        function add_qty() {
            let qty = quantity.value
            if (qty.trim() == "") {
                qty = 0
            }
            if (qty >= {{ $varian->stok }})
                quantity.value = {{ $varian->stok }}
            updateTotalHarga({{ $varian->stok }});
            else
                quantity.value = parseInt(qty) + 1
            updateTotalHarga(parseInt(qty) + 1);
        }
    }
</script> --}}
