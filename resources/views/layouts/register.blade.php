@extends('layouts.template')

@section('title', 'daftar')

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

    /* Tombol Back */
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

    /* Kartu form */
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

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
    // Konfigurasi Axios
    axios.defaults.withCredentials = true;

    // Fungsi Register menggunakan Axios (AJAX)
    async function doRegister(nama_user, phone_number, email, password, password_confirmation) {
        try {
            // Dapatkan CSRF Cookie
            await axios.get('/sanctum/csrf-cookie');

            // Lakukan Register POST
            const response = await axios.post('{{ route('auth.register') }}', { 
                nama_user, 
                phone_number, 
                email, 
                password, 
                password_confirmation 
            }); 

            if(response.status === 201) {
                // Tampilkan pesan sukses dan arahkan ke login
                alert(response.data.message);
                location.href = '{{ route('layouts.login') }}';
            }
            
        } catch (error) {
            // Tangani error
            console.error("Register Gagal:", error.response);
            
            if(error.response?.status === 422) {
                // Error validasi
                const errors = error.response.data.errors;
                let errorMsg = 'Validasi gagal:\n';
                for(let field in errors) {
                    errorMsg += `- ${field}: ${errors[field].join(', ')}\n`;
                }
                alert(errorMsg);
            } else {
                alert(error.response?.data?.message || "Terjadi kesalahan saat registrasi.");
            }
        }
    }

    // Tambahkan Event Listener setelah DOM dimuat
    document.addEventListener('DOMContentLoaded', function() {
        const registerForm = document.getElementById('registerForm');
        
        // Mencegah submit form secara tradisional
        registerForm.addEventListener('submit', function(e) {
            e.preventDefault(); 
            
            const nama_user = registerForm.elements.nama_user.value;
            const phone_number = registerForm.elements.phone_number.value;
            const email = registerForm.elements.email.value;
            const password = registerForm.elements.password.value;
            const password_confirmation = registerForm.elements.password_confirmation.value;
            
            doRegister(nama_user, phone_number, email, password, password_confirmation);
        });
    });
</script>

<a class="back" href="{{ route('layouts.index') }}">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path d="M15 18l-6-6 6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
    <span>Back</span>
</a>

<main class="page">
    <form class="card" id="registerForm" method="POST" action="{{ route('auth.register') }}">


        <h2 class="title">DAFTAR</h2>
        <div class="divider"></div>

        <div id="alertMessage"></div>

        <div class="field">
            <label class="label">NAMA LENGKAP</label>
            <input class="input" type="text" name="nama_user" placeholder="Nama lengkap" required>
        </div>

        <div class="field">
            <label class="label">NOMOR TELEPON</label>
            <input class="input" type="tel" name="phone_number" placeholder="08xxxxxxxxxx" required>
        </div>

        <div class="field">
            <label class="label">EMAIL</label>
            <input class="input" type="email" name="email" placeholder="nama@email.com" required>
        </div>

        <div class="field">
            <label class="label">PASSWORD</label>
            <input class="input" type="password" name="password" placeholder="********" required>
        </div>

        <div class="field">
            <label class="label">KONFIRMASI PASSWORD</label>
            <input class="input" type="password" name="password_confirmation" placeholder="********" required>
        </div>

        <button class="btn" type="submit" id="registerBtn">DAFTAR</button>

        <p class="muted">
            Sudah punya akun?
            <a href="{{ route('layouts.login') }}">Masuk</a>.
        </p>
    </form>
</main>

@endsection