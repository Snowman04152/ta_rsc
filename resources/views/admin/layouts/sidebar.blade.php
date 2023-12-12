<div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-light">
    <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-dark min-vh-100">
        <a href="{{route('dashboardadmin')}}" class="d-flex align-items-center pb-3 mb-md-0 me-md-auto text-dark text-decoration-none">
            <img src="{{Vite::asset('resources/images/rfc.png')}}" class="img-fluid" alt="">
        </a>
        <ul class="nav nav-pills  flex-column mb-sm-auto mb-0 align-items-center align-items-sm-start" id="menu">
            <b>
                <li>
                    <a href="{{route('dashboardadmin')}}"  class="nav-link px-0 align-middle text-secondary">
                        <i class="fs-4 bi-house "></i> <span class="ms-1 d-none d-sm-inline  ">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('produk.index')}}" class="nav-link px-0 align-middle text-secondary">
                        <i class="fs-4 bi-gift"></i> <span class="ms-1 d-none d-sm-inline text-secondary ">Produk
                            Reguler</span></a>
                </li>
                <li>
                    <a href="{{route('lelang.index')}}"  class="nav-link px-0 align-middle text-secondary">
                        <i class="fs-4 bi-cash-coin"></i> <span
                            class="ms-1 d-none d-sm-inline text-secondary">Lelang</span></a>
                </li>
              
                <li>
                    <a href="#submenu1" data-bs-toggle="collapse"  class="nav-link px-0 align-middle text-secondary">
                        <i class="fs-4 bi-truck"></i> <span class="ms-1 d-none d-sm-inline text-secondary ">Transaksi</span>
                    </a>
                    <ul class="collapse nav  flex-column ms-1" id="submenu1" data-bs-parent="#menu">
                        <li class="w-100">
                            <a href="{{route('transaksi.index')}}" class="nav-link px-0"> <span class="d-none text-secondary d-sm-inline">Transaksi Produk</span></a>
                        </li>
                        <li>
                            <a href="{{route('transaksi.lelang.index')}}" class="nav-link px-0"> <span class="d-none text-secondary d-sm-inline">Transaksi Lelang</span></a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="{{route('customer.index')}}" class="nav-link px-0 align-middle text-secondary">
                        <i class="fs-4 bi-people"></i> <span class="ms-1 d-none d-sm-inline text-secondary ">Pembeli</span>
                    </a>
                </li>
                <li>
                    <a href="{{route('logout')}}" class="nav-link px-0 align-middle text-secondary">
                        <i class="fs-4 bi-box-arrow-right"></i> <span
                            class="ms-1 d-none d-sm-inline text-secondary ">Logout</span> </a>
                </li>
            </b>
        </ul>
    </div>
</div>

