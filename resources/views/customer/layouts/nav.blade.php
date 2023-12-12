<nav class="navbar shadow navbar-expand-lg bg-body-tertiary sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('dashboard') }}"><img src="{{ Vite::asset('resources/images/rfc.png') }}"
                class="image-fluid ms-3" style="width:200px">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
            aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-center" id="navbarScroll">
            <ul class="navbar-nav mx-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                <li class="nav-item">
                    <a class="nav-link pe-5 active" aria-current="page" href="{{ route('dashboard') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link pe-5" href="{{ route('produkreg') }}">Produk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link pe-5" href="{{ route('lelangprod') }}">Lelang</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="">Bantuan</a>
                </li>
            </ul>
            <ul class="nav">
                @if (Route::has('login'))
                    @auth
                        <li class="nav-item">
                            <a class="nav-link " aria-current="page" href="{{ route('keranjang.index') }}"><i
                                    class="bi bi-cart fs-5 text-dark"></i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#"><i class="bi bi-bell fs-5 text-dark"></i></a>
                        </li>
                        <li class="nav-item">
                            @php
                                $user = App\Models\User::find(auth()->id());

                            @endphp
                            @if ($user->encrypted_filename != null)
                                <a  class="nav-link " href="{{ route('profil.index') }}"><img
                                        src="{{ asset('storage/files/' . $user->encrypted_filename) }}"
                                        class="image-fluid shadow rounded-circle " style="width: 30px; height:30px; "></a>
                            @else
                                <a class="nav-link" href="{{ route('profil.index') }}"><i
                                        class="bi bi-person-circle fs-5 text-dark"></i></a>
                            @endif
                        </li>
                    @else
                        @php
                            $routeName = \Route::currentRouteName();
                        @endphp
                        @if ($routeName == 'detailproduk')
                            <a class="btn btn-greenlight fw-medium" href="{{ route('loginuser') }}">
                                <div class="greendark fw-bold">
                                    <i class="bi bi-box-arrow-in-right  me-2"></i>Login
                                </div>
                            </a>
                        @else
                            <a class="btn btn-greenlight fw-medium" data-bs-toggle="modal" data-bs-target='#modal-login'>
                                <div class="greendark fw-bold">
                                    <i class="bi bi-box-arrow-in-right  me-2"></i>Login
                                </div>
                            </a>
                        @endif

                    @endauth
                @endif
            </ul>
        </div>
    </div>
</nav>
<div class="modal border-warning fade " id="modal-login" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header ">
                <div class="h5 text-dark mt-2 fw-bold">
                    Login
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="fw-bold text-center my-2 h5 "><img src="{{ Vite::asset('resources/images/rfc.png') }}"
                        class="image-fluid ms-3" style="width:200px"></div>
                <form method="POST" action="login">
                    @csrf
                    <div class="mb-1 ">
                        <label for="email" class="fw-bold"> Email</label>
                        <input id="email" type="email"
                            class="form-control py-2 @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email') }}" required autocomplete="email" placeholder="Masukkan Email"
                            autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-1 justify-content-center">
                        <label for="password" class="fw-bold"> Password</label>
                        <input id="password" type="password"
                            class="form-control  @error('password') is-invalid @enderror" name="password" required
                            autocomplete="current-password" placeholder="Masukkan Password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    {{-- <div class="text-end ">
                    <a class="text-decoration-none fw-bold greenlight" href='#modal-add-varian'  data-bs-toggle="modal" data-bs-target="#modal-add-varian">Lupa Password</a>
                </div> --}}
                    <div class="row mb-0">
                        <div class="col-16">
                            <button type="submit" class="btn btn-greenlight fw-bold  mt-3 py-2 col-12">
                                <div class="greendark">Login</div>
                            </button>
                            <div class="d-flex my-2">
                                <p class="fw-bold">Belum Punya Akun? &nbsp</p>
                                <a class="text-decoration-none greenlight" href="{{ route('user.index') }}"></i>
                                    Register
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
</div>
