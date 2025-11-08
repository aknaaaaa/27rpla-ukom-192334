<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Template')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Mea+Culpa&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Aboreto&display=swap" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
        }
        .navbar-custom {
            position: fixed;
            top: 0;
            width: 100%;
            background-color: rgba(255, 255, 255, 0.5) !important;
            backdrop-filter: blur(5px);
            z-index: 10;
            transition: background-color 0.3s ease;
        }
        .navbar-custom.scrolled {
            background-color: rgba(255, 255, 255) !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        .navbar-brand {
            font-size: 2rem;
            color: #875f01 !important;
        }
        .font-mea {
            font-family: 'Mea Culpa', cursive;
        }
        .font-aboreto {
            font-family: 'Aboreto', system-ui;
        }
    </style>

    <script>
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar-custom');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>
</head>
<body>

    {{-- 🔹 Konten Halaman --}}
    <main>
        @yield('content')
    </main>

    {{-- 🔹 Footer --}}
    @include('layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
