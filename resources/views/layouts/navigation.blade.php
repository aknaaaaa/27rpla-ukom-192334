<nav class="navbar navbar-expand-lg navbar-light navbar-custom px-4">
    <div class="w-100 d-flex align-items-center justify-content-between">
        <a class="navbar-brand font-mea" href="#">D'Kasuari</a>
        <div class="d-flex align-items-center">
            <a href="{{ route('kamar.index') }}" class="btn btn-dark me-3 font-aboreto">PESAN SEKARANG</a>
            <ul class="navbar-nav flex-row">
                <li class="nav-item"><a class="nav-link font-aboreto px-2" href="#">Tentang</a></li>
                <li class="nav-item"><a class="nav-link font-aboreto px-2" href="#">Produk</a></li>
                <li class="nav-item"><a class="nav-link font-aboreto px-2" href="#">Layanan</a></li>
                <li class="nav-item"><a class="nav-link font-aboreto px-2" href="#">Kontak</a></li>
                <li class="nav-item"><a class="nav-link px-3" onclick="cekProfil()"><img src="images/person-circle.svg"></a></li>

            </ul>
        </div>
    </div>
</nav> 

<script>
async function cekProfil(){
  const token = localStorage.getItem('access_token');
  if(!token){ window.location.href = "{{ route('layouts.register') }}"; return; }
  const res = await fetch('/api/auth/profile', {
    headers: { 'Authorization': 'Bearer ' + token }
  }
);
  const data = await res.json();
  if(res.ok){
    console.log('User:', data.user);
    alert('Halo, ' + (data.user?.nama_user || data.user?.email));
  } else {
    alert('Unauthorized');
  }
}
</script>