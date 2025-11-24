@php
    $isAuthenticated = Auth::check();
@endphp

<div class="modal fade" id="authAlertModal" tabindex="-1" aria-labelledby="authAlertTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 bg-transparent">
            <div class="auth-alert__wrapper shadow-lg rounded-4 overflow-hidden position-relative">
                <button type="button"
                        class="btn btn-light btn-sm rounded-circle position-absolute top-0 end-0 m-3"
                        data-bs-dismiss="modal"
                        aria-label="Tutup">
                    <span aria-hidden="true">&times;</span>
                </button>
                <div class="row g-0 align-items-stretch">
                    <div class="col-md-6 d-none d-md-block">
                        <img id="authAlertImage"
                             src="{{ asset('images/image.png') }}"
                             alt="Pratinjau kamar"
                             class="auth-alert__image">
                    </div>
                    <div class="col-md-6 bg-white p-4 d-flex flex-column justify-content-center">
                        <p class="text-muted mb-1 small">Masuk dulu yuk</p>
                        <h5 class="fw-bold text-uppercase mb-2" id="authAlertRoomTitle">Kamar pilihan</h5>
                        <p class="small mb-3">
                            Silakan masuk atau daftar lebih dulu supaya pesananmu tercatat dan mudah dilacak.
                        </p>
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="{{ route('register') }}" class="btn btn-dark btn-sm px-4">Daftar</a>
                            <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-sm px-4">Masuk</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.auth-alert__wrapper {
    max-width: 760px;
    margin: 0 auto;
    background: #f3f1ef;
}
.auth-alert__image {
    display: block;
    width: 100%;
    height: 100%;
    min-height: 280px;
    object-fit: cover;
}
@media (max-width: 640px) {
    .auth-alert__wrapper {
        max-width: 92vw;
    }
    #authAlertImage {
        display: none;
    }
}
</style>

<script>
    window.__appAuthState = window.__appAuthState || { loggedIn: @json($isAuthenticated) };

    window.addEventListener('load', () => {
        const Modal = window.bootstrap?.Modal;
        const modalElement = document.getElementById('authAlertModal');
        if (!Modal || !modalElement) return;

        const authModal = new Modal(modalElement);
        const guardedButtons = document.querySelectorAll('[data-requires-auth]');
        const previewImage = document.getElementById('authAlertImage');
        const roomTitle = document.getElementById('authAlertRoomTitle');
        const defaultPreview = "{{ asset('images/image.png') }}";

        const setPromptContent = (meta = {}) => {
            const kamarName = meta?.nama || 'Kamar pilihan';
            const kamarImage = meta?.gambar || defaultPreview;

            if (previewImage) {
                previewImage.src = kamarImage;
            }
            if (roomTitle) {
                roomTitle.textContent = kamarName;
            }
        };

        const checkAuth = async () => {
            if (window.__appAuthState.loggedIn) return true;

            const token = localStorage.getItem('access_token');
            if (!token) return false;

            try {
                const res = await fetch('/api/check-auth', {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'Authorization': 'Bearer ' + token,
                    },
                    credentials: 'include',
                });

                if (res.ok) {
                    window.__appAuthState.loggedIn = true;
                    return true;
                }
            } catch (error) {
                console.error('Gagal memeriksa status login', error);
            }

            localStorage.removeItem('access_token');
            document.cookie = 'sanctum_token=; Path=/; Expires=Thu, 01 Jan 1970 00:00:00 GMT';
            return false;
        };

        const requireAuth = async (meta = {}) => {
            setPromptContent(meta);
            const ok = await checkAuth();
            if (!ok) {
                authModal.show();
                return false;
            }
            return true;
        };

        window.requireAuth = requireAuth;

        guardedButtons.forEach((btn) => {
            btn.addEventListener('click', async (event) => {
                event.preventDefault();
                const targetUrl = btn.getAttribute('data-url') || btn.getAttribute('href');
                const action = btn.getAttribute('data-action') || '';

                const meta = {
                    nama: btn.getAttribute('data-nama') || undefined,
                    gambar: btn.getAttribute('data-gambar') || undefined,
                };

                const isAllowed = await requireAuth(meta);
                if (!isAllowed) return;

                if (action === 'add-to-cart') {
                    return;
                }

                if (targetUrl && targetUrl !== '#') {
                    window.location.href = targetUrl;
                }
            });
        });
    });
</script>
