<aside class="sidebar">
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
            ['route' => '#', 'icon' => 'bi-people', 'label' => 'Pelanggan', 'key' => 'customers'],
        ]
    )

    <nav class="menu">
        @foreach($menu as $item)
            <a href="{{ $item['route'] === '#' ? '#' : route($item['route']) }}"
               class="menu__item {{ ($active ?? '') === $item['key'] ? 'is-active' : '' }}">
                <i class="bi {{ $item['icon'] }} menu__icon"></i> {{ $item['label'] }}
            </a>
        @endforeach
        <a href="{{ route('logout.get') }}" class="menu__item">
            <i class="bi bi-box-arrow-right menu__icon"></i> Keluar
        </a>
    </nav>
</aside>
