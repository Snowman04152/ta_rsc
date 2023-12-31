@extends('admin.layouts.app')
@section('content')
    <div class="col py-3 pe-5">
        <div class="h2 p-2 "><b>Produk Lelang</b></div>
        <div class="input-group rounded">
            <input type="search" class="form-control border-greenlight rounded" placeholder="Search" aria-label="Search"
                aria-describedby="search-addon" />
            <span class="input-group-text border-0" id="search-addon">
                <i class="fas fa-search"></i>
            </span>
            <div class="dropdown">
                <button class="btn btn-greenlight fw-bold dropdown-toggle" style="color:#598420 ;" type="button"
                    data-bs-toggle="dropdown" aria-expanded="false">
                    Semua Status
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                </ul>
            </div>
            <div class="mx-3">
                <div><a class="text-decoration-none btn btn-greenlight fw-bold" style="color:#598420 ;"
                        href="{{ route('lelang.create') }}">Add Lelang</a>
                </div>
            </div>
        </div>
        <table class="mt-2 table table-striped">
            <thead>
                <tr class='table-greenlight table-border-td '>
                    <th scope="col">No</th>
                    <th scope="col">Nama Produk</th>
                    <th scope="col">Umur Simpan</th>
                    <th scope="col">Harga Mulai</th>
                    <th scope="col">Status</th>
                    <th scope="col">Tanggal Mulai</th>
                    <th scope="col">Tanggal Selesai</th>
                    <th scope="col">Opsi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($lelang as $lelangs)
                    <tr>
                        <th scope="row">PL-000{{ $loop->iteration }}</th>
                        <td>{{ $lelangs->nama_produk_lelang }}</td>
                        <td>{{ $lelangs->umur_simpan }}</td>
                        <td>{{ 'Rp' . '.' . number_format($lelangs->harga_lelang) }}</td>
                        @if ($lelangs->status_lelang === 0)
                            <td>Belum Dimulai</td>
                        @elseif($lelangs->status_lelang === 1)
                            <td>Berjalan</td>
                        @elseif($lelangs->status_lelang === 2)
                            <td>Selesai</td>
                        @else
                            <td>Non Aktif</td>
                        @endif
                        <td>{{ toIndoDate($lelangs->tanggal_mulai_lelang) }}</td>
                        <td>{{ toIndoDate($lelangs->tanggal_selesai_lelang) }}</td>
                        <td>
                            <div class="dropdown">
                                <i class='bi-three-dots btn ' data-bs-toggle="dropdown" aria-expanded="false"></i>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item"
                                            href="{{ route('lelang.edit', ['lelang' => $lelangs->id]) }}">Edit</a></li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('lelang.show', ['lelang' => $lelangs->id]) }}">Detail</a></li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('lelang.nonaktif', ['id' => $lelangs->id]) }}"
                                            id='nonaktif'>Non-Aktifkan</a>
                                    </li>
                                    <li><a class="dropdown-item"
                                            href="{{ route('lelang.aktif', ['id' => $lelangs->id]) }}"id='aktif'>Aktifkan</a>
                                    </li>
                                    {{-- <form action="{{ route('lelang.destroy', ['lelang' => $lelangs->id]) }}"
                                        method="POST">
                                        @csrf
                                        @method('delete')
                                        <li><button class="dropdown-item">Delete</button>
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

<script type="module">
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
        $(document).on('click', '#aktif', function(e) {
            e.preventDefault();
            var link = $(this).attr("href");
            // Tampilkan konfirmasi SweetAlert sebelum penghapusan
            Swal.fire({
                title: "Anda Yakin Ingin Mengaktifkan Lelang ini?",
                text: "",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya ",
                cancelButtonText: "Tidak ",
            }).then((result) => {
                if (result.isConfirmed) {
                    setTimeout(function() {
                        window.location.href = link;
                    }, 2000);
                    Swal.fire({
                        title: "Lelang Diaktifkan",
                        text: "",
                        icon: "success"
                    });
                }
            });
        });
    });
</script>

{{-- <script type="module">
    $(document).ready(function() {
        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();

            // Tampilkan konfirmasi SweetAlert sebelum penghapusan
            Swal.fire({
                title: 'Are you sure?',
                text: 'You won\'t be able to revert this!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Lakukan penghapusan menggunakan AJAX
                    $.ajax({
                        url: $('#deleteForm').attr('action'),
                        type: 'DELETE',
                        data: $('#deleteForm').serialize(),
                        success: function(response) {
                            // Tampilkan pesan sukses setelah menghapus
                            Swal.fire('Deleted!', 'Your item has been deleted.',
                                'success');
                            // Atau lakukan sesuatu setelah berhasil menghapus, seperti memuat ulang halaman
                            // window.location.reload();
                        },
                        error: function(xhr) {
                            // Tampilkan pesan error jika terjadi kesalahan saat menghapus
                            Swal.fire('Error!',
                                'There was an error deleting the item.', 'error'
                            );
                        }
                    });
                }
            });
        });
    });
</script> --}}
