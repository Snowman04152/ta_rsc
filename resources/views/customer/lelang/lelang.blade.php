@extends('customer.layouts.app')
@section('content')
    <div class="container p-3 custom-foot">
        <div class="row rounded mt-5">
            <div class="col-10">
                <input type="search" class="form-control rounded border-greenlight" placeholder="Search" aria-label="Search"
                    aria-describedby="search-addon" />
            </div>
            <div class="col ">
                <div class="dropdown d-grid ">
                    <button class="btn btn-outline-greenlight dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Semua Status
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        <li><a class="dropdown-item" href="#">Another action</a></li>
                        <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                </div>
            </div>
        </div>
        
        @foreach ($lelang as $lelangs)
        @if($lelangs->status_lelang == 3 )
        @else
        <div class="col-12 col-md-6 col-lg-12">
            <a class="text-decoration-none " href="{{ route('lelang.detail', ['id' => $lelangs->id]) }}">
                <div class="card my-3 rounded-3">
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-12 col-md-6 col-lg-1">
                                <img src="{{ asset('storage/files/' . $lelangs->encrypted_filename) }}" alt=".."
                                    class="image-fluid rounded w-100">
                            </div>

                            <div class="col-12 col-md-6 col-lg-7">
                                <div class="row d-grid">
                                    <div class="fw-bold">
                                        <span>{{ $lelangs->nama_produk_lelang }}</span>
                                    </div>

                                    <div class="row">
                                        <div class="col">Penawaran Mulai </div>
                                        <div class="col-9 ">:&nbsp <t class="greendark fw-bold">
                                                {{ 'Rp.' . number_format($lelangs->harga_lelang) }}</t>
                                        </div>
                                    </div>
                                    <div class="row">
                                        @if ($lelangs->status_lelang === 0)
                                            <div class="col">Status </div>
                                            <div class="col-9">: &nbspBelum Dimulai</div>
                                        @elseif ($lelangs->status_lelang === 1)
                                            <div class="col">Status </div>
                                            <div class="col-9">: &nbspBerjalan</div>
                                        @else
                                            <div class="col">Status </div>
                                            <div class="col-9">: &nbspSelesai</div>
                                        @endif
                                    </div>
                                    <div class="row">
                                        <div class="col">Berakhir pada </div>
                                        <div class="col-9">: &nbsp{{ toIndoDate($lelangs->tanggal_selesai_lelang) }}
                                            WIB</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="d-flex mt-4 justify-content-end">
                                    @php
                                        $pengingatForLelang = $pengingat->where('id_produk_lelang', $lelangs->id)->first();
                                    @endphp
                                    @if ($lelangs->status_lelang === 0)
                                        @if (!$pengingatForLelang)
                                            <form
                                                action="{{ route('lelang.pengingat', ['id_produk_lelang' => $lelangs->id]) }}"
                                                method="POST">
                                                @csrf
                                                <div><object><button type="submit"
                                                            class="btn btn-greenlight text-decoration-none">
                                                            <div class="greendark">
                                                                Pasang
                                                                Pengingat
                                                            </div>
                                                        </button></object>
                                                </div>
                                            </form>
                                        @else
                                            <span>Peningat Sudah Dipasang </span>
                                        @endif
                                    @elseif ($lelangs->status_lelang === 1)
                                        <div><object><a class="btn btn-greenlight text-decoration-none"
                                                    href="{{ route('lelang.detail', ['id' => $lelangs->id]) }}">
                                                    <div class="greendark">
                                                        Ikuti
                                                        Lelang
                                                    </div>
                                                </a></object></div>
                                    @else
                                        <span>Selesai </span>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endif
        @endforeach
        <div class="modal fade " id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
            <div class="modal-dialog  ">
                <div class="modal-content border border-danger">
                    <div class="modal-header ">
                        <h5 class="modal-title text-danger " id="errorModalLabel">No Telepon Anda Kosong</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Pesan kesalahan akan ditampilkan di sini -->
                        <p id="errorMessage">Silahkan isi nomor telepon pada menu akun terlebih dahulu untuk melanjutkan.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script type="module">
    // JavaScript untuk menampilkan modal saat halaman dimuat atau terjadi kesalahan
    document.addEventListener('DOMContentLoaded', function() {
        @if (session()->has('error'))
            var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
            errorModal.show();
        @endif
    });
</script>
