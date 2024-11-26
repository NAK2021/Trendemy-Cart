@extends('client.main')

@section('title', 'Đăng Nhập')

@section('styles')
    <style>
        #main {
            margin-top: 0;
        }

        body {
            background: #f8f9fd;
            user-select: none;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .wrapper {
            min-width: 450px;
        }

        input {
            box-shadow: none !important;
        }
    </style>
@endsection

@section('header', '')

@section('main')
    <section class="wrapper">
        <div class="card bg-light" style="border-radius: 1rem;">
            <div class="p-3">
                <a href="{{ route('home') }}"><i class="fas fa-angle-left"></i></a>
            </div>
            <div class="card-body p-3 text-center">
                <h2 class="fw-bold mb-3 text-uppercase">Đăng Nhập</h2>

                @if (session('error'))
                    <p class="text-danger mb-3">{{ session('error') }}</p>
                @endif

                <form method="POST">
                    @csrf

                    <div class="form-floating mb-4">
                        <input type="text" id="email" name="email" placeholder="" autofocus
                            class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" />
                        <label for="email">Email</label>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-floating mb-4">
                        <input type="password" id="password" name="password" placeholder=""
                            class="form-control @error('password') is-invalid @enderror" />
                        <label for="password">Mật khẩu</label>
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row mb-4">
                        <div class="col d-flex">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember-me" />
                                <label class="form-check-label text-decoration-none" for="remember-me">
                                    Lưu mật khẩu
                                </label>
                            </div>
                        </div>

                        <div class="col text-end">
                            <a href="#!" class="text-decoration-none">Quên mật khẩu?</a>
                        </div>
                    </div>

                    <span class="d-inline-block">
                        <button type="submit" class="btn btn-primary btn-block" data-mdb-ripple-init>
                            Đăng Nhập
                        </button>
                    </span>
                </form>
                <div>
                    <p class="mt-3">
                        Bạn chưa có tài khoản?
                        <a href="{{ route('register') }}" class="fw-bold text-decoration-none">
                            Đăng ký
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('footer', '')
