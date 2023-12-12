@extends('customer.layouts.app')
@section('content')
    <div class="container p-3">
        <div class="h6 mt-2">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb fw-bold">
                    <li class="breadcrumb-item "><a class="text-decoration-none text-dark"
                            href="{{ route('lelang.riwayat') }}"><i class="bi bi-chevron-left fw-bold"></i>Detail Pesanan</a>
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
                                @if ($transaksilelang->status == 0)
                                    <div class="col fw-bold">Pesanan Belum Dibuat</div>
                                @elseif($transaksilelang->status == 1)
                                    <div class="col fw-bold">Menunggu Pembayaran</div>
                                @elseif($transaksilelang->status == 2)
                                    <div class="col fw-bold">Belum Diambil</div>
                                @elseif($transaksilelang->status == 3)
                                    <div class="col fw-bold">Sedang Dikirim</div>
                                @elseif($transaksilelang->status == 4)
                                    <div class="col fw-bold">Selesai</div>
                                @endif
                            </div>
                            <div class="row">
                                <div class="col-8">Tanggal Pemesanan</div>
                                <div class="col fw-bold">{{ toIndoDate($penawaran->created_at) }}</div>
                            </div>
                            <div class="row">
                                <div class="col-8">Jenis Pesanan</div>
                                <div class="col  fw-bold"> Lelang</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="fw-bold mb-1">Alamat </div>
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
                    <div class="card rounded-4">
                        <div class="text-start p-4">
                            <div class="d-flex justify-content-between">
                                @php
                                    $transaksi = App\Models\TransaksiLelang::where('id_penawaran', $penawaran->id)->first();
                                @endphp

                                @if ($transaksi->kurir == 'AMBIL_DITEMPAT')
                                    <span>Ambil di {{ $penawaran->produk_lelang->lokasi_pengambilan }}</span>
                                    <span>Rp.0</span>
                                @else
                                    <span>{{ $transaksi->kurir }}</span>
                                    <span>Rp.{{ number_format($transaksi->harga_ongkir) }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="fw-bold my-2"> Daftar Produk </div>
                <div class="card rounded-4 mb-2">
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12 col-md-6 col-lg-1 ">
                                <img src="{{ asset('storage/files/' . $penawaran->produk_lelang->encrypted_filename) }}"
                                    alt=".." class="img-fluid rounded w-100">
                            </div>
                            <div class="col-12 col-md-6 col-lg-11 ">
                                <p class="h5 fw-bold">{{ $penawaran->produk_lelang->nama_produk_lelang }}</p>
                                <div class="d-flex  justify-content-between">
                                    <h5 class=" fw-bold" style="color:#598420 ;">
                                        {{ 'Rp.' . number_format($penawaran->penawaran_harga) }}</h5>
                                    <div>x1 Barang </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3 col-lg-2">
                <div class="card card-w ">
                    <div class="card-body">
                        <h5 class="card-title">Ringkasan </h5>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th scope="row" class="w-75">Jumlah Barang : </th>
                                    <th>1</th>
                                </tr>
                                <tr>
                                    <th scope="row" class="w-50">Total Harga Barang : </th>
                                    <th>{{ 'Rp.' . number_format($penawaran->penawaran_harga) }}</th>
                                </tr>
                                <tr>
                                    <th scope="row" class="w-50">Ongkos Kirim : </th>
                                    <th>Rp.{{ number_format($transaksi->harga_ongkir) }}</th>
                                </tr>
                                <tr>
                                    <th scope="row" class="w-50">Total Harga: </th>
                                    <th>Rp.{{ number_format($transaksi->total_harga) }}</th>
                                </tr>
                            </tbody>
                        </table>
                        <div class="d-grid ">
                            @if ($transaksilelang->status == 0)
                                <div class="d-grid ">
                                    <button id="pay-button" class="btn btn-greenlight fw-bold mt-3 d-grid"
                                        style="color:#598420 ;">
                                        Bayar
                                    </button>
                                </div>
                            @elseif ($transaksilelang->status == 1)
                                <a id="" class="btn btn-greenlight fw-bold mt-3 d-grid" style="color:#598420 ;">
                                    Hubungi Penjual
                                </a>
                            @elseif ($transaksilelang->status == 2)
                                <div class="d-grid ">
                                    <a href="{{ route('lelang.terima', ['id' => $transaksilelang->id]) }}"
                                        class="btn btn-greenlight fw-bold  d-grid" style="color:#598420 ;">
                                        Konfirmasi diambil
                                    </a>
                                    <button id="" class="btn btn-outline-greenlight fw-bold mt-2 d-grid"
                                        style="color:#598420 ;">
                                        <div><i class="bi bi-whatsapp">&nbsp</i>
                                            Hubungi Admin
                                        </div>
                                    </button>
                                </div>
                            @elseif ($transaksilelang->status == 3)
                                <div class="d-grid ">
                                    <a href="{{ route('lelang.terima', ['id' => $transaksilelang->id]) }}"
                                        class="btn btn-greenlight fw-bold  d-grid" style="color:#598420 ;">
                                        Konfirmasi Diterima
                                    </a>
                                    <button id="" class="btn btn-outline-greenlight fw-bold mt-2 d-grid"
                                        style="color:#598420 ;">
                                        <div><i class="bi bi-whatsapp">&nbsp</i>
                                            Hubungi Admin
                                        </div>
                                    </button>
                                </div>
                            @else
                                
                            @endif
                        </div>
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
                    <div class="card rounded-4 mb-3">
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-12 col-md-6 col-lg-2 ">
                                    <img src="{{ asset('storage/files/' . $penawaran->produk_lelang->encrypted_filename) }}"
                                        alt=".." class="img-fluid rounded w-100">
                                </div>
                                <div class="col-12 col-md-6 col-lg-10 ">
                                    <div class="h6 fw-bold">{{ $penawaran->produk_lelang->nama_produk_lelang }}</div>



                                    <div class="d-flex justify-content-between">
                                        <h6 class=" fw-bold" style="color:#598420 ;">
                                            {{ 'Rp.' . number_format($penawaran->penawaran_harga) }}</h6>
                                        <div>x1 Barang </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="fw-bold">
                                    Penilaian Rating
                                </div>
                                <span id="rateMe1">
                                    <input type="number" required hidden name="rating"
                                        id="input_rating_{{ $penawaran->id }}" value="0">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i onclick="ubah_rating({{ $i }}, '{{ $penawaran->id }}')"
                                            class="rating_{{ $penawaran->id }} py-2 px-1 rate-popover fas fa-star amber-text"></i>
                                    @endfor
                                </span>
                                <div>
                                    <label class="my-2 h6 fw-bold" for="foto_produk">Foto Produk</label>
                                    <input class="form-control" name='foto_produk' id='foto_produk' required
                                        type="file" id="formFile">
                                </div>
                                <div>
                                    <label class="my-2 h6 fw-bold" for="foto_produk">Review Produk</label>
                                    <div class="form-floating">
                                        <textarea class="form-control my-2" required name='deskripsi' id='deskripsi' required
                                            placeholder="Leave a comment here" id="floatingTextarea2" style="height: 135px"></textarea>
                                        <label for="floatingTextarea2">Isi Deskripsi Produk</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-grid">
                        <button class="btn btn-greenlight fw-bold mt-2 " style="color:#598420 ;">
                            <div>
                                Submit Ulasan
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- <script type="module">
        const modalKurir = new bootstrap.Modal('#modal-kurir', {
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
