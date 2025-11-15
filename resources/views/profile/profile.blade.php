<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Profil Pengguna - Pemesanan Hotel</title>

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
      display: flex;
      gap: 20px;
      align-items: center;
    }

    .avatar-large {
      width: 80px;
      height: 80px;
      border-radius: 50%;
      background: var(--primary);
      color: white;
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 32px;
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
      padding: 10px;
      border-radius: 12px;
      border: 1px solid #d9c7b9;
      margin-bottom: 10px;
    }

    .booking-item strong {
      font-size: 14px;
      color: var(--primary);
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
  @endphp
  <div class="profile-page">
    <!-- HEADER -->
    <header class="profile-header">
      <div class="logo">D'kasuari</div>

      <div style="display: flex; align-items: center; gap: 10px;">
        <div class="avatar-mini">{{ $initial }}</div>
        <span>{{ $displayName }}</span>
      </div>

      <button class="logout-btn" id="logoutBtn">Logout</button>
    </header>

    <!-- CONTENT -->
    <main class="profile-content">
      
      <!-- LEFT -->
      <section class="profile-card">
        <div class="profile-top">
          <div class="avatar-large">{{ $initial }}</div>
          <div>
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
          <div class="detail-box">
            <span>Email Terverifikasi</span>
            <strong>{{ $user->email_verified_at ? 'Ya' : 'Belum' }}</strong>
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
          <div class="stat-card">
            <span class="label">Status</span>
            <div class="value">{{ $user->email_verified_at ? 'Verified' : 'Guest' }}</div>
          </div>
        </div>
      </section>

      <!-- RIGHT -->
      <div>
        <section class="card-section">
          <h3>Pemesanan Aktif</h3>

          <div class="booking-item">
            <strong>Grand Aurora Hotel – Deluxe City View</strong>
            <p style="font-size: 12px; color: var(--text-muted);">
              Check-in 24 Nov 2025 · 3 malam
            </p>
            <p style="font-size: 13px; color: var(--primary);">
              Rp 3.450.000 (Sudah dibayar)
            </p>
          </div>

          <div class="booking-item">
            <strong>Seaside Resort & Spa – Suite</strong>
            <p style="font-size: 12px; color: var(--text-muted);">
              Check-in 12 Des 2025 · 2 malam
            </p>
            <p style="font-size: 13px; color: var(--primary);">
              Rp 4.200.000 (Bayar di hotel)
            </p>
          </div>
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

      if (!logoutBtn) {
        return;
      }

      logoutBtn.addEventListener('click', async function () {
        logoutBtn.disabled = true;
        const token = localStorage.getItem('access_token');

        try {
          await fetch('/api/auth/logout', {
            method: 'POST',
            headers: {
              'Accept': 'application/json',
              'Authorization': token ? 'Bearer ' + token : ''
            },
            credentials: 'include',
          });
        } catch (error) {
          console.error('Logout gagal', error);
        }

        localStorage.removeItem('access_token');
        document.cookie = 'sanctum_token=; Path=/; Expires=Thu, 01 Jan 1970 00:00:00 GMT';
        window.location.href = "{{ route('register') }}";
      });
    });
  </script>
</body>
</html>
