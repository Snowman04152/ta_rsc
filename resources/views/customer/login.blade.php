<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/sass/app.scss')
   
</head>

<body class="bg-light ">
    @vite('resources/js/app.js')
</body>
<div class="container w-custom mt-0 mt-md-5 mt-lg-5 p-4 p-md-0 p-lg-4" >
    <div class="row justify-content-center g-0 border ">
        <div class="col-12  col-md-12 col-lg-6 col-xl-6 ">
            <img src="{{Vite::asset('resources/images/image19.png')}}" class="img-fluid " alt="">      
        </div>

        <div class="col-12 col-md-12 col-lg-6 col-xl-6 bg-light p-4">
            <div class="fw-bold text-center my-2 h5 ">Login</div>
            <form method="POST" action="login">
                @csrf
                <div class="mb-1 ">
                    <label for="email" class="fw-bold"> Email</label>
                        <input id="email" type="email" class="form-control py-2 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Masukkan Email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>
                <div class="mb-1 justify-content-center">
                    <label for="password" class="fw-bold"> Password</label>
                        <input id="password" type="password" class="form-control  @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Masukkan Password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                </div>
                <div class="text-end ">
                    <a class="text-decoration-none fw-bold greenlight" href='#modal-add-varian'  data-bs-toggle="modal" data-bs-target="#modal-add-varian">Lupa Password</a>
                </div>
                <div class="modal fade" id="modal-add-varian" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header modal-b">
                                <div class="h4 my-3 fw-bold">Lupa Password</div>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body px-5">
                                {{-- <div class="h4 text-center">Hubungi Admin</div> --}}
                                <a href="https://api.whatsapp.com/send?phone=62838393994&text=Reset Password" class="btn btn-success d-grid col-6 mx-auto"><i class="bi bi-whatsapp"></i> Hubungi Admin </a>
                                {{-- <div class="my-4">
                                    <div class="fw-bold"><span>Email Terdaftar</span>
                                        <input type="email" class="form-control my-2" placeholder="Masukkan Email Terdaftar  ">
                                    </div>
                                </div> --}}
                            </div>
                            {{-- <div class="modal-footer modal-t">
                                <button type="button " class="btn btn-primary d-grid col-6 mx-auto">kirim OTP</button>
                            </div> --}}
                        </div>
                    </div>
                </div>
                <div class="row mb-0">
                    <div class="col-16">
                        <button type="submit" class="btn btn-greenlight fw-bold  mt-3 py-2 col-12"><div class="greendark">Login</div>
                        </button>
                        <div class="d-flex my-2">
                            <p class="fw-bold">Belum Punya Akun? &nbsp</p>
                            <a class="text-decoration-none greenlight" href="{{route('user.index')}}"></i>
                                Register
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</html>