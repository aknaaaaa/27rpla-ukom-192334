<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Profil Pengguna - Pemesanan Hotel</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Aboreto&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Mea+Culpa&display=swap" rel="stylesheet">

  <style>
    :root {
      --primary: #AB886D;
      --primary-soft: #f3ebe5;
      --text-main: #333333;
      --text-muted: #777777;
      --white: #ffffff;
      --border-soft: #e2d4c9;
      --radius-xl: 20px;
      --shadow-soft: 0 10px 30px rgba(0, 0, 0, 0.08);
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: "Aboreto", sans-serif;
      background: linear-gradient(135deg, #ffffff, #f8f3ef);
      padding: 30px 15px;
      color: var(--text-main);
      display: flex;
      justify-content: center;
    }

    .profile-page {
      width: 100%;
      max-width: 1100px;
      background: var(--white);
      border-radius: 26px;
      box-shadow: var(--shadow-soft);
      border: 1px solid rgba(171, 136, 109, 0.3);
      overflow: hidden;
    }

    /* HEADER */
    .profile-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 22px 26px;
      background: linear-gradient(120deg, #ffffff, #f7eee7);
      border-bottom: 1px solid var(--border-soft);
      gap: 16px;
    }

    .logo {
      font-size: 24px;
      font-family: 'Mea Culpa', cursive;
      color: var(--primary);
    }

    .logo span {
      font-weight: bold;
    }

    .avatar-mini {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      background: var(--primary);
      color: var(--white);
      display: flex;
      justify-content: center;
      align-items: center;
      overflow: hidden;
      font-weight: 600;
    }

    .avatar-mini img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
    }

    /* CONTENT GRID */
    .profile-content {
      display: grid;
      grid-template-columns: 1.2fr 1fr;
      gap: 20px;
      padding: 22px;
    }

    /* LEFT CARD */
    .profile-card {
      padding: 20px;
      border: 1px solid var(--border-soft);
      border-radius: var(--radius-xl);
      box-shadow: var(--shadow-soft);
    }

    .profile-top {
      display: grid;
      grid-template-columns: 180px 1fr;
      gap: 24px;
      align-items: start;
    }

    .avatar-wrapper {
      display: flex;
      flex-direction: column;
      gap: 8px;
      align-items: flex-start;
    }

    .avatar-large {
      width: 110px;
      height: 110px;
      border-radius: 50%;
      background: var(--primary);
      color: white;
      display: grid;
      place-items: center;
      font-size: 34px;
      overflow: hidden;
      position: relative;
      cursor: pointer;
      border: 2px solid rgba(255, 255, 255, 0.5);
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .avatar-large:hover {
      transform: translateY(-2px);
      box-shadow: 0 14px 28px rgba(0, 0, 0, 0.12);
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

    .avatar-large.has-image #avatarInitial {
      display: none;
    }

    .avatar-overlay {
      position: absolute;
      inset: 0;
      background: rgba(0, 0, 0, 0.45);
      color: var(--white);
      font-size: 12px;
      letter-spacing: 0.5px;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      gap: 4px;
      opacity: 0;
      transition: opacity 0.2s ease;
      text-transform: uppercase;
      pointer-events: none;
    }

    .avatar-large:hover .avatar-overlay,
    .avatar-large.is-uploading .avatar-overlay {
      opacity: 1;
    }

    .avatar-large.is-uploading {
      opacity: 0.8;
      pointer-events: none;
    }

    .avatar-note {
      font-size: 11px;
      color: var(--text-muted);
      margin-top: 8px;
    }

    .badge {
      display: inline-block;
      margin-top: 6px;
      padding: 4px 10px;
      background: rgba(171, 136, 109, 0.2);
      border-radius: 20px;
      font-size: 12px;
      color: var(--primary);
    }

    .profile-details {
      margin-top: 20px;
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 12px;
    }

    .detail-box span {
      font-size: 12px;
      color: var(--text-muted);
    }

    .detail-box strong {
      display: block;
      font-size: 14px;
    }

    /* STATS */
    .stats-row {
      margin-top: 20px;
      display: grid;
      grid-template-columns: repeat(3, 1fr);
      gap: 14px;
    }

    .stat-card {
      padding: 12px;
      border-radius: 14px;
      background: #fbf7f3;
      border: 1px solid #d8c8bc;
    }

    .stat-card .label {
      font-size: 11px;
      color: var(--text-muted);
    }

    .stat-card .value {
      font-size: 18px;
      margin: 4px 0;
      color: var(--primary);
    }

    /* RIGHT SECTION */
    .card-section {
      border: 1px solid var(--border-soft);
      border-radius: var(--radius-xl);
      padding: 18px;
      background: var(--white);
      box-shadow: var(--shadow-soft);
      margin-bottom: 14px;
    }

    .card-section h3 {
      font-size: 16px;
      margin-bottom: 10px;
    }

    .booking-item {
      background: #faf7f4;
      padding: 12px 14px;
      border-radius: 12px;
      border: 1px solid #d9c7b9;
      margin-bottom: 12px;
      display: flex;
      flex-direction: column;
      gap: 4px;
    }

    .booking-item strong {
      font-size: 14px;
      color: var(--primary);
    }

    .booking-empty {
      padding: 22px;
      text-align: center;
      color: var(--text-muted);
      font-size: 13px;
      border-radius: var(--radius-xl);
      border: 1px dashed var(--border-soft);
      background: rgba(171, 136, 109, 0.08);
    }

    .logout-btn {
      padding: 10px 18px;
      border: none;
      border-radius: 999px;
      background: #c0392b;
      color: #fff;
      font-weight: 600;
      letter-spacing: .5px;
      cursor: pointer;
      transition: opacity .2s ease;
      font-family: aboreto;
    }

    .logout-btn[disabled] {
      opacity: .6;
      cursor: not-allowed;
    }

    /* RESPONSIVE */
    @media (max-width: 768px) {
      .profile-content {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>

<body>
  @php
    $displayName = $user->nama_user ?? $user->email;
    $initial = strtoupper(mb_substr($displayName ?? 'U', 0, 1));
    $memberSince = optional($user->created_at)->format('d M Y');
    $avatarUrl = $user->avatar_url;
    $hasAvatar = !empty($avatarUrl);
  @endphp
  <div class="profile-page">
    <!-- HEADER -->
    <header class="profile-header">
      <div class="logo">D'kasuari</div>

      <div style="display: flex; align-items: center; gap: 10px;">
        <div class="avatar-mini" id="avatarMini" data-initial="{{ $initial }}">
          @if($hasAvatar)
            <img src="{{ $avatarUrl }}" alt="{{ $displayName }}">
          @else
            {{ $initial }}
          @endif
        </div>
        <span>{{ $displayName }}</span>
      </div>

      <button class="logout-btn" id="logoutBtn">Logout</button>
    </header>

    <!-- CONTENT -->
    <main class="profile-content">
      
      <!-- LEFT -->
      <section class="profile-card">
        <div class="profile-top">
          <div class="avatar-wrapper">
            <div class="avatar-large {{ $hasAvatar ? 'has-image' : '' }}" id="avatarTrigger">
              <img id="avatarImage" @if($hasAvatar) src="{{ $avatarUrl }}" @endif alt="Foto profil">
              <span id="avatarInitial">{{ $initial }}</span>
              <div class="avatar-overlay">
                <span style="font-size: 22px;">&#128247;</span>
                <span>Ubah Foto</span>
              </div>
            </div>
            <input type="file" id="avatarFileInput" accept="image/*" hidden>
            <small class="avatar-note">Klik foto untuk mengganti (JPG/PNG, maks 4MB)</small>
          </div>
          <div class="headline">
            <h2>{{ $displayName }}</h2>
            <p style="font-size: 13px; color: var(--text-muted);">
              Member sejak {{ $memberSince ?? '-' }}
            </p>
            <div class="badge">Member Aktif</div>
          </div>
        </div>

        <div class="profile-details">
          <div class="detail-box">
            <span>Email</span>
            <strong>{{ $user->email }}</strong>
          </div>
          <div class="detail-box">
            <span>Telepon</span>
            <strong>{{ $user->phone_number ?? '-' }}</strong>
          </div>
          <div class="detail-box">
            <span>ID Pengguna</span>
            <strong>{{ $user->id_user }}</strong>
          </div>
        </div>

        <div class="stats-row">
          <div class="stat-card">
            <span class="label">Token Aktif</span>
            <div class="value">{{ $user->tokens()->count() }}</div>
          </div>
          <div class="stat-card">
            <span class="label">Nomor Telepon</span>
            <div class="value">{{ $user->phone_number ?? '-' }}</div>
          </div>
        </div>
      </section>

      <!-- RIGHT -->
      <div>
        <section class="card-section">
          <h3>Pemesanan Aktif</h3>

          @forelse ($orders as $order)
            @php
              $checkIn = optional($order->check_in)->translatedFormat('d M Y');
              $checkOut = optional($order->check_out)->translatedFormat('d M Y');
              $paymentStatus = $order->pembayaran->status_pembayaran ?? 'Belum dibayar';
              $amount = $order->pembayaran->amount_paid
                ?? ($order->kamar && $order->total_hari
                  ? $order->kamar->harga_permalam * $order->total_hari
                  : null);
            @endphp
            <div class="booking-item">
              <strong>{{ $order->kamar->nama_kamar ?? 'Pesanan #' . $order->booking_code }}</strong>
              <p style="font-size: 12px; color: var(--text-muted);">
                #{{ $order->booking_code }} &middot;
                {{ $checkIn ?? 'Tanggal belum ditentukan' }} -
                {{ $checkOut ?? 'Tanggal belum ditentukan' }}
                @if($order->total_hari)
                  &middot; {{ $order->total_hari }} malam
                @endif
              </p>
              <p style="font-size: 13px; color: var(--primary);">
                @if($amount)
                  Rp {{ number_format($amount, 0, ',', '.') }}
                @else
                  Belum ada total pembayaran
                @endif
                ({{ ucfirst($order->status_label) }})
              </p>
              <p style="font-size: 11px; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">
                {{ $paymentStatus }}
              </p>
            </div>
          @empty
            <p class="booking-empty">Belum ada pesanan.</p>
          @endforelse
        </section>
        <section class="card-section">
          <h3>Pengaturan Akun</h3>

          <p style="font-size: 12px; color: var(--text-muted);">
            - Notifikasi Promo: Aktif <br>
            - Check-in Cepat: Aktif <br>
            - Mode Tenang: Nonaktif
          </p>
        </section>
      </div>

    </main>

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

          // Pastikan CSRF cookie sudah tersedia supaya middleware stateful sanctum tidak menolak request
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
        if (!avatarTrigger) return;
        avatarTrigger.classList.toggle('is-uploading', Boolean(isLoading));
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

      avatarTrigger?.addEventListener('click', () => {
        avatarInput?.click();
      });

      avatarInput?.addEventListener('change', function () {
        if (!this.files || !this.files.length) {
          return;
        }
        uploadAvatar(this.files[0]);
        this.value = '';
      });
    });
  </script>
</body>
</html>
