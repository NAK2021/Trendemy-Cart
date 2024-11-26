@extends('client.main')

@section('title', 'Đăng Ký')

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

@section('header')
@endsection

@section('main')
    <section class="wrapper">
        <div class="card bg-light" style="border-radius: 1rem;">
            <div class="p-3">
                <a href="{{ route('login') }}"><i class="fas fa-angle-left"></i></a>
            </div>
            <div class="card-body p-3 text-center">
                <h2 class="fw-bold mb-3 text-uppercase">Đăng Ký</h2>

                @if (session('error'))
                    <p class="text-danger mb-3">{{ session('error') }}</p>
                @endif

                <form method="POST">
                    @csrf

                    <div class="form-floating mb-4">
                        <input type="text" id="name" name="name" placeholder=""
                            class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" />
                        <label for="name">Name</label>
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-floating mb-4">
                        <input type="text" id="email" name="email" placeholder=""
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

                    <div class="form-floating mb-4">
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder=""
                            class="form-control" />
                        <label for="password_confirmation">Xác nhận mật khẩu</label>
                    </div>

                    <span class="d-inline-block">
                        <button type="submit" class="btn btn-primary btn-block" data-mdb-ripple-init>
                            Đăng Ký
                        </button>
                    </span>
                </form>
            </div>
        </div>
    </section>
@endsection

@section('footer')
@endsection
