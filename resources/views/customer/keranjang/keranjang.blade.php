@extends('customer.layouts.app')
@section('content')
    <div class="container p-3">

        <div class="row mt-5">

            @if ($keranjang->isNotEmpty())
                {{-- <form class="col-12 col-md-7 col-lg-8 " id="submit"> --}}
                <form class="col-12 col-md-7 col-lg-8 " method="GET" id="submit" action="{{ route('produk.pesanan') }}">
                    {{-- @csrf --}}
                    <div class="col-12 col-md-7 col-lg-12 ">
                        @foreach ($keranjang as $index => $keranjangs)
                            <div class="row align-items-center">
                                {{-- <div class="col-12 col-md-1 col-lg-1 ">
                                <div class="form-check checkbox-lg form-check-inline ms-4 ">
                                    <input class="form-check-input " type="checkbox" id="inlineCheckbox1" value="option1">
                                </div>
                            </div> --}}
                                <div class="col-12 col-md-10 col-lg-11 mb-3">

                                    <div id="cart" class="card rounded-4 " data-index="{{ $index }}"
                                        data-stok="{{ $keranjangs->varian->produk->stok }}"
                                        data-harga="{{ $keranjangs->varian->harga_produk }}"
                                        data-berat="{{ $keranjangs->varian->berat }}"
                                        data-id_produk="{{ $keranjangs->varian->id_produk }}">
                                        <div class="card-body">
                                            <input hidden type="number" id="quantity-hid{{ $index }}" step="1"
                                                readonly name="value[][jumlah_produk]"
                                                value="{{ $keranjangs->jumlah_produk }}" class="quantity-field ">

                                            <input hidden type="number" name="keranjang[][id]"
                                                value="{{ $keranjangs->id }}">
                                            <div class="row g-4">
                                                <div class="col-12 col-md-6 col-xl-2 ">
                                                    <img src="{{ asset('storage/files/' . $keranjangs->varian->produk->encrypted_filename) }}"
                                                        alt=".." class="img-fluid rounded img-w ">
                                                </div>
                                                <div class="col-12 col-md-6 col-lg-4">
                                                    <span class="h6 fw-bold">{{ $keranjangs->varian->produk->nama_produk }}
                                                    </span>
                                                    <div>
                                                        <div>Varian : {{ $keranjangs->varian->berat }} Kg</div>
                                                    </div>
                                                    <div class="">
                                                        <span class="">Sisa: {{ $keranjangs->varian->produk->stok }}
                                                            Kg</span>
                                                    </div>
                                                    <div>
                                                        <div class="h4 fw-bold ">
                                                            <div class="greendark">
                                                                {{ 'Rp' . '.' . number_format($keranjangs->varian->harga_produk) }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-md-8 col-lg-6 ">
                                                    <form action=""></form>
                                                    <div
                                                        class="input-group gap-4 d-flex align-items-center justify-content-end mt-4">
                                                        <div class="">
                                                            <input type="button" id="btn-minus-{{ $index }}"
                                                                value="-"
                                                                class="button-minus border icon-shape icon-sm mx-1"
                                                                data-field="quantity">
                                                            <input type="number" id="quantity-{{ $index }}"
                                                                step="1" readonly
                                                                max="{{ $keranjangs->varian->produk->stok }}"
                                                                value="{{ $keranjangs->jumlah_produk }}"
                                                                class="quantity-field border-0 text-center my-quantity-field"
                                                                style="width: 50px;">
                                                            <input type="button" id="btn-plus-{{ $index }}"
                                                                value="+" class="button-plus border icon-shape icon-sm"
                                                                data-field="quantity">
                                                        </div>
                                                        <div class="mt-3">

                                                            <form id='nested-form' method="POST"
                                                                action="{{ route('keranjang.destroy', ['keranjang' => $keranjangs->id]) }}">
                                                                @csrf
                                                                @method('delete')
                                                                <button type="submit" class="btn btn-secondary ">
                                                                    <div class="i bi bi-trash"></div>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    {{-- <div class="mt-3">
                                            <span class="fw-bold"
                                                id='total-{{ $index }}'>{{ 'Subtotal : Rp' . '.' . number_format($keranjangs->varian->harga_produk * $keranjangs->jumlah_produk) }}</span> </div> --}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </form>

                <div class="col-12 col-md-3  col-xl-2">
                    <div class="card card-w ">
                        <div class="card-body">
                            <h5 class="card-title ms-2 fw-bold">Ringkasan</h5>
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th scope="row" class="w-50">Jumlah Barang : </th>

                                        <th id='total_produk'>{{ $keranjang->sum('jumlah_produk') }}</th>
                                    </tr>
                                    <tr>
                                        @php
                                            $totalHarga = 0;
                                            foreach ($keranjang as $item) {
                                                $totalHarga += $item->varian->harga_produk * $item->jumlah_produk;
                                            }
                                        @endphp
                                        <th scope="row" class="w-50">Total Harga :</th>
                                        <th id='total_harga'>{{ 'Rp.' . number_format($totalHarga) }}</th>
                                    </tr>
                                </tbody>
                            </table>
                            <div>
                                @php
                                    $cekAlamat = App\Models\Alamat::where('id_user', auth()->id())->first();

                                @endphp
                                <div class=" mt-3 d-grid">
                                    @if ($cekAlamat != null)
                                        <button class="btn btn-greenlight text-decoration-none" id="btn_submit"
                                            type="submit">
                                            <div class="greendark fw-bold">Pesan Sekarang</div>
                                        </button>
                                    @else
                                        <div class="btn btn btn-greenlight text-decoration-none" data-bs-toggle="modal"
                                            data-bs-target='#modal-alert'>
                                            <div class="greendark fw-bold">Pesan Sekarang</div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class=" col text-center align-items-center">
                        <img src="{{ Vite::asset('resources/images/chart.png') }}" class="" alt="">
                        <h5 class="my-2 fw-bold">Belum Ada Produk Tambahan</h5>
                        <div class=" mt-3 "> <a class="btn btn-greenlight text-decoration-none "
                                href="{{ route('produkreg') }}">
                                <div class="greendark fw-bold">Belanja Sekarang</div>
                            </a></div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <div class="modal border-warning fade " id="modal-alert" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header ">
                    <div class="h5 text-danger mt-2 fw-bold">
                        Tidak Dapat Membuat Pesanan
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="fw-bold mt-2">Data Anda Belum Lengkap ! </div> Lengkapi Data dan Alamat Anda Terlebih
                        Dahulu Pada Menu Profil Sebelum Melakukan Pemesanan!
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script type="module">
        $("#btn_submit").on("click", function() {
            let value = $('input[name="value[][jumlah_produk]"]')
            const cartItems = document.querySelectorAll('#cart');
            let cart = []
            let gagal = false
            cartItems.forEach((item, key) => {
                let dataset = item.dataset
                let index = cart.findIndex(c => {
                    return c.id === dataset.id_produk
                })
                // console.log(cart)
                if (index != -1) {
                    if (cart[index].jumlah_berat + dataset.berat * value[key].value > parseInt(dataset
                            .stok)) {
                        gagal = true
                        return
                    }
                    cart[index].jumlah_berat += dataset.berat * value[key].value
                } else {
                    if (dataset.berat * value[key].value > parseInt(dataset.stok)) {
                        gagal = true
                        return
                    }
                    cart.push({
                        id: dataset.id_produk,
                        jumlah_berat: dataset.berat * value[key].value,
                        stock: dataset.stok

                    })
                }

            });
            if (gagal) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Ada Pembelian yang melebihi stok',
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    // Setelah alert muncul, muat ulang halaman setelah 1.5 detik
                    location.reload();
                });
            }
            $("#submit").trigger("submit");
        })
    </script>
@endsection
<script>
    @if ($keranjang->isNotEmpty())
        function initializeCartItems() {
            const cartItems = document.querySelectorAll('#cart');

            cartItems.forEach(item => {
                const index = item.dataset.index;
                const varianBerat = parseInt(item.dataset.berat);
                const quantity = item.querySelector(`#quantity-${index}`);
                const quantityhid = item.querySelector(`#quantity-hid${index}`);
                const btnMinus = item.querySelector(`#btn-minus-${index}`);
                const btnPlus = item.querySelector(`#btn-plus-${index}`);
                // const total = item.querySelector(`#total-${index}`);

                const hargaSatuan = parseInt(item.dataset.harga);
                const stok = parseInt({{ $keranjangs->varian->produk->stok }});
                const Jmlproduk = document.getElementById('total_produk');
                const Jmltotal = document.getElementById('total_harga');

                function updateTotalHarga(qty) {
                    let totalHarga = hargaSatuan * qty;
                    // total.textContent = `Subtotal : Rp.${totalHarga.toLocaleString()}`;
                }

                function ReduceTotal(nilaiTotal, hargaTotal, hargaSatuan) {
                    let cleanNumber = parseInt(hargaTotal.replace(/\D+/g, ''));
                    let totalproduk = nilaiTotal - 1;
                    let totalharga = parseInt(cleanNumber) - parseInt(hargaSatuan);

                    Jmlproduk.textContent = `${totalproduk.toLocaleString()}`;
                    Jmltotal.textContent = `Rp.${totalharga.toLocaleString()}`;
                }

                function AddTotal(nilaiTotal, hargaTotal, hargaSatuan) {
                    let cleanNumber = parseInt(hargaTotal.replace(/\D+/g, ''));
                    let totalproduk = parseInt(nilaiTotal) + 1;
                    let totalharga = parseInt(cleanNumber) + parseInt(hargaSatuan);

                    Jmlproduk.textContent = `${totalproduk.toLocaleString()}`;
                    Jmltotal.textContent = `Rp.${totalharga.toLocaleString()}`;
                }

                if (btnMinus && btnPlus && quantity && quantityhid) {
                    btnMinus.addEventListener('click', reduceQty);
                    btnPlus.addEventListener('click', addQty);
                }

                function reduceQty() {
                    let qty = parseInt(quantity.value) || 1;
                    let qtyhid = parseInt(quantityhid.value) || 1; // tambahan quantityhid
                    let nilaiTotal = document.getElementById('total_produk').textContent;
                    let hargaTotal = document.getElementById('total_harga').textContent;
                    if (qty > 1) {
                        quantity.value = qty - 1;
                        quantityhid.value = qtyhid - 1; // update nilai quantityhid
                        updateTotalHarga(qty - 1);
                        ReduceTotal(nilaiTotal, hargaTotal, hargaSatuan);

                        if (qty > stok) {
                            quantity.value = stok;
                            quantityhid.value = stok; // update nilai quantityhid
                            updateTotalHarga(stok);
                        }
                    } else {
                        quantity.value = 1;
                        quantityhid.value = 1; // update nilai quantityhid
                        updateTotalHarga(1);
                    }
                }

                function addQty() {
                    let qty = parseInt(quantity.value) || 0;
                    let qtyhid = parseInt(quantityhid.value) || 0; // tambahan quantityhid
                    let nilaiTotal = document.getElementById('total_produk').textContent;
                    let hargaTotal = document.getElementById('total_harga').textContent;
                    let totalBerat = qty * varianBerat;

                    if (totalBerat < stok) {
                        if (qty >= stok) {
                            quantity.value = stok;
                            quantityhid.value = stok; // update nilai quantityhid
                            updateTotalHarga(stok);

                        }
                        if (totalBerat + varianBerat <= stok) {

                            quantity.value = qty + 1;
                            quantityhid.value = qtyhid + 1;
                            updateTotalHarga(qty + 1);
                            AddTotal(nilaiTotal, hargaTotal, hargaSatuan)
                        } else {
                            // Jika penambahan 1 qty melebihi stok, maka tentukan jumlah maksimum qty yang bisa ditambahkan
                            let maxQty = Math.floor((stok - totalBerat) / varianBerat);
                            quantity.value = qty + maxQty;
                            quantityhid.value = qtyhid + maxQty;
                            updateTotalHarga(qty + maxQty);
                            AddTotal(nilaiTotal, hargaTotal, hargaSatuan)
                        }
                    }
                }
            });
        }
        document.addEventListener('DOMContentLoaded', initializeCartItems);
    @else
    @endif
</script>







{{-- <script>
    function initializeCartItems() {
        const cartItems = document.querySelectorAll('#cart');

        cartItems.forEach(item => {
            const index = item.dataset.index;
            const quantity = item.querySelector(`#quantity-${index}`);
            const quantityhid = item.querySelector(`#quantity-hid${index}`);
            const btnMinus = item.querySelector(`#btn-minus-${index}`);
            const btnPlus = item.querySelector(`#btn-plus-${index}`);
            // const total = item.querySelector(`#total-${index}`);
            const hargaSatuan = parseInt(item.dataset.harga);
            const stok = parseInt(item.dataset.stok);
            const Jmlproduk = document.getElementById('total_produk');
            const Jmltotal = document.getElementById('total_harga');

            function updateTotalHarga(qty) {
                let totalHarga = hargaSatuan * qty;
                // total.textContent = `Subtotal : Rp.${totalHarga.toLocaleString()}`;
            }

            function ReduceTotal(nilaiTotal, hargaTotal, hargaSatuan) {
                let cleanNumber = parseInt(hargaTotal.replace(/\D+/g, ''));
                let totalproduk = nilaiTotal - 1;
                let totalharga = parseInt(cleanNumber) - parseInt(hargaSatuan);

                Jmlproduk.textContent = `${totalproduk.toLocaleString()}`;
                Jmltotal.textContent = `Rp.${totalharga.toLocaleString()}`;
            }

            function AddTotal(nilaiTotal, hargaTotal, hargaSatuan) {
                let cleanNumber = parseInt(hargaTotal.replace(/\D+/g, ''));
                let totalproduk = parseInt(nilaiTotal) + 1;
                let totalharga = parseInt(cleanNumber) + parseInt(hargaSatuan);

                Jmlproduk.textContent = `${totalproduk.toLocaleString()}`;
                Jmltotal.textContent = `Rp.${totalharga.toLocaleString()}`;
            }

            if (btnMinus && btnPlus && quantity && quantityhid) {
                btnMinus.addEventListener('click', reduceQty);
                btnPlus.addEventListener('click', addQty);
            }

            function reduceQty() {
                let qty = parseInt(quantity.value) || 1;
                let qtyhid = parseInt(quantityhid.value) || 1; // tambahan quantityhid
                let nilaiTotal = document.getElementById('total_produk').textContent;
                let hargaTotal = document.getElementById('total_harga').textContent;
                if (qty > 1) {
                    quantity.value = qty - 1;
                    quantityhid.value = qtyhid - 1; // update nilai quantityhid
                    updateTotalHarga(qty - 1);
                    ReduceTotal(nilaiTotal, hargaTotal, hargaSatuan);

                    if (qty > stok) {
                        quantity.value = stok;
                        quantityhid.value = stok; // update nilai quantityhid
                        updateTotalHarga(stok);
                    }
                } else {
                    quantity.value = 1;
                    quantityhid.value = 1; // update nilai quantityhid
                    updateTotalHarga(1);
                }
            }

            function addQty() {
                let qty = parseInt(quantity.value) || 0;
                let qtyhid = parseInt(quantityhid.value) || 0; // tambahan quantityhid
                let nilaiTotal = document.getElementById('total_produk').textContent;
                let hargaTotal = document.getElementById('total_harga').textContent;

                if (qty >= stok) {
                    quantity.value = stok;
                    quantityhid.value = stok; // update nilai quantityhid
                    updateTotalHarga(stok);

                } else {
                    quantity.value = qty + 1;
                    quantityhid.value = qtyhid + 1; // update nilai quantityhid
                    updateTotalHarga(qty + 1);
                    AddTotal(nilaiTotal, hargaTotal, hargaSatuan)
                }
            }
        });
    }
    document.addEventListener('DOMContentLoaded', initializeCartItems);
</script> --}}
{{-- <script type="module">
    let quantity = document.getElementById('quantity');
    let btn_minus = document.getElementById('btn-minus');
    let btn_plus = document.getElementById('btn-plus');
    let total = document.getElementById('total');

    const hargaSatuan = parseInt("{{ $keranjangs->varian->harga_produk }}");
    const stok = parseInt("{{ $keranjangs->varian->stok }}");

    function updateTotalHarga(qty) {
        let totalHarga = hargaSatuan * qty;
        total.textContent = ` Subtotal : Rp.${totalHarga.toLocaleString()}`;
    }

    if (btn_minus && btn_plus && quantity) {
        btn_minus.addEventListener('click', reduce_qty);
        btn_plus.addEventListener('click', add_qty);

        function reduce_qty() {
            let qty = quantity.value;
            if (qty.trim() === "") {
                qty = 1;
            }
            qty = parseInt(qty);
            if (qty > 1) {
                quantity.value = qty - 1;
                updateTotalHarga(qty - 1);
                if (qty > stok) {
                    quantity.value = stok;
                    updateTotalHarga(stok);
                }
            } else {
                quantity.value = 1;
                updateTotalHarga(1);
            }
        }

        function add_qty() {
            let qty = quantity.value;
            if (qty.trim() === "") {
                qty = 0;
            }
            qty = parseInt(qty);
            if (qty >= stok) {
                quantity.value = stok;
                updateTotalHarga(stok);
            } else {
                quantity.value = qty + 1;
                updateTotalHarga(qty + 1);
            }
        }
    }
</script> --}}
{{-- @extends('customer.layouts.app')
@section('content')
    <div class="container p-3">
        <div class="h1  my-2">Keranjang</div>
        <div class="row">
            <div class="col-12 col-md-7 col-lg-8 ">
                @foreach ($keranjang as $index => $keranjangs)
                    <div id="cc" class="card rounded-3 mb-2" data-index="{{ $index }}" data-harga="{{ $keranjangs->varian->harga_produk }}" data-stok="{{ $keranjangs->varian->stok }}">
                        <div class="card-body">
                            <div class="row g-4">
                                <div class="col-12 col-md-6 col-xl-2 ">
                                    <img src="{{ asset('storage/files/' . $keranjangs->varian->produk->encrypted_filename) }}"
                                        alt=".." class="img-fluid rounded img-w ">
                                </div>
                                <div class="col-12 col-md-6 col-lg-4">
                                    <p class="h3 fw-bold">{{ $keranjangs->varian->produk->nama_produk }} </p>
                                    <div>
                                        <span>Varian : {{ $keranjangs->varian->berat }} Kg</span>
                                    </div>
                                    <div class="">
                                        <span>Sisa: {{ $keranjangs->varian->stok }} </span>
                                    </div>
                                    <div>
                                        <span>Harga:
                                            {{ 'Rp' . '.' . number_format($keranjangs->varian->harga_produk) }}</span>
                                    </div>
                                </div>
                                <div class="col-12 col-md-8 col-lg-6">
                                    <div class="input-group d-flex align-items-center">
                                        <div class="fw-bold"><span class="me-2">Jumlah Beli : </span></div>
                                        <div class="">
                                            <input type="button" id="btn-minus-{{ $index }}" value="-"
                                                class="button-minus border icon-shape icon-sm mx-1" data-field="quantity">
                                            <input type="number" id="quantity-{{ $index }}" step="1"
                                                max="{{ $keranjangs->varian->produk->stok }}"
                                                value="{{ $keranjangs->jumlah_produk }}" name="quantity"
                                                class="quantity-field border-0 text-center my-quantity-field"
                                                style="width: 50px;">
                                            <input type="button" id="btn-plus-{{ $index }}" value="+"
                                                class="button-plus border icon-shape icon-sm" data-field="quantity">
                                        </div>
                                    </div>

                                    <div class="mt-3">
                                        <span class="fw-bold"
                                            id='total-{{ $index }}'>{{ 'Subtotal : Rp' . '.' . number_format($keranjangs->varian->harga_produk * $keranjangs->jumlah_produk) }}</span>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="checkbox" id="inlineCheckbox1"
                                                value="option1">
                                            <label class="form-check-label" for="inlineCheckbox1"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 justify-content-end">
                                    <div class="btn btn-secondary ">
                                        <div class="i bi bi-trash"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="col-12 col-md-3  col-xl-2">
                <div class="card card-w ">
                    <div class="card-body">
                        <h5 class="card-title"></h5>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th scope="row" class="w-50">Jumlah Barang : </th>
                                    <th>5</th>
                                </tr>
                                <tr>
                                    <th scope="row" class="w-50">Total Harga : </th>
                                    <th>50000</th>
                                </tr>
                            </tbody>
                        </table>
                        <div>
                            <div class=" mt-3 d-grid"> <a class="btn btn-outline-secondary text-decoration-none "
                                    href="{{ route('pesanan') }}">Beli Sekarang</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    function initializeCartItems() {
        const cartItems = document.querySelectorAll('#cc');
        console.log(cartItems)
        cartItems.forEach(item => {
            
            const index = item.dataset.index;            
            const quantity = item.querySelector(`#quantity-${index}`);
            const btnMinus = item.querySelector(`#btn-minus-${index}`);
            const btnPlus = item.querySelector(`#btn-plus-${index}`);
            const total = item.querySelector(`#total-${index}`);

            const hargaSatuan = parseInt(item.dataset.harga);
            const stok = parseInt(item.dataset.stok);

            function updateTotalHarga(qty) {
                let totalHarga = hargaSatuan * qty;
                total.textContent = `Subtotal : Rp.${totalHarga.toLocaleString()}`;
            }

            if (btnMinus && btnPlus && quantity) {
                btnMinus.addEventListener('click', reduceQty);
                btnPlus.addEventListener('click', addQty);
            }

            function reduceQty() {
                let qty = parseInt(quantity.value) || 1;

                if (qty > 1) {
                    quantity.value = qty - 1;
                    updateTotalHarga(qty - 1);

                    if (qty > stok) {
                        quantity.value = stok;
                        updateTotalHarga(stok);
                    }
                } else {
                    quantity.value = 1;
                    updateTotalHarga(1);
                }
            }

            function addQty() {
                let qty = parseInt(quantity.value) || 0;

                if (qty >= stok) {
                    quantity.value = stok;
                    updateTotalHarga(stok);
                } else {
                    quantity.value = qty + 1;
                    updateTotalHarga(qty + 1);
                }
            }
        });
    }

    document.addEventListener('DOMContentLoaded', initializeCartItems);
</script> --}}
