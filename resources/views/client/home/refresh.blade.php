@extends('client.main')

@section('title')
    Xác Nhận Email
@endsection

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
    </style>
@endsection

@section('header')
@endsection

@section('main')
    <section class="wrapper">
        <div class="card bg-light" style="border-radius: 1rem;">
            <div class="p-3">
                <a href="{{ route('register') }}"><i class="fas fa-angle-left"></i></a>
            </div>
            <div class="card-body p-3 text-center">
                <h2 class="fw-bold mb-3 text-uppercase">Xác Nhận Tài Khoản</h2>

                @if (session('error'))
                    <p class="text-danger mb-3">{{ session('error') }}</p>
                @endif

                <form method="POST">
                    @csrf

                    <div class="form-outline mb-4" data-mdb-input-init
                        @error('email')
                        data-mdb-tooltip-init
                        data-mdb-placement="right"
                        title="{{ $message }}"
                        @enderror>
                        <input type="text" id="email" name="email"
                            class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" />
                        <label class="form-label" for="email">Email</label>
                    </div>

                    <span class="d-inline-block">
                        <button type="submit" class="btn btn-primary btn-block" data-mdb-ripple-init>
                            Gửi
                        </button>
                    </span>

                </form>
            </div>
        </div>
    </section>
@endsection

@section('footer')
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('input:text')[0].focus();
        });

        $(document).on('input', '.form-outline input', function() {
            if ($(this).val()) {
                $(this).removeClass('is-invalid');
            } else {
                $(this).addClass('is-invalid');
            }
            $('.text-danger').remove();
        })
    </script>
@endsection
