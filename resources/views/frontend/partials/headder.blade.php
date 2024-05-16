    <!-- Topbar Start -->
    {{-- <div class="container-fluid"> --}}
    <div>

        <div class="announcement-bar">
            <div class="announcement-content">
                <p>THE DEAL - Choose any 5+ items, get 25% off. Use promo code: <strong>thedeal</strong></p>
                <button class="close-btn">&times;</button>
            </div>
        </div>
        {{-- <div class="row bg-secondary py-1 px-xl-5">
            <div class="col-lg-6 d-none d-lg-block">
                <div class="d-inline-flex align-items-center h-100">
                    <a class="text-body mr-3" href="">About</a>
                    <a class="text-body mr-3" href="">Contact</a>
                    <a class="text-body mr-3" href="">Help</a>
                    <a class="text-body mr-3" href="">FAQs</a>
                </div>
            </div>
            <div class="col-lg-6 text-center text-lg-right">
                <div class="d-inline-flex align-items-center">
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">My
                            Account</button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <button class="dropdown-item" type="button">Sign in</button>
                            <button class="dropdown-item" type="button">Sign up</button>
                        </div>
                    </div>
                    <div class="btn-group mx-2">
                        <button type="button" class="btn btn-sm btn-light dropdown-toggle"
                            data-toggle="dropdown">USD</button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <button class="dropdown-item" type="button">EUR</button>
                            <button class="dropdown-item" type="button">GBP</button>
                            <button class="dropdown-item" type="button">CAD</button>
                        </div>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-light dropdown-toggle"
                            data-toggle="dropdown">EN</button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <button class="dropdown-item" type="button">FR</button>
                            <button class="dropdown-item" type="button">AR</button>
                            <button class="dropdown-item" type="button">RU</button>
                        </div>
                    </div>
                </div>
                <div class="d-inline-flex align-items-center d-block d-lg-none">
                    <a href="" class="btn px-0 ml-2">
                        <i class="fas fa-heart text-dark"></i>
                        <span class="badge text-dark border border-dark rounded-circle"
                            style="padding-bottom: 2px;">0</span>
                    </a>
                    <a href="{{ route('shop.product-cart') }}" class="btn px-0 ml-2">
                        <i class="fas fa-shopping-cart text-dark"></i>
                        <span class="badge text-dark border border-dark rounded-circle"
                            style="padding-bottom: 2px;">0</span>
                    </a>
                </div>
            </div>
        </div> --}}
        {{-- <div class="row align-items-center bg-light py-3 px-xl-5 d-none d-lg-flex">
            <div class="col-lg-4">
                <a href="" class="text-decoration-none">
                    <span class="h1 text-uppercase text-primary bg-dark px-2">MPC</span>
                    <span class="h1 text-uppercase text-dark bg-primary px-2 ml-n1">Clothing</span>
                </a>
            </div>
            <div class="col-lg-4 col-6 text-left">
                <form action="">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for products">
                        <div class="input-group-append">
                            <span class="input-group-text bg-transparent text-primary">
                                <i class="fa fa-search"></i>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-4 col-6 text-right">
                <p class="m-0">Customer Service</p>
                <h5 class="m-0">+012 345 6789</h5>
            </div>
        </div> --}}


    </div>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-2">
        <div class="container">
            <a class="navbar-brand" href="{{route('home')}}">
                <img src="{{ asset('images/logo.jpeg') }}" alt="MPC Clothing Logo" class="logo">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item {{ Route::is('home') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item {{ Route::is('buy-bulk.index') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('buy-bulk.index') }}">Buy Blank</a>
                    </li>
                    <li class="nav-item {{ Route::is('catalog-order.index') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('catalog-order.index') }}">Order Form Catalog</a>
                    </li>
                    <li class="nav-item {{ Route::is('custom-order.create') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('custom-order.create') }}">Custom Order</a>
                    </li>
                    <li class="nav-item {{ Route::is('faq') ? 'active' : '' }}">
                        <a class="nav-link" href="#">FAQs</a>
                    </li>
                    <li class="nav-item {{ Route::is('about_us') ? 'active' : '' }}">
                        <a class="nav-link" href="#">About Us</a>
                    </li>
                    <li class="nav-item {{ Route::is('contact_us') ? 'active' : '' }}">
                        <a class="nav-link" href="#">Contact Us</a>
                    </li>
                </ul>
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a href="{{ route('shop.product-cart') }}" class="nav-link">
                            <i class="fas fa-shopping-cart"></i>
                            <span id="cartBadge" class="badge badge-pill badge-primary">
                                @if (session('totalProduct'))
                                    {{ session('totalProduct') }}
                                @else
                                    0
                                @endif
                            </span>
                        </a>
                    </li>
                    @if (isset(auth()->user()->name))
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" >
                                {{ auth()->user()->name }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('order.index') }}">Orders</a>
                                <a class="dropdown-item" href="{{ route('custom-order.index') }}">Custom Orders</a>
                                <div class="dropdown-divider"></div>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Logout</button>
                                </form>
                            </div>
                        </li>
                    @else
                        <li class="nav-item">
                            <a href="{{ route('login') }}" class="nav-link">Login</a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('register') }}" class="nav-link">Create Account</a>
                        </li>
                    @endif

                </ul>
            </div>
        </div>
    </nav>
    {{-- <div class="container-fluid bg-dark mb-30">
        <div class="row px-xl-5">

            <div class="col-lg-12">
                <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3 py-lg-0 px-0">

                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>


                    <div class="col-lg-4 d-flex justify-content-center justify-content-lg-start">
                        <a href="#" class="navbar-brand">
                            <img src="{{ asset('images/logo.jpeg') }}" alt="MPC Clothing Logo" class="logo">
                        </a>
                    </div>

                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <a href="{{ route('home') }}"
                                class="nav-item nav-link {{ Route::is('home') ? 'active' : '' }}">Home</a>
                            <a href="{{ route('buy-bulk.index') }}"
                                class="nav-item nav-link {{ Route::is('buy-bulk.index') ? 'active' : '' }}">
                                Buy Blank</a>
                            <a href="{{ route('catalog-order.index') }}"
                                class="nav-item nav-link {{ Route::is('catalog-order.index') ? 'active' : '' }}">Order
                                Form
                                Catalog</a>
                            <a href="{{ route('custom-order.create') }}"
                                class="nav-item nav-link {{ Route::is('custom-order.create') ? 'active' : '' }}">Custom
                                Order</a>
                            <a href="contact.html"
                                class="nav-item nav-link {{ Route::is('faq') ? 'active' : '' }}">FAQs</a>
                            <a href="contact.html"
                                class="nav-item nav-link {{ Route::is('about_us') ? 'active' : '' }}">About Us</a>

                            <a href="contact.html"
                                class="nav-item nav-link {{ Route::is('contact_us') ? 'active' : '' }}">Contact Us</a>


                        </div>

                        <div class="navbar-nav ml-auto py-0 d-none d-lg-block">



                            <a href="{{ route('shop.product-cart') }}" class="btn px-0 ml-3">
                                <i class="fas fa-shopping-cart text-primary"></i>
                                <span id="cartBadge" class="badge text-secondary border border-secondary rounded-circle"
                                    style="padding-bottom: 2px;">
                                    @if (session('totalProduct'))
                                        {{ session('totalProduct') }}
                                    @else
                                        0
                                    @endif
                                </span>
                            </a>
                            @if (isset(auth()->user()->name))
                                <div class="btn-group  px-4">
                                    <button type="button" class="btn btn-sm btn-primary dropdown-toggle"
                                        data-toggle="dropdown">{{ auth()->user()->name }}</button>
                                    <div class="dropdown-menu dropdown-menu-left">
                                        <a href="{{ route('order.index') }}"
                                            class="btn btn-sm dropdown-item">Orders</a>
                                        <a href="{{ route('custom-order.index') }}"
                                            class="btn btn-sm dropdown-item">Custom Orders</a>
                                        <span class=" py-2">
                                            <form action="{{ route('logout') }}" method="POST">
                                                @csrf
                                                <input type="submit" class="btn btn-primary btn-block" value="Logout">
                                            </form>
                                        </span>
                                    </div>
                                </div>
                            @else
                                <a href="{{ route('login') }}" style="color: white" class="btn px-4">Login</a>
                            @endif
                        </div>
                    </div>

                </nav>
            </div>
        </div>
    </div> --}}
    <!-- Navbar End -->
