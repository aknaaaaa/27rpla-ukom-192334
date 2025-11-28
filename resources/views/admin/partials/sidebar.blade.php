<style>
.sidebar.sticky-sidebar {
    position: sticky;
    top: 0;
    height: 100vh;
    overflow-y: auto;
}
@media (max-width: 960px) {
    .sidebar.sticky-sidebar {
        position: fixed;
        height: 100%;
        overflow-y: auto;
    }
}
</style>

<aside class="sidebar sticky-sidebar">
    <div class="brand">
        <p class="brand__name">D'Kasuari</p>
        <div class="brand__address">
            <i class="bi bi-geo-alt-fill"></i>
            <span>Jl. Kasuari RT 03 RW 18</span>
        </div>
    </div>

    @php(
        $menu = [
            ['route' => 'admin.dashboard', 'icon' => 'bi-grid-1x2-fill', 'label' => 'Dashboard', 'key' => 'dashboard'],
            ['route' => 'admin.rooms.index', 'icon' => 'bi-door-open-fill', 'label' => 'Kamar', 'key' => 'rooms'],
            ['route' => 'admin.orders', 'icon' => 'bi-box-seam', 'label' => 'Pesanan', 'key' => 'orders'],
            ['route' => 'admin.pelanggan', 'icon' => 'bi-people', 'label' => 'Penginap', 'key' => 'customers'],
        ]
    )

    <nav class="menu">
        @foreach($menu as $item)
            <a href="{{ $item['route'] === '#' ? '#' : route($item['route']) }}"
               class="menu__item {{ ($active ?? '') === $item['key'] ? 'is-active' : '' }}">
                <i class="bi {{ $item['icon'] }} menu__icon"></i> {{ $item['label'] }}
            </a>
        @endforeach
        <a href="#" onclick="doLogout()" class="menu__item">
            <i class="bi bi-box-arrow-right menu__icon"></i> Keluar
        </a>
    </nav>
</aside>

<script>
async function doLogout() {
    if (!confirm('Apakah Anda yakin ingin logout?')) {
        return;
    }

    const token = localStorage.getItem('access_token');
    
    try {
        const res = await fetch('{{ route('logout') }}', {
            method: 'POST',
            headers: {
                'Authorization': token ? 'Bearer ' + token : '',
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || ''
            },
            credentials: 'include',
            body: JSON.stringify({})
        });

        // Clear localStorage dan cookies
        localStorage.removeItem('access_token');
        document.cookie = 'sanctum_token=; Path=/; Expires=Thu, 01 Jan 1970 00:00:00 GMT';
        
        // Redirect ke login
        window.location.href = '{{ route('login') }}';
    } catch (e) {
        console.error('Logout error:', e);
        // Force logout bahkan jika request gagal
        localStorage.removeItem('access_token');
        document.cookie = 'sanctum_token=; Path=/; Expires=Thu, 01 Jan 1970 00:00:00 GMT';
        window.location.href = '{{ route('login') }}';
    }
}
</script>
