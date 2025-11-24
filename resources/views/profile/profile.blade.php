@extends('layouts.test')

@section('title', 'Profile')

@section('content')

<style>
    body { background: #e9f1ff; }
    .back{
      position: fixed;
      top: 18px; left: 18px;
      z-index: 5;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 8px 12px;
      font-size: 14px;
      font-weight: 600;
      color: #2b2b2b;
      background: #fff;
      border-radius: 8px;
      text-decoration: none;
      box-shadow: 0 4px 16px rgba(0,0,0,.16);
      border: 1px solid rgba(0,0,0,.06);
    }
    .back svg{ width:16px; height:16px }
    .profile-hero { border-radius: 6px; background: #f7fbff; padding: 15px 20px; }
    .profile-shell { display: grid; grid-template-columns: 240px 1fr; gap: 16px; align-items: start; }
    .side-menu { position: sticky; top: 88px; background: #f5f6f8; border: 1px solid #d5d9e1; border-radius: 12px; padding: 12px; display: grid; gap: 6px; }
    .side-menu a, .side-menu button { display: block; padding: 10px 12px; border-radius: 8px; text-decoration: none; color: #444; font-weight: 600; letter-spacing: 0.3px; background: #fff; border: 1px solid transparent; text-align: left; width: 100%; }
    .side-menu a.active, .side-menu button.active { background: #d5e8ff; border-color: #b7d5ff; }
    .side-menu button { border: none; }
    .side-menu a.logout, .side-menu button.logout { color: #c0392b; font-weight: 700; }
    .profile-panel { background: #faf7f4; border: 1px solid #e7d9ce; border-radius: 14px; padding: 18px; max-height: calc(100vh - 110px); overflow-y: auto; }
    .panel-head { display: flex; justify-content: space-between; align-items: center; margin-bottom: 14px; color: #7a6a5a; }
    .card-shell { background: linear-gradient(90deg, #fffaf5, #f5ece3); border: 1px solid #decfbe; border-radius: 16px; padding: 18px; display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }
    .card-left { display: grid; gap: 10px; }
    .name-line { display: flex; gap: 12px; align-items: center; }
    .avatar-large { width: 110px; height: 110px; border-radius: 50%; background: #bfa083; color: white; display: grid; place-items: center; font-size: 34px; overflow: hidden; position: relative; cursor: pointer; border: 2px solid rgba(255,255,255,0.5); box-shadow: 0 10px 25px rgba(0,0,0,0.08); transition: transform 0.2s ease, box-shadow 0.2s ease; }
    .avatar-large:hover { transform: translateY(-2px); box-shadow: 0 14px 28px rgba(0,0,0,0.12); }
    .avatar-large img { width: 100%; height: 100%; object-fit: cover; display: none; }
    .avatar-large.has-image img { display: block; }
    .avatar-large.has-image #avatarInitial { display: none; }
    .avatar-overlay { position: absolute; inset: 0; background: rgba(0,0,0,0.45); color: white; font-size: 12px; letter-spacing: 0.5px; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 4px; opacity: 0; transition: opacity 0.2s ease; text-transform: uppercase; pointer-events: none; }
    .avatar-large:hover .avatar-overlay, .avatar-large.is-uploading .avatar-overlay { opacity: 1; }
    .info-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 8px; }
    .info-box { border: 1px solid #e0d4c7; border-radius: 10px; padding: 10px; background: #fff; }
    .info-box span { font-size: 11px; color: #8a7c70; }
    .info-box strong { display: block; margin-top: 4px; font-size: 13px; }
    .bookings { display: grid; gap: 10px; }
    .booking-item { border: 1px solid #e0d4c7; border-radius: 12px; padding: 12px; background: #fff; }
    .booking-item strong { color: #7c6044; }
    .settings { border: 1px solid #e0d4c7; border-radius: 12px; padding: 12px; background: #fff; }
    .logout-btn { padding: 10px 18px; border: none; border-radius: 999px; background: #c0392b; color: #fff; font-weight: 600; letter-spacing: .5px; cursor: pointer; font-family: aboreto; }
    @media (max-width: 960px) { .profile-shell { grid-template-columns: 1fr; } .side-menu { position: static; } .profile-panel { max-height: none; overflow: visible; } .card-shell { grid-template-columns: 1fr; } .info-grid { grid-template-columns: repeat(2,1fr); } }
    @media (max-width: 640px) { .info-grid { grid-template-columns: 1fr; } }
</style>

@php
    $displayName = $user->nama_user ?? $user->email;
    $initial = strtoupper(mb_substr($displayName ?? 'U', 0, 1));
    $memberSince = optional($user->created_at)->format('d M Y');
    $avatarUrl = $user->avatar_url;
    $hasAvatar = !empty($avatarUrl);
@endphp

<a class="back" href="{{ route('layouts.index') }}">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path d="M15 18l-6-6 6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
    <span>Back</span>
</a>

<div class="container" style="margin-top: 30px;">
    <div class="profile-hero">
            <div class="profile-shell">
                <div class="side-menu">
                    <a href="{{ route('profile.profile') }}" class="{{ ($tab ?? 'profile') === 'profile' ? 'active' : '' }}">Profile</a>
                    <a href="{{ route('profile.profile', ['tab' => 'cart']) }}" class="{{ ($tab ?? 'profile') === 'cart' ? 'active' : '' }}">Keranjang</a>
                    <a href="{{ route('profile.profile', ['tab' => 'history']) }}" class="{{ ($tab ?? 'profile') === 'history' ? 'active' : '' }}">Riwayat</a>
                <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                    @csrf
                    <button type="submit" class="logout" onclick="localStorage.removeItem('room_cart');localStorage.removeItem('booking_dates');localStorage.removeItem('access_token');">Log Out</button>
                </form>
            </div>

            <div class="profile-panel">
                @if(($tab ?? 'profile') === 'history')
                    <div class="panel-head">
                        <div>Riwayat Pemesanan</div>
                        <div>{{ $displayName }}</div>
                    </div>
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
                @elseif(($tab ?? 'profile') === 'cart')
                    <div class="panel-head">
                        <div>Keranjang Saya</div>
                        <div>{{ $displayName }}</div>
                    </div>
                    <div id="cartPanel" class="bookings"></div>
                    <div class="booking-item">
                        <button class="btn btn-dark w-100" onclick="window.location.href='{{ route('checkout') }}'">Lanjut ke Checkout</button>
                    </div>
                @else
                    <div class="panel-head">
                        <div>D'Kasuari</div>
                        <div><strong>{{ $displayName }}</strong></div>
                    </div>

                    <div class="card-shell">
                        <div class="card-left">
                            <div class="name-line">
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
                                    <button type="button" id="removeAvatarBtn" class="btn btn-outline-secondary btn-sm mt-2 {{ $hasAvatar ? '' : 'd-none' }}">Hapus Foto</button>
                                </div>
                                <div>
                                    <div style="font-size: 18px; letter-spacing: 0.6px;">{{ $displayName }}</div>
                                    <div class="label-badge">Member aktif</div>
                                    <div style="font-size: 12px; color: #8a7c70;">Member sejak {{ $memberSince ?? '-' }}</div>
                                </div>
                            </div>
                            <div class="info-grid">
                                <div class="info-box">
                                    <span>Email</span>
                                    <strong>{{ $user->email }}</strong>
                                </div>
                                <div class="info-box">
                                    <span>No. Telp</span>
                                    <strong>{{ $user->phone_number ?? '-' }}</strong>
                                </div>
                                <div class="info-box">
                                    <span>ID Pengguna</span>
                                    <strong>{{ $user->id_user }}</strong>
                                </div>
                                <div class="info-box">
                                    <span>Status</span>
                                    <strong>{{ $user->role->nama_role}}</strong>
                                </div>
                            </div>
                        </div>

                        <div class="bookings">
                            <div style="font-weight: 700; color: #7c6044;">Pemesanan Aktif</div>
                            @forelse(($orders ?? []) as $order)
                                <div class="booking-item">
                                    <strong>{{ $order->kamar->nama_kamar ?? 'Kamar' }}</strong>
                                    <p style="font-size: 12px; color: #8a7c70;">
                                        Check-in {{ optional($order->check_in)->format('d M Y') }} | {{ $order->total_hari }} malam
                                    </p>
                                    @php
                                        $bayar = $order->pembayaran->amount_paid ?? 0;
                                        $statusBayar = $order->pembayaran->status_pembayaran ?? 'Belum dibayar';
                                    @endphp
                                    <p style="font-size: 13px; color: #7c6044;">
                                        Rp{{ number_format($bayar, 0, ',', '.') }} ({{ $statusBayar }})
                                    </p>
                                </div>
                            @empty
                                <div class="booking-item">
                                    <strong>Belum ada pemesanan aktif</strong>
                                    <p style="font-size: 12px; color: #8a7c70;">Silakan pesan kamar untuk melihat status.</p>
                                </div>
                            @endforelse

                            <div class="settings">
                                <div style="font-weight: 700; color: #7c6044; margin-bottom: 6px;">Pengaturan Akun</div>
                                <p style="font-size: 12px; color: #8a7c70; margin:0;">
                                    - Notifikasi Promo: Aktif<br>
                                    - Check-in Cepat: Aktif<br>
                                    - Mode Tenang: Nonaktif
                                </p>
                            </div>
                        </div>
                @endif
            </div>
        </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const avatarTrigger = document.getElementById('avatarTrigger');
    const avatarFileInput = document.getElementById('avatarFileInput');
    const avatarImage = document.getElementById('avatarImage');
    const removeAvatarBtn = document.getElementById('removeAvatarBtn');
    const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    const showToast = window.showAppToast || ((msg) => alert(msg));

    avatarTrigger?.addEventListener('click', () => avatarFileInput?.click());

    avatarFileInput?.addEventListener('change', async (e) => {
        const file = e.target.files?.[0];
        if (!file) return;

        if (file.size > 4 * 1024 * 1024) {
            showToast('Ukuran foto maksimal 4MB.', 'danger');
            return;
        }

        const formData = new FormData();
        formData.append('avatar', file);

        avatarTrigger?.classList.add('is-uploading');

        try {
            const res = await fetch("{{ route('profile.avatar') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json',
                },
                credentials: 'same-origin',
                body: formData,
            });
            const data = await res.json();
            if (!res.ok) {
                const msg = data?.message || 'Gagal mengunggah foto.';
                showToast(msg, 'danger');
                return;
            }

            const url = data.avatar_url || data.url || '';
            if (url && avatarImage) {
                avatarImage.src = url;
                avatarTrigger?.classList.add('has-image');
                removeAvatarBtn?.classList.remove('d-none');
            }
            showToast('Foto profil berhasil diperbarui.', 'success');
        } catch (err) {
            showToast('Terjadi kesalahan saat mengunggah foto.', 'danger');
        } finally {
            avatarTrigger?.classList.remove('is-uploading');
            if (avatarFileInput) avatarFileInput.value = '';
        }
    });

    removeAvatarBtn?.addEventListener('click', async () => {
        avatarTrigger?.classList.add('is-uploading');
        try {
            const res = await fetch("{{ route('profile.avatar.delete') }}", {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'Accept': 'application/json',
                },
                credentials: 'same-origin',
            });
            const data = await res.json();
            if (!res.ok) {
                const msg = data?.message || 'Gagal menghapus foto.';
                showToast(msg, 'danger');
                return;
            }
            if (avatarImage) {
                avatarImage.removeAttribute('src');
            }
            avatarTrigger?.classList.remove('has-image');
            removeAvatarBtn?.classList.add('d-none');
            showToast('Foto profil dihapus.', 'success');
        } catch (err) {
            showToast('Terjadi kesalahan saat menghapus foto.', 'danger');
        } finally {
            avatarTrigger?.classList.remove('is-uploading');
        }
    });

    // Render keranjang dari localStorage pada tab cart
    const cartPanel = document.getElementById('cartPanel');
    if (cartPanel) {
        const fmt = (num) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(num || 0);
        const items = JSON.parse(localStorage.getItem('room_cart') || '[]');
        const dates = JSON.parse(localStorage.getItem('booking_dates') || '{}');
        cartPanel.innerHTML = '';
        if (!items.length) {
            cartPanel.innerHTML = '<div class="booking-item"><strong>Keranjang kosong.</strong></div>';
        } else {
            const nights = (() => {
                if (!dates.check_in || !dates.check_out) return 1;
                const start = new Date(dates.check_in); const end = new Date(dates.check_out);
                const diff = Math.round((end - start)/(1000*60*60*24));
                return diff > 0 ? diff : 1;
            })();
            let total = 0;
            items.forEach(item => {
                const qty = Number(item.quantity || 1);
                const price = Number(item.harga || 0);
                const sub = price * qty * nights;
                total += sub;
                const node = document.createElement('div');
                node.className = 'booking-item';
                node.innerHTML = `
                    <strong>${item.nama || 'Kamar'}</strong>
                    <p style="font-size:12px;color:#8a7c70;">${qty} kamar x ${nights} malam</p>
                    <p style="font-size:13px;color:#7c6044;">${fmt(sub)}</p>
                `;
                cartPanel.appendChild(node);
            });
            const totalNode = document.createElement('div');
            totalNode.className = 'booking-item';
            totalNode.innerHTML = `<strong>Total</strong><p style="font-size:13px;color:#7c6044;">${fmt(total)}</p>`;
            cartPanel.appendChild(totalNode);
        }
    }
});
</script>
@endsection
