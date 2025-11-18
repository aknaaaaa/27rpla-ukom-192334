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

        const addToCart = (payload) => {
            const items = getCart();
            const exists = items.find((item) => item.id === payload.id);
            if (exists) {
                exists.quantity = parsePrice(exists.quantity) || 1;
                exists.quantity += 1;
                saveCart(items);
                window.showAppToast?.('Jumlah kamar ditambah di keranjang.', 'info');
                return;
            }

            items.push({
                ...payload,
                quantity: parsePrice(payload.quantity) || 1,
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
                    const payload = {
                        id: Number(btn.getAttribute('data-id')),
                        nama: btn.getAttribute('data-nama') || 'Kamar',
                        harga: parsePrice(btn.getAttribute('data-price') || 0),
                        quantity: 1,
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
