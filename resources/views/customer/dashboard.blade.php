@extends('customer.layouts.app')
@section('content')
    <div class="container-image" style="height: 672px">
        <div class="container ">
            <div class="d-flex align-items-center" style="height: 672px;">
                <div>
                    <h1 class="text-light fw-bold " style=" text-shadow: 1px 2px 5px black;">Di Atap, Harapan Baru Tumbuh!
                        </h2>
                        <div>
                            <a class=" btn btn-lg btn-greenlight shadow text-decoration-none fw-bold" href=""><div class="greendark">
                                Beli
                                Sekarang
                            </div></a>
                        </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container p-5">
        <div class="h5 text-center">Tentang Kami</div>
        <div class="h2 fw-bold text-center">Apa itu Rooftop Farming Centre?</div>
        <div class="row g-5 mt-5">
            <div class="col-12 col-md-6 col-lg-6 "><img  src="{{ Vite::asset('resources/images/rooftop.png') }}"
                    class="img-fluid shadow-lg" alt=""></div>
            <div class=" col-12 col-md-6 col-lg-6 align-items-center d-flex fw-bold">
                Rooftop Farming Center (RFC) merupakan pusat pertanian milik Institut
                Teknologi Telkom Surabaya yang berbasis Internet of Things (IoT). Kami percaya bahwa dengan menggabungkan
                inovasi pertanian perkotaan dan teknologi IoT, kita dapat mengatasi tantangan pangan dan lingkungan yang
                dihadapi oleh kota-kota modern. Dengan teknologi IoT yang terintegrasi kami dapat secara otomatis memantau
                dan mengontrol aspek penting seperti irigasi, nutrisi, suhu, dan pencahayaan tanaman sehingga memungkinkan
                untuk menciptakan kondisi pertumbuhan yang optimal, meningkatkan produktivitas, dan mengurangi penggunaan
                sumber daya secara efisien. Komitmen kami tidak hanya terbatas pada pertanian berkelanjutan, tetapi juga
                pada edukasi dan pelatihan masyarakat tentang manfaat pertanian perkotaan dan teknologi IoT.

            </div>
        </div>
        <div class="h5 text-center mt-5"> Produk </div>
        <div class="h2 fw-bold text-center "> Dapatkan berbagai produk hasil budidaya ikan buah dan sayuran segar disini!
        </div>
        <div class="row my-5">
            <div class="col-9 col-md-4 col-lg-4"><img src="{{ Vite::asset('resources/images/sayur.png') }}" class="image-fluid"
                    alt=""></div>
            <div class="col-9 col-md-8 col-lg-8">
                <div class="fw-bold">Buah dan Sayur Hidroponik</div>
                <div class="">Dari sayuran segar hingga buah-buahan yang lezat, sistem hidroponik kami memastikan Anda
                    mendapatkan hasil panen yang berkualitas. Rasakan sendiri rasa segar dan cita rasa murni dari produk
                    pertanian rooftop kami.
                </div>
                <div class="btn btn-greenlight fw-bold shadow mt-2 "> <a class="text-decoration-none text-light" href=""><div class="greendark ">Beli
                        Sekarang</div> </a></div>
            </div>
        </div>
        <div class="row my-5">
            <div class="col-9 col-md-8 col-lg-8">
                <div class="fw-bold">Ikan Air Tawar</div>
                <div class="">Menciptakan lingkungan aquaponik yang seimbang, di mana ikan memberikan nutrisi pada
                    tanaman, sementara tanaman membersihkan air untuk ikan.
                </div>
                <a class=" btn btn-greenlight fw-bold shadow mt-2 text-decoration-none text-light" href=""><div class="greendark ">  Beli
                        Sekarang</div> </a>
            </div>
            <div class="col-9 col-md-4 col-lg-4">
                <img src="{{ Vite::asset('resources/images/ikan.png') }}" class="image-fluid float-end"
                    alt=""></div>
        </div>
        <div class="h5 text-center mt-5"> Testimoni </div>
        <div class="h2 fw-bold text-center "> Dengarkan Kata Mereka </div>
        <div class="row mt-5">
            <div class="col-4 col-md-4">
                <div class="card rounded-4 bg-light shadow-lg p-4">
                    <div class="d-flex "><i class="bi-person-circle me-2"></i> <a
                            class="h3 fw-bold text-decoration-none">Jane Cooper</a></div>
                    <div class="text mt-4">Lorem ipsum dolor sit amet consectetur. Odio vestibulum id diam vel feugiat
                        eu
                        ullamcorper eget. Arcu amet amet tempor egestas. Platea orci amet dictum ut luctus amet. Et dui
                        est ultrices nulla elementum accumsan.</div>
                </div>
            </div>
            <div class="col-4 col-md-4 ">
                <div class="card rounded-4 bg-light shadow-lg p-4">
                    <div class="d-flex "><i class="bi-person-circle me-2"></i> <a
                            class="h3 fw-bold text-decoration-none">Jane Cooper</a></div>
                    <div class="text mt-4">Lorem ipsum dolor sit amet consectetur. Odio vestibulum id diam vel feugiat
                        eu
                        ullamcorper eget. Arcu amet amet tempor egestas. Platea orci amet dictum ut luctus amet. Et dui
                        est ultrices nulla elementum accumsan.</div>
                </div>
            </div>
            <div class="col-4 col-md-4">
                <div class="card rounded-4 bg-light shadow-lg p-4">
                    <div class="d-flex "><i class="bi-person-circle me-2"></i> <a
                            class="h3 fw-bold text-decoration-none">Jane Cooper</a></div>
                    <div class="text mt-4">Lorem ipsum dolor sit amet consectetur. Odio vestibulum id diam vel feugiat
                        eu
                        ullamcorper eget. Arcu amet amet tempor egestas. Platea orci amet dictum ut luctus amet. Et dui
                        est ultrices nulla elementum accumsan.</div>
                </div>
            </div>
        </div>
        <div class="h4 text-center mt-5">Galeri</div>
        <div class="h1 text-center">Bagaimana Perjalanan Kami?</div>
        <div class="d-flex gap-5 p-5">
            <img src="{{ Vite::asset('resources/images/ghost.png') }}" class="rounded w-25" alt="...">
            <img src="{{ Vite::asset('resources/images/ghost.png') }}" class="rounded w-25" alt="...">
            <img src="{{ Vite::asset('resources/images/ghost.png') }}" class="rounded w-25" alt="...">
        </div>
    </div>
@endsection
