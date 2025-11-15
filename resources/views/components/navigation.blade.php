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
async function cekProfil() {
    const token = localStorage.getItem('access_token');

    // Jika belum login → arahkan ke halaman register
    if (!token) {
        window.location.href = "{{ route('register') }}";
        return;
    }

    try {
        const res = await fetch('/api/auth/profile', {
            headers: { 'Authorization': 'Bearer ' + token }
        });

        const data = await res.json();

        if (res.ok) {
            alert('Halo, ' + (data.user?.nama_user || data.user?.email));
        } else {
            alert('Unauthorized');
        }

    } catch (err) {
        alert('Terjadi kesalahan, coba lagi.');
        console.error(err);
    }
}
</script>
