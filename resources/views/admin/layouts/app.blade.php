<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php $pageTitle = Session::get('pageTitle'); ?>
    <title>{{ $pageTitle }}</title>
    @vite('resources/sass/app.scss')
    @vite('resources/js/app.js')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
</head>

<body>
    <div class="container-fluid " style="background-color: #F6FBEF">
        <div class="row flex-nowrap">
            @include('admin.layouts.sidebar')
            @yield('content')
            @include('sweetalert::alert')
            @stack('scripts')
        </div>
    </div>

    @yield('custom-js')

</body>

</html>
