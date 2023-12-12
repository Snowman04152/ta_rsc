@extends('customer.layouts.app')
@section('content')
    <div class="container p-4">
        <h3>Profil</h3>
        <div class="row">
            <div class="col-12 col-md-4 col-lg-4 ">
                @include('customer.layouts.side_profile')
            </div>
            <div class="col-12 col-md-8 col-lg-8">
                <div class="card p-3">
                    <div class="row">
                        <div class="col-12 col-md-4 col-lg-4">
                            <img src="{{ asset('storage/files/' . $user->encrypted_filename) }}" class="img-fluid rounded-2 shadow-lg">
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
                                        <th>Tanggal Lahir </th>
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
                            <div class="btn btn-greenlight fw-bold edit-profil" style="color:#598420 ;" data-foto="{{ $user->encrypted_filename }}"
                                data-nama_lengkap="{{ $user->nama_lengkap }}" data-username="{{ $user->username }}"
                                data-kelamin="{{ $user->jenis_kelamin }}" data-tanggal="{{ $user->tanggal_lahir }}"
                                data-telp="{{ $user->telp_user }}" data-email="{{ $user->email }}" data-bs-toggle="modal"
                                data-bs-target='#modal-edit-profil'>Edit
                                Profil
                            </div>
                            <div class="btn btn-greenlight fw-bold" style="color:#598420 ;" data-bs-toggle="modal" data-bs-target='#modal-edit-password'>Ubah
                                Kata
                                Sandi</div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-between my-3">
                    <div class="h5 fw-bold">Daftar Alamat</div>
                    <div class="btn btn-greenlight fw-bold" style="color:#598420 ;" data-bs-toggle="modal" data-bs-target='#modal-add-alamat'>Tambah Alamat
                    </div>
                </div>
                @foreach ($alamat as $alamats)
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
                                    <span>{{ $alamats->nama_jalan }}</span>
                                    <span>Kecamatan {{ ucwords(strtolower($alamats->kecamatan)) }}
                                        {{ ucwords(strtolower($alamats->kabupaten)) }},</span>
                                    <span>{{ ucwords(strtolower($alamats->provinsi)) }},</span>
                                    <span>{{ $alamats->kode_pos }}</span>
                                </div>
                            </div>
                            <div class="dropdown">
                                <i class='bi-three-dots btn ' data-bs-toggle="dropdown" aria-expanded="false"></i>
                                <ul class="dropdown-menu">
                                    <li><button class="dropdown-item edit-alamat" data-label="{{ $alamats->label }}"
                                            data-id_alamat="{{ $alamats->id }}" data-penerima="{{ $alamats->penerima }}"
                                            data-telepon="{{ $alamats->telepon }}"
                                            data-nama_jalan="{{ $alamats->nama_jalan }}"
                                            data-kecamatan="{{ $alamats->kecamatan }}"
                                            data-kabupaten="{{ $alamats->kabupaten }}"
                                            data-provinsi="{{ $alamats->provinsi }}"
                                            data-kode_pos="{{ $alamats->kode_pos }}"data-bs-toggle="modal"
                                            data-bs-target='#modal-edit-alamat'>Edit</button></li>
                                    <li>
                                        {{-- <form action="{{ route('profil.destroy', ['profil' => $alamats->id]) }}"
                                            method="POST">
                                            @method('delete')
                                            @csrf

                                            <button type="submit" class="dropdown-item">Delete</button> --}}
                                    </li>
                                    </form>
                                </ul>
                            </div>
                        </div>
                        
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-edit-profil" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Profile</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="">
                        <form method="POST" enctype="multipart/form-data"
                            action="{{ route('profil.update', ['profil' => $user->id]) }}" id="edit-profil-form">
                            @method('put')
                            @csrf
                            <div class="">
                                <label for="formFile" class="form-label fw-bold">Foto</label>
                                <input class="form-control" type="file" id="edit_profil_foto" name='foto'>
                            </div>
                            <div class="row my-2">
                                <div class="col-md-6 fw-bold"><span>Nama Lengkap</span>
                                    <input type="text" class="form-control my-2" placeholder="Isi Nama Lengkap"
                                        id="edit_profil_nama_lengkap" name='nama_lengkap'>
                                </div>
                                <div class="col-md-6  fw-bold"><span>Username</span>
                                    <input type="text" class="form-control my-2" placeholder="Isi Username"
                                        id="edit_profil_username" name='username'>
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col-md-6 fw-bold"><span>Jenis Kelamin</span>
                                    <select class="form-select my-2" aria-label="Default select example"
                                        id="edit_profil_kelamin" name='kelamin'>
                                        <option selected disabled>Pilih Jenis Kelamin</option>
                                        <option value="1">Laki - Laki</option>
                                        <option value="0">Perempuan</option>
                                    </select>
                                </div>
                                <div class="col-md-6  fw-bold"><span>Tanggal Lahir</span>
                                    <input type="date" name='tanggal' class="form-control my-2"
                                        id="edit_profil_tanggal">
                                </div>
                            </div>
                            <div class="row my-2">
                                <div class="col-md-6 fw-bold"><span>No Telepon</span>
                                    <input type="text" name='telp' class="form-control my-2"
                                        placeholder="Isi No Telepon" id="edit_profil_telp">
                                </div>
                                <div class="col-md-6  fw-bold"><span>Email</span>
                                    <input type="email" name='email' class="form-control my-2"
                                        placeholder="Isi Email" id="edit_profil_email">
                                </div>
                            </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-edit-password" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Password</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="">
                        <form method="POST" action="{{ route('profil.editpass') }}">
                            @method('put')
                            @csrf
                            <div class="row">
                                <div class="fw-bold">
                                    <span>Kata Sandi Saat Ini</span>
                                    <input type="password" name='password_now' required
                                        class="form-control my-2 @error('password_now') is-invalid @enderror"
                                        placeholder="Isi Kata Sandi Saat Ini">
                                    @error('password_now')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <span>Kata Sandi Baru</span>
                                    <input id="password" type="password"
                                        class="form-control my-2  @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="current-password" placeholder="Password Baru">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    <span>Konfirmasi Kata Sandi Baru</span>
                                    <input id="password_confirmation" type="password"
                                        class="form-control my-2  @error('password_confirmation') is-invalid @enderror"
                                        name="password_confirmation" required autocomplete="current-passwordValid"
                                        placeholder="Konfirmasi Password">
                                    @error('password_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-add-alamat" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Alamat</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="">
                        <div class="row">
                            <div class="fw-bold">
                                <form action="{{ route('profil.store') }}" method="POST">
                                    @csrf
                                    <span>Label, Contoh: Rumah, Kantor, dll. </span>
                                    <input name="label" type="text" class="form-control my-2"
                                        placeholder="Isi Label">
                                    <span>Provinsi</span>
                                    <select class="form-select my-2" aria-label="Default select example" id="provinsi"
                                        name='provinsi'>
                                        <option>Pilih</option>
                                    </select>
                                    <span>Kabupaten</span>
                                    <select class="form-select my-2" aria-label="Default select example" id="kabupaten"
                                        name='kabupaten'>
                                        <option>Pilih</option>
                                    </select>
                                    <span>Kecamatan</span>
                                    <select class="form-select my-2" aria-label="Default select example" id="kecamatan"
                                        name='kecamatan'>
                                        <option>Pilih</option>
                                    </select>
                                    <span>Nama Jalan</span>
                                    <input name="nama_jalan" type="text" class="form-control my-2"
                                        placeholder="Isi Jalan">
                                    <span>Kode Pos</span>
                                    <input name="kodepos" type="text" class="form-control my-2"
                                        placeholder="Isi Kode Pos">
                                    <span>Nama Penerima</span>
                                    <input name="penerima" type="text" class="form-control my-2"
                                        placeholder="Isi Penerima">
                                    <span>Telepon Penerima</span>
                                    <input name="telepon" type="text" class="form-control my-2"
                                        placeholder="Isi Telepon">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Tambahkan</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-edit-alamat" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Alamat</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="">
                        <div class="row">
                            <div class="fw-bold">
                                <form action="{{ route('profil.updateAlamat') }}" method="POST">
                                    @method('put')
                                    @csrf
                                    <input type="number" name='id' id='edit-alamat-id' hidden>
                                    <span>Label, Contoh: Rumah, Kantor, dll. </span>
                                    <input name="label" id="edit-alamat-label" type="text"
                                        class="form-control my-2" placeholder="Isi Label">
                                    <span>Provinsi</span>
                                    <select class="form-select my-2" aria-label="Default select example" name='provinsi'
                                        id="edit-alamat-provinsi">
                                        <option>Pilih</option>
                                    </select>
                                    <span>Kabupaten</span>
                                    <select class="form-select my-2" aria-label="Default select example" name='kabupaten'
                                        id="edit-alamat-kabupaten">
                                        <option>Pilih</option>
                                    </select>
                                    <span>Kecamatan</span>
                                    <select class="form-select my-2" aria-label="Default select example" name='kecamatan'
                                        id="edit-alamat-kecamatan">
                                        <option>Pilih</option>
                                    </select>
                                    <span>Nama Jalan</span>
                                    <input name="nama_jalan" type="text" class="form-control my-2"
                                        placeholder="Isi Jalan" id="edit-alamat-nama_jalan">
                                    <span>Kode Pos</span>
                                    <input name="kodepos" type="text" class="form-control my-2"
                                        placeholder="Isi Kode Pos" id="edit-alamat-kodepos">
                                    <span>Nama Penerima</span>
                                    <input name="penerima" type="text" class="form-control my-2"
                                        placeholder="Isi Penerima" id="edit-alamat-penerima">
                                    <span>Telepon Penerima</span>
                                    <input name="telepon" type="text" class="form-control my-2"
                                        placeholder="Isi Telepon" id="edit-alamat-telepon">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    @if ($errors->has('password_now') || $errors->has('password') || $errors->has('password_confirmation'))
        <script type="module">
            var modal = new bootstrap.Modal(document.getElementById('modal-edit-password'));
            modal.show();
        </script>
    @endif
@endsection
<script type="module">
    document.addEventListener('click', function(event) {
        if (event.target.matches('.edit-profil')) {

            let nama_lengkap = event.target.dataset.nama_lengkap;
            let username = event.target.dataset.username;
            let kelamin = event.target.dataset.kelamin;
            let tanggal = event.target.dataset.tanggal;
            let telp = event.target.dataset.telp;
            let email = event.target.dataset.email;

            let editProfilForm = document.getElementById('edit_profil_form');
            let IdInput = document.getElementById('edit_profil_id');
            let fotoInput = document.getElementById('edit_profil_foto');
            let nama_lengkapInput = document.getElementById('edit_profil_nama_lengkap');
            let usernameInput = document.getElementById('edit_profil_username');
            let kelaminInput = document.querySelector('select[id="edit_profil_kelamin"]');
            let tanggalInput = document.getElementById('edit_profil_tanggal');
            let telpInput = document.getElementById('edit_profil_telp');
            let emailInput = document.getElementById('edit_profil_email');


            nama_lengkapInput.value = nama_lengkap;
            usernameInput.value = username;
            kelaminInput.value = kelamin;
            tanggalInput.value = tanggal;
            telpInput.value = telp;
            emailInput.value = email;

            // var modal = document.getElementById('modal-edit-profil');
            // var bootstrapModal = new bootstrap.Modal(modal);
            // bootstrapModal.show();
        }
    });

    function set_provinsi_to_element(idEl, provinsi) {
        // var selected = (dataasli == element.id) ? "selected":""
        var tampung =
            '<option disabled selected>Pilih</option>';
        provinsi.forEach(element => {
            tampung += `<option data-reg="${element.id}" value="${element.name}">${element.name}</option>`;
        });
        document.getElementById(idEl).innerHTML = tampung;
    }

    function set_kabupaten_to_element(idEl, kabupaten, selected_value = '') {
        var tampung =
            `<option disabled ${selected_value === '' ? 'selected' : ''}>Pilih</option>`;
        kabupaten.forEach(element => {
            tampung +=
                `<option data-dist="${element.id}" ${selected_value === element.name ? 'selected' : ''} value="${element.name}">${element.name}</option>`;
        });
        document.getElementById(idEl).innerHTML = tampung;
    }

    function set_kecamatan_to_element(idEl, kecamatan, selected_value = '') {
        var tampung =
            `<option disabled ${selected_value === '' ? 'selected' : ''}>Pilih</option>`;
        kecamatan.forEach(element => {
            tampung +=
                `<option data-dist="${element.id}" ${selected_value === element.name ? 'selected' : ''} value="${element.name}">${element.name}</option>`;
        });
        document.getElementById(idEl).innerHTML = tampung;
    }

    // Fetch API 

    function fetch_provinsi(idEl) {
        return fetch(`https://snowman04152.github.io/api-wilayah-indonesia/api/provinces.json`)
            .then(response => response.json())
            .then(provinces => {
                set_provinsi_to_element(idEl, provinces)
            })
    }

    function fetch_kabupaten(provinsi, idEl) {
        return fetch(`https://snowman04152.github.io/api-wilayah-indonesia/api/regencies/${provinsi}.json`)
            .then(response => response.json())
            .then(regencies => {
                set_kabupaten_to_element(idEl, regencies)
            })
    }

    function fetch_kecamatan(kabupaten, idEl) {
        return fetch(`https://snowman04152.github.io/api-wilayah-indonesia/api/districts/${kabupaten}.json`)
            .then(response => response.json())
            .then(districts => {
                set_kecamatan_to_element(idEl, districts)
            })
    }

    fetch_provinsi('provinsi')
    const selectProvinsi = document.getElementById('provinsi');
    selectProvinsi.addEventListener('change', (e) => {
        var provinsi = e.target.options[e.target.selectedIndex].dataset.reg;
        fetch_kabupaten(provinsi, 'kabupaten')
    });

    const selectKabupaten = document.getElementById('kabupaten');
    selectKabupaten.addEventListener('change', (e) => {
        var kabupaten = e.target.options[e.target.selectedIndex].dataset.dist;
        fetch_kecamatan(kabupaten, 'kecamatan')
    });

    //siapin buat edit
    fetch_provinsi('edit-alamat-provinsi')

    const selectEditProvinsi = document.getElementById('edit-alamat-provinsi');
    selectEditProvinsi.addEventListener('change', (e) => {
        var provinsi = e.target.options[e.target.selectedIndex].dataset.reg;
        fetch_kabupaten(provinsi, 'edit-alamat-kabupaten')
        set_kecamatan_to_element('edit-alamat-kecamatan', [])
    });

    const selectEditKabupaten = document.getElementById('edit-alamat-kabupaten');
    selectEditKabupaten.addEventListener('change', (e) => {
        var kabupaten = e.target.options[e.target.selectedIndex].dataset.dist;
        fetch_kecamatan(kabupaten, 'edit-alamat-kecamatan')
    });

    document.addEventListener('click', function(event) {
        if (event.target.matches('.edit-alamat')) {
            let id_alamat = event.target.dataset.id_alamat;
            let label = event.target.dataset.label;
            let penerima = event.target.dataset.penerima;
            let telepon = event.target.dataset.telepon;
            let nama_jalan = event.target.dataset.nama_jalan;
            let provinsi = event.target.dataset.provinsi;
            let kabupaten = event.target.dataset.kabupaten;
            let kecamatan = event.target.dataset.kecamatan;
            let kode_pos = event.target.dataset.kode_pos;


            let labelInput = document.getElementById('edit-alamat-label');
            let idInput = document.getElementById('edit-alamat-id');
            let penerimaInput = document.getElementById('edit-alamat-penerima');
            let teleponInput = document.getElementById('edit-alamat-telepon');
            let nama_jalanInput = document.getElementById('edit-alamat-nama_jalan');
            let kecamatanInput = document.querySelector('select[id="edit-alamat-kecamatan"]');
            let kabupatenInput = document.querySelector('select[id="edit-alamat-kabupaten"]');
            let provinsiInput = document.querySelector('select[id="edit-alamat-provinsi"]');
            let kode_posInput = document.getElementById('edit-alamat-kodepos');

            provinsiInput.value = provinsi;
            fetch_kabupaten(provinsiInput.options[provinsiInput.selectedIndex].dataset.reg,
                'edit-alamat-kabupaten', kabupaten).then(() => {
                kabupatenInput.value = kabupaten;

                fetch_kecamatan(kabupatenInput.options[kabupatenInput.selectedIndex].dataset.dist,
                    'edit-alamat-kecamatan', kecamatan).then(() => {
                    kecamatanInput.value = kecamatan;
                })
            })

            idInput.value = id_alamat;
            labelInput.value = label;
            penerimaInput.value = penerima;
            teleponInput.value = telepon;
            nama_jalanInput.value = nama_jalan;
            kode_posInput.value = kode_pos;

            // var modal = document.getElementById('modal-edit-profil');
            // var bootstrapModal = new bootstrap.Modal(modal);
            // bootstrapModal.show();
        }
    });
</script>



{{-- <script type="module">
    const selectProvinsi = document.getElementById('provinsi');
    fetch(`https://snowman04152.github.io/api-wilayah-indonesia/api/provinces.json`)
        .then(response => response.json())
        .then(provinces => {
            var data = provinces;
            var tampung =
                '<option disabled selected>Pilih</option>'; // Mengubah posisi value pada tag <option> dan menambahkan opsi default
            data.forEach(element => {
                tampung +=
                    `<option data-reg="${element.id}" value="${element.name}">${element.name}</option>`; // Mengubah posisi value dan menambahkan data-reg
            });
            document.getElementById('provinsi').innerHTML = tampung; // Mengubah cara penggunaan variabel
        })
</script>

<script type="module">
    const selectProvinsi = document.getElementById('provinsi');
    selectProvinsi.addEventListener('change', (e) => {
        var provinsi = e.target.options[e.target.selectedIndex].dataset.reg;
        fetch(`https://snowman04152.github.io/api-wilayah-indonesia/api/regencies/${provinsi}.json`)
            .then(response => response.json())
            .then(regencies => {
                var data = regencies;
                var tampung =
                    '<option disabled selected>Pilih</option>'; // Mengubah posisi value pada tag <option> dan menambahkan opsi default
                data.forEach(element => {
                    tampung +=
                        `<option data-dist="${element.id}" value="${element.name}">${element.name}</option>`; // Mengubah posisi value dan menambahkan data-reg
                });
                document.getElementById('kabupaten').innerHTML =
                tampung; // Mengubah cara penggunaan variabel
            })
    });

    const selectKabupaten = document.getElementById('kabupaten');
    selectKabupaten.addEventListener('change', (e) => {
        var kabupaten = e.target.options[e.target.selectedIndex].dataset.dist;
        fetch(`https://snowman04152.github.io/api-wilayah-indonesia/api/districts/${kabupaten}.json`)
            .then(response => response.json())
            .then(districts => {
                var data = districts;
                var tampung =
                    '<option disabled selected>Pilih</option>'; // Mengubah posisi value pada tag <option> dan menambahkan opsi default
                data.forEach(element => {
                    tampung +=
                        `<option data-dist="${element.id}" value="${element.name}">${element.name}</option>`; // Mengubah posisi value dan menambahkan data-reg
                });
                document.getElementById('kecamatan').innerHTML =
                tampung; // Mengubah cara penggunaan variabel
            })
    });
</script> --}}
