<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') - Ecademy</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

    <link href="{{ asset('assets/admin/css/styles.css') }}" rel="stylesheet">
    @yield('styles')
</head>

<body id="body-pd">
    @section('header')
        @include('admin.layouts.header')
    @show

    @section('sidebar')
        @include('admin.layouts.sidebar')
    @show

    <div class="height-100 bg-light">
        @yield('main')
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="{{ asset('assets/admin/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/admin/js/toast.js') }}"></script>
    @if (session('toast'))
        <script>
            $(document).ready(function() {
                setTimeout(function() {
                    toast({
                        type: '{{ session('toast.type') }}',
                        message: '{{ session('toast.message') }}'
                    });
                }, 100);
            });
        </script>
    @endif
    @yield('scripts')
</body>

</html>
