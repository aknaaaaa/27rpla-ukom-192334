<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'D\'Kasuari')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Aboreto&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Mea+Culpa&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f8f6f4;
            font-family: 'Aboreto', cursive;
        }
        .modal-backdrop.show {
            opacity: 0.3;
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
        .page-loader {
            position: fixed;
            inset: 0;
            background: rgba(255,255,255,0.9);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
            transition: opacity 0.25s ease, visibility 0.25s ease;
        }
        .page-loader.is-hidden {
            opacity: 0;
            visibility: hidden;
        }
        .page-loader__spinner {
            width: 64px;
            height: 64px;
            border: 6px solid #d3c3a6;
            border-top-color: #875f01;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div id="pageLoader" class="page-loader">
        <div class="page-loader__spinner" role="status" aria-label="Loading"></div>
    </div>
    <div id="appToastContainer" class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1100;"></div>
    <main class="py-4">
        @yield('content')
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.addEventListener('load', () => {
            const loader = document.getElementById('pageLoader');
            if (loader) {
                loader.classList.add('is-hidden');
                setTimeout(() => loader.remove(), 300);
            }
        });
    </script>
    <script>
        window.showAppToast = function(message, variant = 'success') {
            const container = document.getElementById('appToastContainer');
            const Toast = window.bootstrap?.Toast;
            if (!container || !Toast) {
                alert(message);
                return;
            }

            const toastEl = document.createElement('div');
            toastEl.className = `toast align-items-center text-bg-${variant} border-0 shadow`;
            toastEl.setAttribute('role', 'status');
            toastEl.setAttribute('aria-live', 'polite');
            toastEl.setAttribute('aria-atomic', 'true');
            toastEl.innerHTML = `
                <div class="d-flex">
                    <div class="toast-body">${message}</div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            `;
            container.appendChild(toastEl);

            const toast = new Toast(toastEl, { delay: 2600 });
            toastEl.addEventListener('hidden.bs.toast', () => toastEl.remove());
            toast.show();
        };
    </script>
</body>
</html>
