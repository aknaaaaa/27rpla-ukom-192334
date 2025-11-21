@extends('layouts.test')

@section('title', 'Profile')

@section('content')

<style>
    body {
        background: #f4f6fb;
        transition: overflow .2s ease;
    }
    body.menu-open {
        overflow: hidden;
    }
    .profile-hero {
        border-radius: 18px;
        background: linear-gradient(135deg, #fdf8f3, #f4f2ee);
        padding: 24px 26px;
        box-shadow: 0 12px 40px rgba(0,0,0,0.06);
        border: 1px solid #e8e1d7;
        max-width: 1100px;
        margin: 30px auto;
        overflow: hidden;
        box-sizing: border-box;
    }
    .profile-shell {
        display: grid;
        grid-template-columns: 220px 1fr;
        gap: 18px;
        align-items: start;
    }
    .side-menu {
        background: #fff;
        border: 1px solid #dcdde1;
        border-radius: 14px;
        padding: 12px;
        display: grid;
        gap: 8px;
        box-shadow: 0 8px 18px rgba(0,0,0,0.05);
        height: max-content;
        position: sticky;
        top: 20px;
    }
    .menu-toggle {
        display: none;
        align-items: center;
        gap: 8px;
        padding: 10px 14px;
        border-radius: 12px;
        border: 1px solid #d4d9e2;
        background: #fff;
        color: #2f2f2f;
        font-weight: 700;
        letter-spacing: 0.3px;
        box-shadow: 0 8px 18px rgba(0,0,0,0.05);
    }
    .menu-backdrop {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.35);
        z-index: 8;
    }
    .side-menu a,
    .side-menu button {
        display: block;
        padding: 10px 12px;
        border-radius: 10px;
        text-decoration: none;
        color: #4a4a4a;
        font-weight: 600;
        letter-spacing: 0.3px;
        background: #f9fafc;
        border: 1px solid transparent;
        text-align: left;
        width: 100%;
        transition: all .15s ease;
    }
    .side-menu a:hover,
    .side-menu button:hover {
        border-color: #d2e3ff;
        background: #eef4ff;
    }
    .side-menu a.active,
    .side-menu button.active {
        background: #e2edff;
        border-color: #c9ddff;
        color: #234b88;
    }
    .side-menu button {
        border: none;
    }
    .side-menu a.logout,
    .side-menu button.logout {
        color: #c0392b;
        font-weight: 700;
    }
    .profile-panel {
        background: #fff;
        border: 1px solid #e7d9ce;
        border-radius: 16px;
        padding: 16px;
        box-shadow: 0 10px 32px rgba(0,0,0,0.04);
        overflow: hidden;
        box-sizing: border-box;
        display: grid;
        grid-template-rows: auto 1fr;
    }
    .panel-head {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 14px;
        color: #7a6a5a;
    }
    .profile-card {
        background: linear-gradient(145deg, #fffaf5, #f7f1eb);
        border: 1px solid #dfd2c4;
        border-radius: 18px;
        padding: 26px 30px;
        box-shadow: inset 0 1px 0 rgba(255,255,255,0.7);
        max-width: 100%;
        margin: 0 auto;
        overflow: hidden;
        box-sizing: border-box;
    }
    .profile-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 18px;
        color: #7b6957;
        letter-spacing: 0.6px;
    }
    .brand-mark {
        font-family: Mea Culpa;
    }
    .profile-main {
        display: grid;
        grid-template-columns: 200px 1fr;
        column-gap: 10px;
        row-gap: 16px;
        align-items: start;
        justify-items: start;
        width: 100%;
    }
    .profile-left {
        display: grid;
        justify-items: center;
        gap: 12px;
        width: 100%;
    }
    .avatar-wrapper {
        display: flex;
        flex-direction: column;
        gap: 10px;
        align-items: center;
        width: 100%;
    }
    .avatar-large {
      width: 130px;
      height: 130px;
      border-radius: 50%;
      background: linear-gradient(135deg, #c5a27a, #8f7357);
      color: white;
      display: grid;
      place-items: center;
      font-size: 42px;
      overflow: hidden;
      position: relative;
      cursor: pointer;
      border: 2px solid rgba(255, 255, 255, 0.7);
      box-shadow: 0 12px 28px rgba(0, 0, 0, 0.10);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
     .avatar-large:hover {
      transform: translateY(-2px);
      box-shadow: 0 16px 32px rgba(0, 0, 0, 0.14);
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
    .profile-right {
        display: grid;
        gap: 10px;
        align-content: start;
        justify-items: start;
        text-align: left;
        width: 100%;
        max-width: 880px;
        margin-left: -16px;
    }
    .user-name {
        font-size: 28px;
        letter-spacing: 1.2px;
        color: #5b4631;
        font-weight: 700;
        text-transform: uppercase;
    }
    .label-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 999px;
        border: 1px solid #cbb49d;
        font-size: 12px;
        color: #7c6044;
        background: rgba(255,255,255,0.7);
    }
    .member-since {
        font-size: 13px;
        color: #7c6e63;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
        gap: 12px;
        margin-top: 8px;
        width: 100%;
        max-width: 820px;
        justify-content: center;
        align-items: stretch;
    }
    .info-box {
        border: 1px solid #e0d4c7;
        border-radius: 12px;
        padding: 12px 16px;
        background: #fff;
        box-shadow: 0 6px 16px rgba(0,0,0,0.04);
        min-height: 88px;
        text-align: left;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .info-box span {
        font-size: 11px;
        color: #8a7c70;
        letter-spacing: 0.4px;
        text-transform: uppercase;
    }
    .info-box strong {
        display: block;
        margin-top: 6px;
        font-size: 15px;
        color: #2f2c2a;
        letter-spacing: 0.2px;
        line-height: 1.28;
        word-break: normal;
        overflow-wrap: anywhere;
        max-width: 100%;
    }
    .bookings {
        display: grid;
        gap: 10px;
    }
    .booking-item {
        border: 1px solid #e0d4c7;
        border-radius: 12px;
        padding: 12px;
        background: #fff;
    }
    .booking-item strong {
        color: #7c6044;
    }
    .settings {
        border: 1px solid #e0d4c7;
        border-radius: 12px;
        padding: 12px;
        background: #fff;
    }
    .top-bar {
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    @media (max-width: 1200px) {
        .profile-hero { margin: 20px 12px; }
    }
    @media (max-width: 1024px) {
        .profile-shell { grid-template-columns: 1fr; }
        .profile-panel { grid-template-rows: auto auto; }
    }
    @media (max-width: 768px) {
        .profile-main { grid-template-columns: 1fr; text-align: center; }
        .profile-left { justify-items: center; }
        .profile-right { justify-items: center; max-width: 100%; margin-left: 0; }
        .info-grid { grid-template-columns: repeat(2, minmax(200px, 1fr)); gap: 12px; justify-items: center; }
        .side-menu { position: static; }
        .avatar-large { margin: 0 auto; }
    }
    @media (max-width: 576px) {
        .info-grid { grid-template-columns: 1fr; max-width: 100%; }
        .profile-hero { padding: 16px; }
        .profile-card { padding: 18px; }
        .profile-left { justify-items: center; }
        .avatar-large { margin: 0 auto; }
    }
    @media (max-width: 992px) {
        .profile-shell { grid-template-columns: 1fr; }
        .side-menu {
            position: fixed;
            top: 78px;
            left: -260px;
            width: 240px;
            max-height: 80vh;
            overflow-y: auto;
            z-index: 9;
            transition: left .2s ease;
        }
        .side-menu.open {
            left: 12px;
        }
        .menu-toggle {
            display: inline-flex;
            margin-bottom: 12px;
        }
        .menu-backdrop.show {
            display: block;
        }
    }
</style>

@php
    $displayName = $user->nama_user ?? $user->email;
    $initial = strtoupper(mb_substr($displayName ?? 'U', 0, 1));
    $memberSince = optional($user->created_at)->format('d M Y');
    $avatarUrl = $user->avatar_url;
    $hasAvatar = !empty($avatarUrl);

@endphp

<div class="container" style="margin-top: 10px; overflow: hidden;">
    <div class="profile-hero">
        <button class="menu-toggle" id="menuToggle" type="button">&#9776; Menu</button>
        <div class="profile-shell">
            <div class="side-menu" id="sideMenu">
                <a href="{{ route('profile.profile') }}" class="{{ ($tab ?? 'profile') === 'profile' ? 'active' : '' }}">Profile</a>
                <a href="{{ route('kamar.index') }}">Keranjang</a>
                <a href="{{ route('checkout') }}">Pemesanan</a>
                <a href="{{ route('profile.profile', ['tab' => 'history']) }}" class="{{ ($tab ?? 'profile') === 'history' ? 'active' : '' }}">Riwayat</a>
                <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                    @csrf
                    <button type="submit" class="logout">Log Out</button>
                </form>
            </div>

            <div class="profile-panel">
                @if(($tab ?? 'profile') === 'history')
                    <div class="panel-head">
                        <div>Riwayat Pemesanan</div>
                        <div>{{ $displayName }}</div>
                    </div>
                    <div class="bookings" style="max-height: calc(100vh - 260px); overflow-y: auto; padding-right: 8px;">
                        @forelse(($history ?? []) as $old)
                            <div class="booking-item" style="margin-bottom:10px;">
                                <strong>{{ $old->kamar->nama_kamar ?? 'Kamar' }}</strong>
                                <p style="font-size: 12px; color: #8a7c70;">
                                    Check-in {{ optional($old->check_in)->format('d M Y') }} ({{ $old->total_hari }} malam)
                                </p>
                                <p style="font-size: 13px; color: #7c6044;">
                                    Status Pembayaran: {{ strtoupper($old->pembayaran->status_pembayaran ?? 'Belum dibayar') }}
                                </p>
                            </div>
                        @empty
                            <div class="booking-item">
                                <strong>Belum ada riwayat pemesanan.</strong>
                            </div>
                        @endforelse
                    </div>
                @else
                <div class="profile-card">
                    <div class="profile-top">
                        <div class="brand-mark">
                            <span>D'Kasuari</span>
                        </div>
                        <div><strong>{{ $displayName }}</strong></div>
                    </div>

                    <div class="profile-main">
                        <div class="profile-left">
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
                            </div>
                        </div>
                        <div class="profile-right">
                            <div class="user-name">{{ $displayName }}</div>
                            <div class="label-badge">Member aktif</div>
                            <div class="member-since">Member sejak {{ $memberSince ?? '-' }}</div>
                            <div class="info-grid">
                                <div class="info-box">
                                    <span>Email</span>
                                    <strong>{{ $user->email }}</strong>
                                </div>
                                <div class="info-box">
                                    <span>Nomor Telepon</span>
                                    <strong>{{ $user->phone_number ?? '-' }}</strong>
                                </div>
                                <div class="info-box">
                                    <span>ID Pengguna</span>
                                    <strong>{{ $user->id_user }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="menu-backdrop" id="menuBackdrop"></div>

<script>
    (function() {
        const toggleBtn = document.getElementById('menuToggle');
        const sideMenu = document.getElementById('sideMenu');
        const backdrop = document.getElementById('menuBackdrop');

        const closeMenu = () => {
            sideMenu?.classList.remove('open');
            backdrop?.classList.remove('show');
            document.body.classList.remove('menu-open');
        };

        toggleBtn?.addEventListener('click', () => {
            const willOpen = !sideMenu?.classList.contains('open');
            if (willOpen) {
                sideMenu?.classList.add('open');
                backdrop?.classList.add('show');
                document.body.classList.add('menu-open');
            } else {
                closeMenu();
            }
        });

        backdrop?.addEventListener('click', closeMenu);
        window.addEventListener('resize', () => {
            if (window.innerWidth > 992) {
                closeMenu();
            }
        });
    })();
</script>
@endsection

