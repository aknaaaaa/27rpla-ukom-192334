<div class="card shadow-sm border-0 sticky-top" style="top: 96px;">
    <div class="card-body">
        <div class="d-flex align-items-center mb-3">
            <span class="badge bg-success me-2" id="cartCountBadge">0</span>
            <div>
                <p class="mb-0 small text-muted">Rooms</p>
                <strong id="cartDateSummary">Pilih tanggal & kamar</strong>
            </div>
        </div>
        <div id="cartItemsContainer" class="d-flex flex-column gap-2 mb-3 small text-muted">
            <span class="text-muted">Belum ada kamar di keranjang.</span>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-1">
            <span class="fw-semibold">Tanggal</span>
            <span class="text-muted small" id="cartDateSummary">Pilih check-in & out</span>
        </div>
        <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="fw-semibold">Total</span>
            <span class="fw-bold" id="cartTotal">Rp0</span>
        </div>
        <div class="d-grid gap-2">
            <button class="btn btn-outline-secondary btn-sm" type="button" id="viewCartBtn">Lihat Keranjang</button>
            <button class="btn btn-success btn-sm" type="button" id="checkoutBtn">Pesan Sekarang</button>
        </div>
    </div>
</div>

<style>
#cartItemsContainer .cart-item {
    border: 1px solid #eee;
    border-radius: 10px;
    padding: 10px;
    background: #fafafa;
}
#cartItemsContainer .cart-item img {
    width: 52px;
    height: 52px;
    object-fit: cover;
    border-radius: 8px;
}
#cartItemsContainer .input-group-sm > .form-control { font-size: 12px; }
#cartItemsContainer .input-group-sm > .btn { font-size: 12px; }
</style>

<script>
    (function() {
        const fmt = (num) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(num || 0);
        const getBookingDates = () => {
            try {
                return JSON.parse(localStorage.getItem('booking_dates') || '{}');
            } catch (e) {
                return {};
            }
        };
        const getNights = () => {
            const { check_in, check_out } = getBookingDates();
            if (!check_in || !check_out) return 1;
            const start = new Date(check_in);
            const end = new Date(check_out);
            const diffMs = end.getTime() - start.getTime();
            const nights = Math.round(diffMs / (1000 * 60 * 60 * 24));
            return nights > 0 ? nights : 1;
        };

        const renderCart = () => {
            const items = JSON.parse(localStorage.getItem('room_cart') || '[]');
            const container = document.getElementById('cartItemsContainer');
            const badge = document.getElementById('cartCountBadge');
            const totalEl = document.getElementById('cartTotal');
            const dateSummary = document.getElementById('cartDateSummary');
            const checkoutBtn = document.getElementById('checkoutBtn');
            let hasBlocked = false;

            if (!container || !badge || !totalEl) return;

            badge.textContent = items.length;
            container.innerHTML = '';

            const nights = getNights();
            if (dateSummary) {
                const { check_in, check_out } = getBookingDates();
                if (check_in && check_out) {
                    dateSummary.textContent = `${check_in} s/d ${check_out} (${nights} malam)`;
                } else {
                    dateSummary.textContent = 'Pilih tanggal & kamar';
                }
            }

            if (!items.length) {
                container.innerHTML = '<span class="text-muted">Belum ada kamar di keranjang.</span>';
                totalEl.textContent = 'Rp0';
                return;
            }

            let total = 0;
            items.forEach((item) => {
                const qty = Number(item.quantity || 1);
                const price = Number(item.harga || 0);
                const statusText = (item.status || 'Tersedia').toLowerCase();
                const isBlocked = statusText !== 'tersedia' && statusText !== 'available';
                if (isBlocked) hasBlocked = true;
                const subtotal = price * qty * (isBlocked ? 0 : nights);
                total += subtotal;
                const div = document.createElement('div');
                div.className = 'cart-item d-flex align-items-center gap-2';
                div.innerHTML = `
                    <img src="${item.gambar || '{{ asset('images/default.jpg') }}'}" alt="${item.nama || 'Kamar'}" onerror="this.onerror=null;this.src='{{ asset('images/default.jpg') }}';">
                    <div class="flex-grow-1">
                        <div class="fw-semibold d-flex justify-content-between align-items-center">
                            <span>${item.nama || 'Kamar'}</span>
                            <small class="text-muted">${nights} malam</small>
                        </div>
                        <div class="text-muted small">Check-in ${getBookingDates().check_in || '-'} | Check-out ${getBookingDates().check_out || '-'}</div>
                        <div class="text-muted small">${fmt(price)} x ${qty} kamar x ${nights} malam</div>
                        ${isBlocked ? '<div class="text-danger small fw-semibold">Tidak tersedia (maintenance / reservasi)</div>' : `<div class="fw-semibold">${fmt(subtotal)}</div>`}
                    </div>
                    <div class="d-flex flex-column align-items-end gap-1">
                        <div class="input-group input-group-sm" style="width:110px;">
                            <button class="btn btn-outline-secondary" type="button" data-dec="${item.id}">-</button>
                            <input type="number" class="form-control text-center" value="${qty}" min="1" data-qty="${item.id}">
                            <button class="btn btn-outline-secondary" type="button" data-inc="${item.id}">+</button>
                        </div>
                        <button class="btn btn-link text-danger p-0 small" data-remove="${item.id}">Hapus</button>
                    </div>
                `;
                container.appendChild(div);
            });

            totalEl.textContent = fmt(total);
            if (checkoutBtn) {
                checkoutBtn.disabled = hasBlocked;
                checkoutBtn.title = hasBlocked ? 'Hapus kamar yang tidak tersedia dulu.' : '';
            }

            container.querySelectorAll('[data-remove]').forEach((btn) => {
                btn.addEventListener('click', () => {
                    const id = Number(btn.getAttribute('data-remove'));
                    const filtered = items.filter((x) => Number(x.id) !== id);
                    if (window.cartStorage?.saveCart) {
                        window.cartStorage.saveCart(filtered);
                    } else {
                        localStorage.setItem('room_cart', JSON.stringify(filtered));
                        window.dispatchEvent(new CustomEvent('cart:updated'));
                    }
                    window.showAppToast?.('Kamar dihapus dari keranjang.', 'warning');
                });
            });

            // update quantity controls
            container.querySelectorAll('[data-dec]').forEach((btn) => {
                btn.addEventListener('click', () => changeQty(items, btn.getAttribute('data-dec'), -1));
            });
            container.querySelectorAll('[data-inc]').forEach((btn) => {
                btn.addEventListener('click', () => changeQty(items, btn.getAttribute('data-inc'), 1));
            });
            container.querySelectorAll('[data-qty]').forEach((input) => {
                input.addEventListener('change', () => setQty(items, input.getAttribute('data-qty'), Number(input.value || 1)));
            });
        };

        const changeQty = (items, id, delta) => {
            const updated = items.map((it) => {
                if (String(it.id) !== String(id)) return it;
                const stok = Number(it.stok || 0);
                let next = Number(it.quantity || 1) + delta;
                if (stok > 0) next = Math.min(next, stok);
                return { ...it, quantity: Math.max(1, next) };
            });
            window.cartStorage.saveCart(updated);
        };

        const setQty = (items, id, val) => {
            const updated = items.map((it) => {
                if (String(it.id) !== String(id)) return it;
                const stok = Number(it.stok || 0);
                let next = val;
                if (stok > 0) next = Math.min(next, stok);
                return { ...it, quantity: Math.max(1, next) };
            });
            window.cartStorage.saveCart(updated);
        };

        window.addEventListener('DOMContentLoaded', () => {
            renderCart();
            window.addEventListener('cart:updated', renderCart);
            window.addEventListener('booking:updated', renderCart);
            window.addEventListener('storage', (e) => {
                if (e.key === 'room_cart' || e.key === 'booking_dates') renderCart();
            });

            const viewBtn = document.getElementById('viewCartBtn');
            if (viewBtn) {
                viewBtn.addEventListener('click', async () => {
                    const items = JSON.parse(localStorage.getItem('room_cart') || '[]');
                    if (!items.length) {
                        window.showAppToast?.('Keranjang masih kosong.', 'info');
                        return;
                    }
                    const ok = window.requireAuth ? await window.requireAuth({}) : true;
                    if (!ok) return;
                    window.location.href = "{{ route('checkout') }}";
                });
            }

            const checkoutBtn = document.getElementById('checkoutBtn');
            if (checkoutBtn) {
                checkoutBtn.addEventListener('click', async () => {
                    const items = JSON.parse(localStorage.getItem('room_cart') || '[]');
                    if (!items.length) {
                        window.showAppToast?.('Keranjang masih kosong.', 'info');
                        return;
                    }
                    const ok = window.requireAuth ? await window.requireAuth({}) : true;
                    if (!ok) return;
                    window.location.href = "{{ route('checkout') }}";
                });
            }
        });
    })();
</script>
