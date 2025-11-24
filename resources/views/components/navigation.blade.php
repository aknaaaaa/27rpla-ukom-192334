<nav class="navbar navbar-expand-lg navbar-light navbar-custom px-4">
    <div class="w-100 d-flex align-items-center justify-content-between">

        <!-- Brand -->
        <a class="navbar-brand font-mea" href="#">D'Kasuari</a>

        <!-- Menu -->
        <div class="d-flex align-items-center">

            <!-- Tombol Pesan -->
            <a href="{{ route('kamar.index') }}" class="btn btn-dark font-aboreto">
                PESAN SEKARANG
            </a>

            <!-- Menu Link -->
            <ul class="navbar-nav flex-row">
                <li class="nav-item">
                    <a class="nav-link font-aboreto px-2" href="#">Tentang</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link font-aboreto px-2" href="#">Produk</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link font-aboreto px-2" href="#">Layanan</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link font-aboreto px-2" href="#">Kontak</a>
                </li>

                <!-- Profil -->
                <li class="nav-item">
                    <a class="nav-link px-3" onclick="cekProfil()">
                        <img src="{{ asset('images/person-circle.svg') }}" width="26">
                    </a>
                </li>
            </ul>

        </div>
    </div>
</nav>
<script>
async function cekProfil(){
  const token = localStorage.getItem('access_token');

  if(!token){
    window.location.href = "{{ route('login') }}";
    return;
  }

  try{
    const res = await fetch('/api/check-auth', {
      method: 'GET',
      headers: {
        'Authorization': 'Bearer ' + token,
        'Accept': 'application/json'
      },
      credentials: 'include',
    });

    if(res.ok){
      window.location.href = "{{ route('profile.profile') }}";
      return;
    }
  }catch(e){
    console.error(e);
  }

  localStorage.removeItem('access_token');
  document.cookie = 'sanctum_token=; Path=/; Expires=Thu, 01 Jan 1970 00:00:00 GMT';
  window.location.href = "{{ route('login') }}";
}
</script>
