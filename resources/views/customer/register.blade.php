<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/sass/app.scss')
</head>

<body class="bg-light
">
    @vite('resources/js/app.js')
</body>
<div class="container w-custom mt-0 mt-md-5 mt-lg-5 p-4 p-md-0 p-lg-4 ">
    <div class="row justify-content-center g-0 border ">
        <div class="col-12 col-md-6 col-lg-6 col-xl-6 ">
            <img src="{{ Vite::asset('resources/images/image19.png') }}" class="img-fluid " alt="">
        </div>

        <div class="col-12 col-md-6 col-lg-6 col-xl-6 bg-light p-4">
            <div class="fw-bold text-center my-2 h5 ">Register </div>
            <form method="POST" action="{{ route('user.store') }}">
                @csrf

                <div class="mb-2 justify-content-center">
                    <label for="username" class="fw-bold"> Username</label>
                    <input type="text" id="username"
                        class="form-control py-2 @error('username') is-invalid @enderror" name="username" required
                        autocomplete="username" placeholder="Username" autofocus>
                    @error('username')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-2 ">
                    <label for="email" class="fw-bold"> Email</label>
                    <input type="email" id="email" class="form-control  @error('email') is-invalid @enderror"
                        name="email" required autocomplete="current-email" placeholder="Email">
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-2 ">
                    <label for="password_confirmation" class="fw-bold">Password</label>
                    <input id="password" type="password" class="form-control  @error('password') is-invalid @enderror"
                        name="password" required autocomplete="current-password" placeholder=" Password">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="mb-2 ">
                    <label for="password_confirmation" class="fw-bold">Konfirmasi Password</label>
                    <input id="password_confirmation" type="password"
                        class="form-control  @error('password_confirmation') is-invalid @enderror"
                        name="password_confirmation" required autocomplete="current-passwordValid"
                        placeholder="Konfirmasi Password">
                    @error('password_confirmation')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="row mb-0">
                    <div class="col-16">
                        <button type="submit" class="btn btn btn-greenlight fw-bold mt-1 py-2 col-12">
                            <div class="greendark">
                                Register
                            </div>
                        </button>
                        <div class="d-flex mt-3">
                            <div>
                                Sudah Punya Akun? &nbsp
                            </div>
                            <a class="text-decoration-none greenlight fw-bold" href="{{ route('loginuser') }}"></i>
                                 Login
                            </a>

                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>

</html>
