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
.menu__item--logout{
    color:#c0392b;
    border:1px solid rgba(192,57,43,0.25);
    padding:10px 12px;
    border-radius:10px;
    font-weight:700;
}
.menu__item--logout .menu__icon{
    color:inherit;
}
.menu__item--logout:hover{
    background:#c0392b;
    color:#fff;
    border-color:#c0392b;
    transform:translateX(0);
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
            ['route' => 'admin.rooms', 'icon' => 'bi-door-open-fill', 'label' => 'Kamar', 'key' => 'rooms'],
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
        <a href="{{ route('logout.get') }}" class="menu__item menu__item--logout" onclick="localStorage.removeItem('room_cart');localStorage.removeItem('booking_dates');localStorage.removeItem('access_token');">
            <i class="bi bi-box-arrow-right menu__icon"></i> Keluar
        </a>
    </nav>
</aside>
