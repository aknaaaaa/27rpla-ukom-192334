<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'D\'Kasuari')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Aboreto&display=swap" rel="stylesheet">
<<<<<<< HEAD
=======
    <link href="https://fonts.googleapis.com/css2?family=Mea+Culpa&display=swap" rel="stylesheet">
>>>>>>> c744583985de79c63527125b81123ee127e9ef34
    <style>
        body {
            background-color: #f8f6f4;
            font-family: 'Aboreto', cursive;
        }
        .modal-backdrop.show {
            opacity: 0.3;
        }
<<<<<<< HEAD
    </style>
</head>
<body>
    @include('components.navbar')
=======
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
</head>
<body>
    @include('layouts.navigation')
>>>>>>> c744583985de79c63527125b81123ee127e9ef34
    <main class="py-4">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
<<<<<<< HEAD
</html>
=======
</html>
>>>>>>> c744583985de79c63527125b81123ee127e9ef34
