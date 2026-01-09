<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Project-PU</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome (ASLI TEMPLATE) -->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

    <!-- SB Admin CSS -->
    <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet">
</head>

<body class="sb-nav-fixed">

    {{-- Navbar --}}
    @include('partials.navbar')

    <div id="layoutSidenav">

        {{-- Sidebar --}}
        @include('partials.sidebar')

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    @yield('content')
                </div>
            </main>

            {{-- Footer --}}
            @include('partials.footer')
        </div>
    </div>

    <!-- Bootstrap 5 JS (CDN, ASLI TEMPLATE) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- SB Admin JS -->
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
</body>
</html>
