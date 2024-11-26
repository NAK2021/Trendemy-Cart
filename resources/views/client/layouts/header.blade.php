<nav class="navbar navbar-expand-lg bg-body-tertiary px-3">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">
            <img src="{{ asset('assets/icons/logo.svg') }}" alt="" />
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav box-search-nav m-auto my-3 my-lg-0">
                <div class="form-search d-none d-sm-flex">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Input something..." />
                </div>
                <button class="btn btn-outline-light d-flex d-sm-none">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </ul>
            @auth
                <ul class="navbar-nav menu-user-nav gap-3">
                    <li class="nav-item">
                        <a href="#" class="btn-my-courses">Khóa học của tôi</a>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="btn-icon position-relative" id="btn-cart">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <span class="position-absolute translate-middle badge rounded-pill bg-danger" id="count-cart">
                                {{-- <span class="visually-hidden">count cart</span> --}}
                            </span>
                        </button>
                    </li>
                    {{-- <li class="nav-item">
                        <button class="btn-icon" id="btn-cart">
                            <i class="fa-solid fa-cart-shopping"></i>
                            <span id="count-cart">1</span>
                        </button>
                    </li> --}}
                    <li class="nav-item">
                        <button class="btn-icon">
                            <i class="fa-solid fa-bell"></i>
                        </button>
                    </li>
                    <li class="nav-item dropdown fw-semibold">
                        <div class="box-avatar-nav">
                            <img class="avatar" src="" alt="" />
                        </div>

                        <ul class="menu-user">
                            <li><a class="menu-item" href="#">Xin chào, {{ Auth::user()->name }}</a></li>
                            @if (Auth::user()->role === 'ADMIN')
                                <li><a class="menu-item" href="{{ route('admin.index') }}">Trang quản lý</a></li>
                            @endif
                            <li><a class="menu-item" href="#">Đổi Mật Khẩu</a></li>
                            <li><a class="menu-item" href="#">Đơn hàng</a></li>
                            <li><a class="menu-item" href="{{ route('logout') }}">Đăng Xuất</a></li>
                        </ul>
                    </li>
                </ul>
            @else
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="btn btn-outline-primary btn-icon text-white" href="{{ route('login') }}">
                            <i class="fa-solid fa-user"></i>
                        </a>
                    </li>
                </ul>
            @endauth
        </div>
    </div>
</nav>
