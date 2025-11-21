<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pelanggan - D'Kasuari</title>
    <link href="https://fonts.googleapis.com/css2?family=Aboreto&family=Mea+Culpa&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        :root { --text:#2c2c2c; --muted:#9a9a9a; --shadow:0 14px 22px rgba(0,0,0,0.08); }
        *{box-sizing:border-box;}
        body{margin:0;font-family:'Aboreto',sans-serif;color:var(--text);background:#f9f9f9;}
        .dashboard-shell{display:flex;min-height:100vh;}
        .sidebar{width:230px;background:#fff;box-shadow:8px 0 26px rgba(0,0,0,0.06);padding:28px 22px;z-index:2;}
        .brand{margin-bottom:18px;}
        .brand__name{font-family:'Mea Culpa',cursive;font-size:28px;margin:0;line-height:1.1;}
        .brand__address{display:flex;align-items:center;gap:8px;font-size:12px;letter-spacing:0.4px;color:var(--muted);text-transform:uppercase;}
        .menu{margin-top:40px;display:grid;gap:18px;}
        .menu__item{display:flex;align-items:center;gap:12px;color:var(--text);text-decoration:none;letter-spacing:1px;font-size:13px;text-transform:uppercase;transition:color .2s ease,transform .2s ease;}
        .menu__item:hover{color:#000;transform:translateX(4px);}
        .menu__item.is-active{font-weight:600;}
        .menu__icon{font-size:20px;width:22px;text-align:center;}
        .main{flex:1;padding:20px 34px 40px;position:relative;background:#fcfcfc;}
        .top-line{border-bottom:1px solid #e0e0e0;margin:8px 0 20px;}
        .card-detail{background:#fff;border:1px solid #d3d3d3;border-radius:16px;box-shadow:var(--shadow);padding:20px;}
        .detail-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:14px;margin-top:12px;}
        .field{padding:12px 12px 10px;border:1px solid #ececec;border-radius:12px;background:#fafafa;}
        .field label{display:block;font-size:12px;letter-spacing:0.6px;color:#777;margin-bottom:6px;}
        .field .value{font-size:15px;font-weight:600;letter-spacing:0.4px;}
        .actions{margin-top:16px;display:flex;gap:10px;flex-wrap:wrap;}
        .btn{display:inline-flex;align-items:center;gap:8px;padding:10px 14px;border-radius:10px;border:1px solid #cfcfcf;background:#fff;color:#2c2c2c;text-decoration:none;font-size:13px;cursor:pointer;transition:all .2s ease;}
        .btn:hover{box-shadow:0 10px 18px rgba(0,0,0,0.08);transform:translateY(-1px);}
        .btn-dark{background:#2c2c2c;color:#fff;border-color:#2c2c2c;}
        .avatar-block{display:flex;align-items:center;gap:14px;margin-top:10px;}
        .avatar{width:70px;height:70px;border-radius:50%;background:#2c2c2c;color:#fff;display:grid;place-items:center;font-size:24px;overflow:hidden;}
        .avatar img{width:100%;height:100%;object-fit:cover;display:none;}
        .hamburger {
            position: fixed;
            top: 16px;
            left: 16px;
            width: 42px;
            height: 42px;
            border-radius: 10px;
            border: 1px solid #cfcfcf;
            background: #fff;
            display: none;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            z-index: 120;
            box-shadow: 0 10px 16px rgba(0,0,0,0.08);
            cursor: pointer;
        }
        @media(max-width:960px){
            .dashboard-shell{flex-direction:column;}
            .sidebar{
                position:fixed;
                inset:0 auto 0 0;
                width:250px;
                transform: translateX(-100%);
                box-shadow:0 6px 16px rgba(0,0,0,0.12);
                background:#fff;
                z-index:110;
                transition: transform 0.25s ease;
                padding-top:72px;
            }
            .sidebar.is-open { transform: translateX(0); }
            .sidebar .menu { grid-template-columns: 1fr; }
            .main{padding:18px; padding-left:16px; padding-right:16px;}
            .hamburger { display: inline-flex; }
        }
    </style>
</head>
<body>
    <button class="hamburger" id="sidebarToggle" aria-label="Toggle menu"><i class="bi bi-list"></i></button>
    <div class="dashboard-shell">
        @include('admin.partials.sidebar', ['active' => 'customers'])

        <main class="main">
            <div class="top-line"></div>
            <div class="card-detail">
                <h2 style="margin:0;font-size:22px;">Detail Pengguna</h2>
                <p style="margin:4px 0 12px;color:#777;">Data lengkap pengguna</p>

                <div class="avatar-block">
                    <div class="avatar">
                        <span id="adminAvatarInitial">{{ strtoupper(substr($customer->nama_user ?? 'U', 0, 1)) }}</span>
                        <img id="adminAvatarImg" alt="Foto profil" style="{{ $customer->avatar_url ? 'display:block' : 'display:none' }}" @if($customer->avatar_url) src="{{ $customer->avatar_url }}" @endif>
                    </div>
                    <div>
                        <div style="font-weight:600;">{{ $customer->nama_user }}</div>
                        <div style="font-size:12px;color:#777;">{{ $customer->email }}</div>
                    </div>
                </div>

                <div class="detail-grid">
                    <div class="field">
                        <label>Nama</label>
                        <div class="value">{{ $customer->nama_user }}</div>
                    </div>
                    <div class="field">
                        <label>Email</label>
                        <div class="value">{{ $customer->email }}</div>
                    </div>
                    <div class="field">
                        <label>No Telepon</label>
                        <div class="value">{{ $customer->phone_number }}</div>
                    </div>
                    <div class="field">
                        <label>Role</label>
                        <div class="value">{{ $customer->role_name ?? '-' }}</div>
                    </div>
                    <div class="field">
                        <label>Tanggal Bergabung</label>
                        <div class="value">{{ optional($customer->created_at)->translatedFormat('d M Y') ?? '-' }}</div>
                    </div>
                    <div class="field">
                        <label>Terakhir Diperbarui</label>
                        <div class="value">{{ optional($customer->updated_at)->translatedFormat('d M Y H:i') ?? '-' }}</div>
                    </div>
                </div>

                <div class="actions">
                    <a href="{{ route('admin.pelanggan') }}" class="btn">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </main>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggle = document.getElementById('sidebarToggle');
            const sidebar = document.querySelector('.sidebar');
            toggle?.addEventListener('click', function (e) {
                e.stopPropagation();
                sidebar?.classList.toggle('is-open');
            });
            document.addEventListener('click', function (e) {
                if (window.innerWidth > 960) return;
                if (!sidebar?.classList.contains('is-open')) return;
                if (!sidebar.contains(e.target) && e.target !== toggle) {
                    sidebar.classList.remove('is-open');
                }
            });
        });
    </script>
</body>
</html>
