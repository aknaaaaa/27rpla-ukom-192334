<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Profil Pengguna - D'Kasuari</title>
    <link href="https://fonts.googleapis.com/css2?family=Aboreto&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Mea+Culpa&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #AB886D;
            --accent: #c9a98d;
            --text-main: #2f2d2c;
            --text-muted: #8d8784;
            --white: #ffffff;
            --sidebar-bg: #edf3ff;
            --border: #e2d4c9;
        }
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: 'Aboreto', sans-serif;
            color: var(--text-main);
            background: #dbe5ff;
            min-height: 100vh;
        }
        .profile-layout {
            display: flex;
            min-height: 100vh;
        }
        .profile-sidebar {
            width: 230px;
            background: var(--sidebar-bg);
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
            gap: 30px;
        }
        .sidebar-logo {
            font-family: 'Mea Culpa', cursive;
            font-size: 30px;
            color: var(--primary);
        }
        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }
        .sidebar-nav button {
            border: none;
            border-radius: 12px;
            padding: 12px 16px;
            text-align: left;
            font-size: 14px;
            background: rgba(255,255,255,0.8);
            cursor: pointer;
            transition: all .2s ease;
            letter-spacing: .5px;
        }
        .sidebar-nav button.is-active {
            background: var(--primary);
            color: var(--white);
        }
        .sidebar-nav button:hover {
            transform: translateX(4px);
        }
        .profile-main {
            flex: 1;
            padding: 32px;
            background: linear-gradient(135deg, #fffaf5, #f7efe7);
        }
        .main-shell {
            background: var(--white);
            border-radius: 26px;
            border: 1px solid rgba(171, 136, 109, 0.3);
            box-shadow: 0 12px 30px rgba(0,0,0,0.08);
            padding: 26px;
        }
        .main-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 18px;
        }
        .main-header h2 {
            margin: 0;
            font-weight: 400;
            letter-spacing: 1px;
        }
        .profile-card {
            display: grid;
            grid-template-columns: 1fr 0.9fr;
            gap: 24px;
        }
        .card-left {
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 20px;
            background: rgba(255,255,255,0.9);
        }
        .card-right {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        .name-row {
            display: grid;
            grid-template-columns: 120px 1fr;
            gap: 20px;
        }
        .avatar-large {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: var(--primary);
            color: var(--white);
            display: grid;
            place-items: center;
            font-size: 34px;
            overflow: hidden;
            position: relative;
            cursor: pointer;
            border: 3px solid rgba(255,255,255,0.6);
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        }
        .avatar-large img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: none;
        }
        .avatar-large.has-image img {
            display: block;
        }
        .avatar-large.has-image span {
            display: none;
        }
        .avatar-overlay {
            position: absolute;
            inset: 0;
            background: rgba(0,0,0,0.45);
            color: var(--white);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            letter-spacing: 0.5px;
            opacity: 0;
            transition: opacity .2s ease;
            text-transform: uppercase;
            pointer-events: none;
        }
        .avatar-large:hover .avatar-overlay,
        .avatar-large.is-uploading .avatar-overlay {
            opacity: 1;
        }
        .profile-meta {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
            gap: 12px;
            margin-top: 18px;
        }
        .meta-box {
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 12px;
            background: rgba(255,255,255,0.8);
        }
        .meta-box span {
            font-size: 12px;
            color: var(--text-muted);
            letter-spacing: 0.4px;
        }
        .meta-box strong {
            display: block;
            margin-top: 4px;
        }
        .bookings-card, .settings-card {
            border: 1px solid var(--border);
            border-radius: 20px;
            padding: 18px;
            background: rgba(255,255,255,0.9);
        }
        .bookings-card h3,
        .settings-card h3 {
            margin: 0 0 12px;
            letter-spacing: 0.8px;
        }
        .booking-item {
            border: 1px solid #ddcab9;
            border-radius: 14px;
            padding: 12px;
            background: #fdf5ed;
            margin-bottom: 12px;
        }
        .booking-item strong {
            display: block;
            margin-bottom: 4px;
        }
        .booking-empty {
            text-align: center;
            border: 1px dashed var(--border);
            border-radius: 16px;
            padding: 18px;
            color: var(--text-muted);
            background: rgba(255,255,255,0.8);
        }
        .profile-avatar-mini {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            background: var(--primary);
            color: var(--white);
            display: grid;
            place-items: center;
            overflow: hidden;
        }
        .profile-avatar-mini img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        @media (max-width: 960px) {
            .profile-card {
                grid-template-columns: 1fr;
            }
            .profile-sidebar {
                display: none;
            }
            .profile-layout {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    @php
        $displayName = $user->nama_user ?? $user->email;
        $initial = strtoupper(mb_substr($displayName ?? 'U', 0, 1));
        $memberSince = optional($user->created_at)->translatedFormat('d M Y');
        $avatarUrl = $user->avatar_url;
        $hasAvatar = !empty($avatarUrl);
    @endphp

    <div class="profile-layout">
        <aside class="profile-sidebar">
            <div class="sidebar-logo">D'Kasuari</div>
            <div class="profile-avatar-mini" id="avatarMini" data-initial="{{ $initial }}">
                @if($hasAvatar)
                    <img src="{{ $avatarUrl }}" alt="{{ $displayName }}">
                @else
                    {{ $initial }}
                @endif
            </div>
            <nav class="sidebar-nav">
                <button class="is-active" type="button">PROFILE</button>
                <button type="button">KERANJANG</button>
                <button type="button">PEMESANAN</button>
                <button type="button">RIWAYAT</button>
                <button type="button" id="logoutBtn">LOG OUT</button>
            </nav>
        </aside>

        <section class="profile-main">
            <div class="main-shell">
                <div class="main-header">
                    <div>
                        <span style="font-size:14px;color:var(--text-muted);letter-spacing:1px;">&#9670; D'KASUARI</span>
                        <h2>{{ $displayName }}</h2>
                    </div>
                    <div style="font-size:24px;letter-spacing:1px;">{{ strtoupper($displayName) }}</div>
                </div>

                <div class="profile-card">
                    <div class="card-left">
                        <div class="name-row">
                            <div class="avatar-large {{ $hasAvatar ? 'has-image' : '' }}" id="avatarTrigger">
                                <img id="avatarImage" @if($hasAvatar) src="{{ $avatarUrl }}" @endif alt="Foto profil">
                                <span id="avatarInitial">{{ $initial }}</span>
                                <div class="avatar-overlay">
                                    <span style="font-size: 22px;">&#128247;</span>
                                    <span>Ubah Foto</span>
                                </div>
                            </div>
                            <input type="file" id="avatarFileInput" accept="image/*" hidden>
                            <div>
                                <h3 style="margin:0;font-size:20px;">{{ $displayName }}</h3>
                                <div style="font-size:12px;color:var(--text-muted);">Member sejak {{ $memberSince ?? '-' }}</div>
                                <div style="margin-top:8px;padding:6px 12px;background:rgba(171,136,109,0.15);border-radius:20px;font-size:12px;display:inline-block;">MEMBER AKTIF</div>
                            </div>
                        </div>

                        <div class="profile-meta">
                            <div class="meta-box">
                                <span>Email</span>
                                <strong>{{ $user->email }}</strong>
                            </div>
                            <div class="meta-box">
                                <span>Nomor Telepon</span>
                                <strong>{{ $user->phone_number ?? '-' }}</strong>
                            </div>
                            <div class="meta-box">
                                <span>ID Pengguna</span>
                                <strong>{{ $user->id_user }}</strong>
                            </div>
                            <div class="meta-box">
                                <span>Email Terverifikasi</span>
                                <strong>{{ $user->email_verified_at ? 'Ya' : 'Belum' }}</strong>
                            </div>
                            <div class="meta-box">
                                <span>Status</span>
                                <strong>{{ ($user->id_role ?? 2) == 1 ? 'Admin' : 'User' }}</strong>
                            </div>
                        </div>
                    </div>

                    <div class="card-right">
                        <div class="bookings-card">
                            <h3>PEMESANAN AKTIF</h3>
                            @forelse ($orders as $order)
                                @php
                                    $checkIn = optional($order->check_in)->translatedFormat('d M Y');
                                    $nights = $order->total_hari ? $order->total_hari . ' malam' : '-';
                                    $paymentStatus = $order->pembayaran->status_pembayaran ?? 'Belum dibayar';
                                    $amount = $order->pembayaran->amount_paid
                                        ?? ($order->kamar && $order->total_hari
                                            ? $order->kamar->harga_permalam * $order->total_hari
                                            : null);
                                @endphp
                                <div class="booking-item">
                                    <strong>{{ $order->kamar->nama_kamar ?? 'Pesanan #' . $order->booking_code }}</strong>
                                    <p style="font-size:12px;color:var(--text-muted);">
                                        Check-in {{ $checkIn ?? 'Belum ditentukan' }} | {{ $nights }}
                                    </p>
                                    <p style="font-size:13px;color:var(--primary);">
                                        @if($amount)
                                            Rp {{ number_format($amount, 0, ',', '.') }}
                                        @else
                                            Rp0
                                        @endif
                                        ({{ $paymentStatus }})
                                    </p>
                                </div>
                            @empty
                                <div class="booking-empty">Belum ada pemesanan aktif.</div>
                            @endforelse
                        </div>

                        <div class="settings-card">
                            <h3>PENGATURAN AKUN</h3>
                            <p style="font-size:12px;color:var(--text-muted);line-height:1.6;">
                                - Notifikasi Promo: Aktif<br>
                                - Check-in Cepat: Aktif<br>
                                - Mode Tenang: Nonaktif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const logoutBtn = document.getElementById('logoutBtn');

            if (logoutBtn) {
                const getCookie = (name) => {
                    const value = `; ${document.cookie}`;
                    const parts = value.split(`; ${name}=`);
                    if (parts.length === 2) return parts.pop().split(';').shift();
                    return null;
                };

                logoutBtn.addEventListener('click', async function () {
                    logoutBtn.disabled = true;
                    const token = localStorage.getItem('access_token');

                    try {
                        await fetch('/sanctum/csrf-cookie', { credentials: 'include' });
                    } catch (error) {
                        console.warn('Gagal mengambil CSRF cookie', error);
                    }

                    const xsrf = getCookie('XSRF-TOKEN');
                    try {
                        const headers = {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                        };

                        if (token) {
                            headers['Authorization'] = 'Bearer ' + token;
                        }

                        if (xsrf) {
                            headers['X-XSRF-TOKEN'] = decodeURIComponent(xsrf);
                        }

                        await fetch('/api/auth/logout', {
                            method: 'POST',
                            headers,
                            credentials: 'include',
                        });
                    } catch (error) {
                        console.error('Logout gagal', error);
                    }

                    localStorage.removeItem('access_token');
                    ['sanctum_token', 'XSRF-TOKEN', 'laravel_session'].forEach((name) => {
                        document.cookie = `${name}=; Path=/; Expires=Thu, 01 Jan 1970 00:00:00 GMT`;
                    });
                    window.location.href = "{{ route('layouts.register') }}";
                });
            }

            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            const avatarTrigger = document.getElementById('avatarTrigger');
            const avatarInput = document.getElementById('avatarFileInput');
            const avatarImg = document.getElementById('avatarImage');
            const avatarInitial = document.getElementById('avatarInitial');
            const avatarMini = document.getElementById('avatarMini');

            const showMessage = (message, type = 'info') => {
                if (window.showAppToast) {
                    window.showAppToast(message, type);
                } else {
                    alert(message);
                }
            };

            const toggleAvatarState = (isLoading) => {
                avatarTrigger?.classList.toggle('is-uploading', Boolean(isLoading));
            };

            const updateMiniAvatar = (url) => {
                if (!avatarMini) return;
                if (url) {
                    avatarMini.innerHTML = `<img src="${url}" alt="Foto profil">`;
                } else if (avatarMini.dataset.initial) {
                    avatarMini.textContent = avatarMini.dataset.initial;
                }
            };

            const updateAvatarDisplay = (url) => {
                if (!avatarTrigger) return;
                if (url) {
                    avatarTrigger.classList.add('has-image');
                    if (avatarImg) {
                        avatarImg.src = url;
                        avatarImg.style.display = 'block';
                    }
                    if (avatarInitial) {
                        avatarInitial.style.display = 'none';
                    }
                    updateMiniAvatar(url);
                } else {
                    avatarTrigger.classList.remove('has-image');
                    if (avatarImg) {
                        avatarImg.removeAttribute('src');
                        avatarImg.style.display = 'none';
                    }
                    if (avatarInitial) {
                        avatarInitial.style.display = '';
                    }
                    updateMiniAvatar('');
                }
            };

            const uploadAvatar = async (file) => {
                if (!csrfToken) {
                    showMessage('Token keamanan tidak ditemukan.', 'danger');
                    return;
                }

                const formData = new FormData();
                formData.append('avatar', file);

                toggleAvatarState(true);
                try {
                    const response = await fetch("{{ route('profile.avatar') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                        },
                        body: formData,
                    });

                    if (!response.ok) {
                        const error = await response.json().catch(() => ({ message: 'Gagal mengunggah foto.' }));
                        showMessage(error.message || 'Gagal mengunggah foto.', 'danger');
                        return;
                    }

                    const data = await response.json();
                    if (data.avatar_url) {
                        updateAvatarDisplay(data.avatar_url);
                    }
                    showMessage(data.message || 'Foto profil berhasil diperbarui.', 'success');
                } catch (error) {
                    console.error('Upload avatar gagal', error);
                    showMessage('Terjadi kesalahan saat mengunggah foto.', 'danger');
                } finally {
                    toggleAvatarState(false);
                }
            };

            avatarTrigger?.addEventListener('click', () => avatarInput?.click());

            avatarInput?.addEventListener('change', function () {
                if (!this.files || !this.files.length) return;
                uploadAvatar(this.files[0]);
                this.value = '';
            });
        });
    </script>
</body>
</html>
