@extends('admin.layouts.app')
@section('content')
    <div class="container ">
        <div class="row ">
            <div class="h4 fw-bold my-4">Detail Produk</div>
            <div class="col-12 col-md-12 col-lg-9">
                <div class="row ">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="row">
                            <div class="col-12 col-md-4 col-lg-3 my-2">
                                <div class="text-center">
                                    <img src="{{ asset('storage/files/'. $produk->encrypted_filename) }}" alt="w"
                                        class='image-fluid w-100'>
                                </div>
                            </div>
                            <div class="col-10 col-md-5 col-lg-5">
                                <div class="h5 fw-bold">{{ $produk->nama_produk }}</div>
                                <div class="d-flex justify-content-between my-3">
                                    <div class="">
                                        <div class="i bi-star"><span> {{ $produk->rating }}</span></div>
                                    </div>
                                    <div class="">125 Terjual</div>
                                    <div class="">34 Ulasan</div>
                                </div>
                                @php
                                    try {
                                        $ascHarga = App\Models\Varian::orderBy('harga_produk', 'asc')->first()->harga_produk;
                                        $descHarga = App\Models\Varian::orderBy('harga_produk', 'desc')->first()->harga_produk;
                                    } catch (Exception $e) {
                                        $ascHarga = null;
                                        $descHarga = null;
                                    }
                                @endphp
                                <div class="h5 my-3">
                                    {{ 'Rp' . '.' . number_format($ascHarga) . ' - ' . 'Rp' . '.' . number_format($descHarga) }}
                                </div>
                                <div class="">Varian</div>
                                <div class="d-flex gap-1">
                                    @foreach ($varian2 as $index => $varians2)
                                        @php
                                            $urlvarian = request('varian');
                                        @endphp

                                        <a class="btn btn-outline-success {{ ($urlvarian === null && $index === 0) || $urlvarian == $varians2->id ? 'active' : '' }}"
                                            href="{{ route('produk.show', ['produk' => $produk->id, 'varian' => $varians2->id]) }}">
                                            {{ $varians2->berat . ' Kg' }}
                                        </a>

                                        {{-- @foreach ($varian2 as $varians2)
                                        @php
                                            $urlvarian = request('varian');
                                        @endphp
                                        @if ($urlvarian == $varians2->id) 
                                            <a class="btn active "
                                                href="{{ route('produk.show', ['produk' => $produk->id, 'varian' => $varians2->id]) }}">{{ $varians2->berat . ' Kg' }}</a>
                                        @else
                                            <a class="btn "
                                                href="{{ route('produk.show', ['produk' => $produk->id, 'varian' => $varians2->id]) }}">{{ $varians2->berat . ' Kg' }}</a>
                                        @endif --}}
                                        {{-- <input type="radio" class="btn-check" name="options-base" id="option{{ $varians2->id }}" autocomplete="off">
                                    <label class="btn" for="option{{ $varians2->id }}">{{ $varians2->berat }}</label>                                     --}}
                                    @endforeach
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
                                @php
                                    try {
                                        echo "<span id='stokVarian'>" . $varian->stok . '</span>';
                                    } catch(Exception $e) {
                                        echo "<span id='stokVarian'>Varian Masih Kosong</span>";
                                    }
                                @endphp
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
        </div>
    </div>
@endsection

{{-- <script type="module">
    var buttons = document.querySelectorAll('.btn[data-id]');

    // Menambahkan event listener untuk setiap tombol
    buttons.forEach(function(button) {
        button.addEventListener('click', function() {
            // Mendapatkan ID varian dari atribut data-id
            var varianId = this.getAttribute('data-id');

            // Menggunakan AJAX atau cara lain untuk mengambil stok dari server
            // Di sini, kita hanya menetapkan stok secara statis sebagai contoh
            var stok = 'Stok dari varian dengan ID ' + varianId;

            // Memperbarui teks pada elemen span dengan ID stokVarian
            document.getElementById('stokVarian').textContent = stok;
        });
    });
</script> --}}
