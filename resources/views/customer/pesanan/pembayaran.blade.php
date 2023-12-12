@extends('customer.layouts.app')
@section('content')

    <div class="container p-3">
        <div class="h6 mt-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb fw-bold">
                    <li class="breadcrumb-item "><a class="text-decoration-none text-dark"
                            href="{{ route('produk.riwayat') }}"><i class="bi bi-chevron-left fw-bold"></i>Detail Pesanan</a>
                    </li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-12 col-md-7 col-lg-9">

                <div class="card rounded-4 p-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="row">
                                <div class="col-8">Status</div>
                                @if ($transaksiuser->status == 0)
                                    <div class="col fw-bold">Menunggu Pembayaran</div>
                                @elseif($transaksiuser->status == 1)
                                    <div class="col fw-bold">Pesanan Sedang di Proses</div>
                                @elseif($transaksiuser->status == 2)
                                    @if ($transaksiuser->kurir == 'AMBIL_DITEMPAT')
                                        <div class="col fw-bold">Belum Diambil</div>
                                    @else
                                        <div class="col fw-bold">Pesanan Terkirim</div>
                                    @endif
                                @elseif($transaksiuser->status == 3)
                                    <div class="col fw-bold">Pesanan Sedang Dikirim</div>
                                @else
                                    <div class="col fw-bold">Selesai</div>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-8">Tanggal Pembelian</div>
                                <div class="col fw-bold">{{ toIndoDate($transaksiuser->created_at) }}</div>
                            </div>
                            <div class="row">
                                <div class="col-8">Jenis Pesanan</div>
                                <div class="col  fw-bold"> Reguler</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="fw-bold my-2">Alamat </div>
                @php
                @endphp
                @if ($alamat->id != 0)
                    <div class="card rounded-4 p-3">
                        <div class="row">
                            <div class="col-11">

                                <div class="text-start p-2 btn-w">
                                    <div>
                                        <a> {{ $alamat->label }} </a>
                                    </div>
                                    <div>
                                        <span class='fw-bold'> {{ $alamat->penerima }} </span>
                                    </div>
                                    <div>
                                        <span>{{ $alamat->telepon }}</span>
                                        <span></span>
                                    </div>
                                    <div>
                                        <span>{{ ucfirst($alamat->nama_jalan) }},</span>
                                        <span>{{ ucwords(strtolower($alamat->kecamatan)) }},</span>
                                        <span>{{ ucwords(strtolower($alamat->kabupaten)) }},</span>
                                        <span>{{ ucwords(strtolower($alamat->provinsi)) }},</span>
                                        <span>{{ $alamat->kode_pos }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card rounded-4 p-3">
                        <div class="card-body">
                            <div>Anda Belum Mengisi Alamat </div>
                        </div>
                    </div>
                @endif
                <div class="fw-bold my-2"> Opsi Pengiriman </div>
                <div class="">
                    @php
                        $keranjang = App\Models\Keranjang::with('varian.produk')
                            ->where('id_transaksi', $transaksiuser->id)
                            ->get();
                        $produk_first = $keranjang->first();
                    @endphp
                    <div class="card rounded-4">
                        <div class="text-start p-4">
                            @if ($transaksiuser->kurir == 'AMBIL_DITEMPAT')
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
                                        <div class="fw-bold">{{ $transaksiuser->kurir }}</div>
                                    </div>
                                    <div class="col align-items-center text-end">
                                        Rp.{{ number_format($transaksiuser->harga_ongkir) }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="fw-bold my-2"> Daftar Produk </div>
                @foreach ($keranjang as $keranjangs)
                    <div class="card rounded-4 mb-3">
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
            </div>
            @php
                $TotalHarga = 0;
                foreach ($keranjang as $item) {
                    $TotalHarga += $item->varian->harga_produk * $item->jumlah_produk ?? 0;
                }
                // $TotalBarang = 0
                // foreach ($keranjang as $item) {
                //     $TotalBarang += $item->varian->harga_produk ?? 0;
                // }
            @endphp
            <div class="col-12 col-md-3 col-lg-2">
                <div class="card card-w ">
                    <div class="card-body">
                        <h5 class="card-title">Ringkasan </h5>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th scope="row" class="w-75">Jumlah Barang : </th>
                                    <th>{{ $keranjang->sum('jumlah_produk') }}</th>
                                </tr>
                                <tr>
                                    <th scope="row" class="w-50">Total Harga Barang : </th>
                                    <th>{{ 'Rp.' . number_format($TotalHarga) }}</th>
                                </tr>
                                <tr>
                                    <th scope="row" class="w-50">Ongkos Kirim : </th>
                                    <th>Rp.{{ number_format($transaksiuser->harga_ongkir) }}</th>
                                </tr>
                                <tr>
                                    <th scope="row" class="w-50">Total Harga: </th>
                                    <th>Rp.{{ number_format($transaksiuser->total_harga) }}</th>
                                </tr>
                            </tbody>
                        </table>
                        @if ($transaksiuser->status == 0)
                            <div class="d-grid ">
                                <button id="pay-button" class="btn btn-greenlight fw-bold mt-3 d-grid"
                                    style="color:#598420 ;">
                                    Bayar
                                </button>
                            </div>
                        @elseif ($transaksiuser->status == 1)
                            <a id="" href="https://api.whatsapp.com/send?phone=62838393994&text=Admin" class="btn btn-outline-greenlight fw-bold mt-3 d-grid" style="color:#598420 ;">
                                Hubungi Admin
                            </a>
                        @elseif ($transaksiuser->status == 2)
                            <div class="d-grid ">
                                <a href="{{route('produk.terima' , ['id' => $transaksiuser->id])}}"  class="btn btn-greenlight fw-bold  d-grid" style="color:#598420 ;">
                                    Konfirmasi Diambil
                                </a >
                                <a id="" href="https://api.whatsapp.com/send?phone=62838393994&text=Admin" class="btn btn-outline-greenlight fw-bold mt-3 d-grid" style="color:#598420 ;">
                                    Hubungi Admin
                                </a>
                            </div>
                        @elseif ($transaksiuser->status == 3)
                            <div class="d-grid ">
                                <a href="{{ route('produk.terima', ['id' => $transaksiuser->id]) }}"
                                    class="btn btn-greenlight fw-bold  d-grid" style="color:#598420 ;">
                                    Konfirmasi Diterima
                                </a>
                                <a id="" href="https://api.whatsapp.com/send?phone=62838393994&text=Admin" class="btn btn-outline-greenlight fw-bold mt-3 d-grid" style="color:#598420 ;">
                                    Hubungi Admin
                                </a>
                            </div>
                        @elseif ($transaksiuser->status == 4)
                            @php
                                $ulasanExists = App\Models\Ulasan::where('id_transaksi', $transaksiuser->id)->exists();
                                // dd($ulasanExists);
                            @endphp
                            @if (!$ulasanExists)
                                <div class="d-grid">
                                    <button id="" class="btn btn-greenlight fw-bold mt-2 " data-bs-toggle="modal"
                                        data-bs-target='#modal-ulasan' style="color:#598420 ;">
                                        <div class="">
                                            Beri Ulasan
                                        </div>
                                    </button>
                                </div>
                                @else
                            @endif
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade " id="modal-ulasan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header ">
                    <div class="h5 mt-2 fw-bold">
                        Ulasan
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('produk.ulasan') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @foreach ($keranjang as $key => $keranjangs)
                            <div class="card rounded-4 mb-3">
                                <div class="card-body">
                                    <div class="row g-3">
                                        <div class="col-12 col-md-6 col-lg-2 ">
                                            <img src="{{ asset('storage/files/' . $keranjangs->varian->produk->encrypted_filename) }}"
                                                alt=".." class="img-fluid rounded w-100">
                                        </div>
                                        <div class="col-12 col-md-6 col-lg-10 ">
                                            <div class="h6 fw-bold">{{ $keranjangs->varian->produk->nama_produk }}</div>

                                            <div class="my-1">Varian: {{ $keranjangs->varian->berat . ' Kg' }}</div>

                                            <div class="d-flex justify-content-between">
                                                <h6 class=" fw-bold" style="color:#598420 ;">
                                                    {{ 'Rp.' . number_format($keranjangs->varian->harga_produk) }}</h6>
                                                <div>x{{ $keranjangs->jumlah_produk }} Barang </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="fw-bold">
                                            Penilaian Rating
                                        </div>
                                        <span id="rateMe1">
                                            <input type="number" required hidden
                                            name="id_varian[{{ $key }}][id_varian]"
                                            value="{{ $keranjangs->id_varian }}">
                                            <input type="number" required hidden
                                                name="id_transaksi[{{ $key }}][id_transaksi]"
                                                value="{{ $keranjangs->id_transaksi }}">
                                            <input type="number" required hidden
                                                name="rating[{{ $key }}][rating]"
                                                id="input_rating_{{ $keranjangs->id }}" value="0">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i onclick="ubah_rating({{ $i }}, '{{ $keranjangs->id }}')"
                                                    class="rating_{{ $keranjangs->id }} py-2 px-1 rate-popover fas fa-star amber-text"></i>
                                            @endfor
                                        </span>
                                        <div>
                                            <label class="my-2 h6 fw-bold" for="foto_produk">Foto Produk</label>
                                            <input class="form-control" name='foto_produk[]' id='foto_produk' required
                                                type="file" id="formFile">
                                        </div>
                                        <div>
                                            <label class="my-2 h6 fw-bold" for="review">Review Produk</label>
                                            <div class="form-floating">
                                                <textarea class="form-control my-2" required name='review[{{ $key }}][review]"' id='deskripsi' required
                                                    placeholder="Leave a comment here" id="floatingTextarea2" style="height: 135px"></textarea>
                                                <label for="floatingTextarea2">Isi Deskripsi Produk</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="d-grid">
                            <button class="btn btn-greenlight fw-bold mt-2" type="submit" style="color:#598420 ;">
                                <div>
                                    Submit Ulasan
                                </div>
                            </button>
                    </form>
                </div>
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

    <script>
        function ubah_rating(value, id) {
            document.getElementById("input_rating_" + id).value = value
            let rating = document.querySelectorAll(".rating_" + id)

            rating.forEach(element => {
                element.classList.remove('active')
            });

            for (let i = 0; i < value; i++) {
                rating[i].classList.add('active')
            }
        }
    </script>

    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

    <script type="text/javascript">
        // For example trigger on button clicked, or any time you need
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function() {
            // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function(result) {
                    /* You may add your own implementation here */
                    alert("payment success!");
                    console.log(result);
                    location.reload();
                },
                onPending: function(result) {
                    /* You may add your own implementation here */
                    alert("wating your payment!");
                    console.log(result);
                    location.reload();
                },
                onError: function(result) {
                    /* You may add your own implementation here */
                    alert("payment failed!");
                    console.log(result);
                    location.reload();
                },
                onClose: function() {
                    /* You may add your own implementation here */
                    alert('you closed the popup without finishing the payment');
                }
            })
        });
    </script>
    {{-- <script type="text/javascript">
        // For example trigger on button clicked, or any time you need
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
          // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
          window.snap.pay('{{$snapToken}}');
          // customer will be redirected after completing payment pop-up
        });
      </script> --}}
@endsection
