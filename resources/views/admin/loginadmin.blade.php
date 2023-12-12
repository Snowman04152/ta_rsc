<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/sass/app.scss')
</head>

<body class="bg-light">
    @vite('resources/js/app.js')
</body>
<div class="container w-custom mt-0 mt-md-5 mt-lg-5 p-4 p-md-0 p-lg-4" >
    <div class="row justify-content-center g-0 border ">
        <div class="col-12  col-md-12 col-lg-6 col-xl-6 ">
            <img src="{{Vite::asset('resources/images/image19.png')}}" class="img-fluid " alt="">      
        </div>
        <div class="col-12 col-md-12 col-lg-6 col-xl-6 bg-light p-4">
            <div class="fw-bold text-center my-2 h5 ">Login Admin</div>
                <form method="POST" action="login">
                    @csrf
                    <div class="mb-1 mt-3 justify-content-center">
                        <label for="email" class="fw-bold"> Email</label>
                            <input id="email" type="email" class="form-control py-2 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Enter Your Email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                    <div class="mb-1 justify-content-center">
                        <label for="password" class="fw-bold"> Password</label>
                            <input id="password" type="password" class="form-control  @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Enter Your Password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                    </div>
                    <div class="row mb-0">
                        <div class="col-16">
                            <button type="submit" class="btn btn-greenlight fw-bold  mt-3 py-2 col-12"><div class="greendark">

                                {{ __('Login') }}
                            </div>
                            </button>
                            @if (Route::has('password.request'))
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</html>