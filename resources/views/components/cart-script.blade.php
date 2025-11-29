<script>
    (function() {
        const getCart = () => {
            try {
                return JSON.parse(localStorage.getItem('room_cart') || '[]');
            } catch (error) {
                console.error('Gagal mengambil keranjang', error);
                return [];
            }
        };

        const parsePrice = (value) => {
            if (typeof value === 'number') return value;
            if (!value) return 0;
            const cleaned = String(value).replace(/[^0-9]/g, '');
            return Number.parseInt(cleaned || '0', 10);
        };

        const notify = () => {
            window.dispatchEvent(new CustomEvent('cart:updated'));
        };

        const saveCart = (items) => {
            localStorage.setItem('room_cart', JSON.stringify(items));
            notify();
        };

        const isAvailable = (status) => {
            if (!status) return true;
            const s = String(status).toLowerCase();
            return s === 'tersedia' || s === 'available';
        };

        const addToCart = (payload) => {
            if (!isAvailable(payload.status)) {
                window.showAppToast?.('Kamar ini sedang tidak tersedia.', 'warning');
                return;
            }
            const items = getCart();
            const stok = Number(payload.stok || 0);
            const exists = items.find((item) => item.id === payload.id);
            const incomingQty = parsePrice(payload.quantity) || 1;

            if (exists) {
                const next = Math.max(1, exists.quantity + incomingQty);
                exists.quantity = stok > 0 ? Math.min(next, stok) : next;
                exists.stok = stok || exists.stok;
                saveCart(items);
                window.showAppToast?.('Jumlah kamar ditambah di keranjang.', 'info');
                return;
            }

            const qty = stok > 0 ? Math.min(incomingQty, stok) : incomingQty;
            items.push({
                ...payload,
                stok: stok || undefined,
                quantity: qty,
            });
            saveCart(items);
            window.showAppToast?.('Kamar ditambahkan ke keranjang.', 'success');
        };

        window.cartStorage = { getCart, saveCart };

        const registerCartButtons = () => {
            const buttons = document.querySelectorAll('[data-action="add-to-cart"]');
            buttons.forEach((btn) => {
                btn.addEventListener('click', async (event) => {
                    event.preventDefault();
                    const qtyInput = btn.closest('.card-room-modern')?.querySelector('[data-qty-input]');
                    const quantityVal = qtyInput ? Number(qtyInput.value || 1) : 1;
                    const payload = {
                        id: Number(btn.getAttribute('data-id')),
                        nama: btn.getAttribute('data-nama') || 'Kamar',
                        harga: parsePrice(btn.getAttribute('data-price') || 0),
                        status: btn.getAttribute('data-status') || 'Tersedia',
                        quantity: quantityVal,
                        stok: Number(btn.getAttribute('data-stok') || 0),
                        gambar: btn.getAttribute('data-gambar') || undefined,
                    };

                    const isAllowed = window.requireAuth
                        ? await window.requireAuth({ nama: payload.nama, gambar: payload.gambar })
                        : true;

                    if (!isAllowed) return;
                    addToCart(payload);
                });
            });
        };

        window.addEventListener('DOMContentLoaded', registerCartButtons);
    })();
</script>
