@extends('layouts.template')

@section('title', 'masuk')

@section('content')
<style>
    :root{
      --bg-url: url('{{ asset('images/resort-bg.jpg') }}');
      --card-width: 430px;
      --brand: #AB886D;
      --text: #2b2b2b;
    }

    *{ box-sizing: border-box; }

    body{
      margin:0;
      font-family: 'Aboreto', cursive;
      color: var(--text);
    }

    .page {
      position: relative;
      min-height: 100vh;
      display: grid;
      place-items: center;
      padding: 24px;
    }
    .page::before{
      content:"";
      position:absolute; inset:0;
      background: var(--bg-url) center/cover no-repeat;
      filter: brightness(0.85);
    }
    .page::after{
      content:"";
      position:absolute; inset:0;
      background: rgba(0,0,0,.15);
      pointer-events:none;
    }

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

    .card{
      position: relative;
      z-index: 2;
      width: min(100%, var(--card-width));
      background: #fff;
      border-radius: 18px;
      padding: 28px 28px 22px;
      box-shadow: 0 10px 26px rgba(0,0,0,.25);
      border: 1px solid rgba(0,0,0,.06);
    }

    .title{
      font-family: 'Aboreto', cursive;
      text-align: center;
      letter-spacing: 2px;
      margin: 2px 0 16px;
      color: #3a2c27;
      font-size: 24px;
    }
    .divider{
      height: 1px; width: 100%;
      background: #222;
      opacity: .3;
      margin-bottom: 14px;
    }

    .field{
      display: grid;
      gap: 6px;
      margin-bottom: 14px;
    }
    .label{
      font-size: 12px;
      letter-spacing: .8px;
      color: #333;
      font-weight: 600;
    }
    .input{
      width: 100%;
      border: 0;
      background: #e9e9e9;
      border-radius: 8px;
      padding: 12px 14px;
      font-size: 14px;
      color: #2b2b2b;
    }
    .input::placeholder{ color:#6f6f6f; }

    .btn{
      width: 100%;
      padding: 12px 16px;
      border-radius: 999px;
      border: 0;
      background: #2f2f2f;
      color: #fff;
      font-weight: 700;
      cursor: pointer;
    }

    .muted{
      margin-top: 10px;
      text-align: center;
      font-size: 12px;
      color: #555;
    }
    .muted a{
      color: var(--brand);
      font-weight: 700;
      text-decoration: none;
    }

    @media (max-width: 480px){
      :root{ --card-width: 92vw; }
      .card{ padding: 22px 18px; border-radius: 14px; }
    }
</style>

<a class="back" href="{{ route('layouts.index') }}">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path d="M15 18l-6-6 6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
    <span>Back</span>
</a>

<main class="page">
    <form class="card" id="loginForm" method="POST" action="{{ route('auth.api') }}">

        <h2 class="title">MASUK</h2>
        <div class="divider"></div>

        @if(Session::has('success_message'))
        <div class="alert alert-success" style="background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
            {{ Session::get('success_message') }}
        </div>
    @endif
    
    {{-- Kode untuk menampilkan pesan error validasi --}}
    @if ($errors->any())
        <div class="alert alert-danger" style="background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; padding: 10px; margin-bottom: 15px; border-radius: 5px;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

        <div class="field">
            <label class="label">EMAIL</label>
            <input class="input" type="email" name="email" placeholder="nama@email.com" required>
        </div>

        <div class="field">
            <label class="label">PASSWORD</label>
            <input class="input" type="password" name="password" placeholder="********" required>
        </div>

        <button class="btn" type="submit" id="loginBtn">Login</button>

        <p class="muted">
            Belum punya akun?
            <a href="{{ route('layouts.register') }}">Daftar</a>.
        </p>
    </form>
</main>

<script>
document.getElementById('loginForm').addEventListener('submit', async function (e) {
  e.preventDefault();

  const btn = document.getElementById('loginBtn');
  btn.disabled = true; btn.textContent = 'Logging in...';

  const form = e.target;
  const payload = {
    email: form.email.value,
    password: form.password.value
  };

  try {
    const res = await fetch('/api/auth/login', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        // Tidak perlu CSRF karena ini hit ke /api (stateless)
      },
      body: JSON.stringify(payload)
    });

    const data = await res.json();

    if (!res.ok || !data.success) {
      alert(data.message || 'Login gagal');
      btn.disabled = false; btn.textContent = 'Login';
      return;
    }

    // Simpan token untuk request berikutnya
    localStorage.setItem('access_token', data.access_token);

    // (opsional) langsung cek profil untuk verifikasi token
    const me = await fetch('/api/auth/profile', {
      headers: {
        'Authorization': 'Bearer ' + data.access_token
      }
    });

    if (me.ok) {
      // Redirect ke halaman setelah login (ganti sesuai kebutuhan)
      window.location.href = "{{ route('layouts.index') }}";
    } else {
      alert('Token tidak valid.');
      btn.disabled = false; btn.textContent = 'Login';
    }

  } catch (err) {
    console.error(err);
    alert('Terjadi kesalahan jaringan.');
    btn.disabled = false; btn.textContent = 'Login';
  }
});
</script>


@endsection
