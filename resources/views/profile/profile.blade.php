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
      padding: 22px 26px;
      background: linear-gradient(120deg, #ffffff, #f7eee7);
      border-bottom: 1px solid var(--border-soft);
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

    /* RESPONSIVE */
    @media (max-width: 768px) {
      .profile-content {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>

<body>
  <div class="profile-page">
    <!-- HEADER -->
    <header class="profile-header">
      <div class="logo">D'kasuari</div>

      <div style="display: flex; align-items: center; gap: 10px;">
        <div class="avatar-mini">A</div>
        <span>Akmal</span>
      </div>
    </header>

    <!-- CONTENT -->
    <main class="profile-content">
      
      <!-- LEFT -->
      <section class="profile-card">
        <div class="profile-top">
          <div class="avatar-large">A</div>
          <div>
            <h2>Akmal Falah</h2>
            <p style="font-size: 13px; color: var(--text-muted);">
              Member sejak 2022 · 14 malam menginap
            </p>
            <div class="badge">Member Gold</div>
          </div>
        </div>

        <div class="profile-details">
          <div class="detail-box">
            <span>Email</span>
            <strong>akmal@example.com</strong>
          </div>
          <div class="detail-box">
            <span>Telepon</span>
            <strong>+62 812 3456 7890</strong>
          </div>
          <div class="detail-box">
            <span>Kota</span>
            <strong>Jakarta</strong>
          </div>
          <div class="detail-box">
            <span>Bahasa</span>
            <strong>Indonesia</strong>
          </div>
        </div>

        <div class="stats-row">
          <div class="stat-card">
            <span class="label">Poin Reward</span>
            <div class="value">1.280</div>
          </div>
          <div class="stat-card">
            <span class="label">Reservasi Aktif</span>
            <div class="value">2</div>
          </div>
          <div class="stat-card">
            <span class="label">Malam Menginap</span>
            <div class="value">14</div>
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

</body>
</html>