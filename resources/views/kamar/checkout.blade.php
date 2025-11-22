@extends('layouts.app')

@section('title', 'Pembayaran')

@section('content')
<style>
    .checkout-hero {
        background: #e9f1ff;
        border: 2px solid #2d8cff;
        border-radius: 6px;
        padding: 18px 24px;
        margin-top: 78px;
    }
    .checkout-shell {
        background: #fff;
        border-radius: 4px;
        padding: 24px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.04);
        border: 1px solid #e8e8e8;
    }
    .brand-title {
        font-family: 'Mea Culpa', cursive;
        font-size: 32px;
        color: #000;
    }
    .mini-label {
        font-size: 11px;
        letter-spacing: 0.6px;
        text-transform: uppercase;
        color: #7a7a7a;
    }
    .pill-card {
        border: 1px solid #d5d5d5;
        border-radius: 14px;
        padding: 22px 22px 10px;
        background: #fafafa;
    }
    .pill-card h6,
    .pill-card h5 {
        letter-spacing: 0.7px;
    }
    .method-list {
        border-top: 1px solid #2d2d2d;
        padding-top: 16px;
        margin-top: 18px;
    }
    .method-item {
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 0;
        border-bottom: 1px solid #d9d9d9;
    }
    .method-item:last-child { border-bottom: none; }
    .method-logo {
        width: 72px;
        height: 36px;
        border: 1px solid #dcdcdc;
        border-radius: 8px;
        background: #f5f5f5;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        color: #888;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .pay-btn {
        background: #272727;
        color: #fff;
        border-radius: 8px;
        height: 44px;
        font-weight: 600;
        letter-spacing: 0.3px;
        border: none;
    }
    .pay-btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
    }
    .pay-btn:hover:not(:disabled) { background: #111; }
    .order-box {
        border: 1px solid #cfcfcf;
        border-radius: 16px;
        padding: 22px;
        height: 100%;
    }
    .order-line {
        display: flex;
        justify-content: space-between;
        font-size: 13px;
        padding: 8px 0;
    }
    .order-line strong { letter-spacing: 0.4px; }
    .order-item {
        border: 1px solid #ededed;
        border-radius: 10px;
        padding: 10px;
        background: #fafafa;
        display: flex;
        gap: 10px;
        align-items: center;
    }
    .order-thumb {
        width: 52px;
        height: 52px;
        border-radius: 8px;
        object-fit: cover;
        background: #f0f0f0;
    }
</style>

<div class="container">
    <div class="checkout-hero">
        <div class="checkout-shell">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <div class="brand-title">D'Kasuari</div>
                    <div class="d-flex align-items-center gap-2 text-muted" style="font-size: 12px;">
                        <span>Lokasi:</span>
                        <span>Jl. Kasuari RT 03 RW 18</span>
                    </div>
                </div>
                <div class="text-uppercase" style="font-size: 11px; letter-spacing: 1px;">
                    <a href="#" class="me-3 text-decoration-none text-dark">My Order</a>
                    <a href="#" class="me-3 text-decoration-none text-dark">Cart</a>
                    <a href="#" class="text-decoration-none text-dark">My Account</a>
                </div>
            </div>

            <div class="row mt-4 g-4">
                <div class="col-lg-7">
                    <div class="pill-card">
                        <input type="hidden" id="orderIdHidden" value="{{ session('checkout_order.id_pemesanan') ?? request('order_id') }}">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0">Pilih Metode Pembayaran</h6>
                            <small class="mini-label">BCA | BNI | GOPAY | QRIS</small>
                        </div>

                        <div class="method-list">
                            <div class="method-item">
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ asset('images/bca.jpeg') }}" alt="BCA" height="48" width="72" class="rounded border">
                                    <div>
                                        <strong>BCA Virtual Account</strong>
                                        <div class="text-muted" style="font-size: 12px;">Transfer via ATM / m-banking</div>
                                    </div>
                                </div>
                                <input type="radio" name="pay_method" value="bca" checked>
                            </div>
                            <div class="method-item">
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ asset('images/bni.jpeg') }}" alt="BNI" height="48" width="72" class="rounded border">
                                    <div>
                                        <strong>BNI Virtual Account</strong>
                                        <div class="text-muted" style="font-size: 12px;">Transfer via ATM / m-banking</div>
                                    </div>
                                </div>
                                <input type="radio" name="pay_method" value="bni">
                            </div>
                            <div class="method-item">
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ asset('images/gopay.jpeg') }}" alt="GoPay" height="48" width="72" class="rounded border">
                                    <div>
                                        <strong>GoPay</strong>
                                        <div class="text-muted" style="font-size: 12px;">Scan QR / buka GoPay</div>
                                    </div>
                                </div>
                                <input type="radio" name="pay_method" value="gopay">
                            </div>
                            <div class="method-item">
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ asset('images/qris.jpeg') }}" alt="QRIS" height="48" width="72" class="rounded border">
                                    <div>
                                        <strong>QRIS</strong>
                                        <div class="text-muted" style="font-size: 12px;">Scan QRIS dari saldo apa saja</div>
                                    </div>
                                </div>
                                <input type="radio" name="pay_method" value="qris">
                            </div>
                            <div class="method-item" style="background: #fff9e6; border-radius: 8px; padding: 10px;">
                                <div class="d-flex align-items-center gap-3">
                                    <div style="width: 72px; height: 48px; border-radius: 8px; background: #ffd700; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 10px; color: #333;">TEST</div>
                                    <div>
                                        <strong>🧪 Test Mode (Instant Success)</strong>
                                        <div class="text-muted" style="font-size: 12px;">Langsung mark as paid untuk testing</div>
                                    </div>
                                </div>
                                <input type="radio" name="pay_method" value="test_success">
                            </div>
                        </div>

                        <button id="payBtn" class="w-100 pay-btn mt-3" type="button">Bayar Sekarang</button>
                        <small class="text-muted d-block mt-2" style="font-size: 12px;">Jumlah pembayaran mengikuti ringkasan pesanan di kanan.</small>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="order-box">
                        <h6 class="mb-3">Data Pesanan</h6>
                        <div id="orderEmpty" class="alert alert-warning py-2 px-3 small">
                            Keranjang masih kosong. Tambah kamar dulu agar data pembayaran sama dengan konfirmasi sebelumnya.
                        </div>
                        <div id="orderItems" class="d-flex flex-column gap-3 mb-3"></div>
                        <hr>
                        <div class="order-line">
                            <span>Subtotal</span>
                            <strong id="orderSubtotal">Rp0</strong>
                        </div>
                        <div class="order-line">
                            <span>Tax & Service (10%)</span>
                            <strong id="orderTax">Rp0</strong>
                        </div>
                        <div class="order-line" style="font-size: 14px; font-weight: 700;">
                            <span>Total</span>
                            <strong id="orderTotal">Rp0</strong>
                        </div>
                        <p class="text-muted mt-3 mb-0" style="font-size: 12px;">Angka di atas diambil dari keranjang/konfirmasi sebelumnya. Saat integrasi Core API, kirim total ini ke backend untuk dibuatkan charge Midtrans.</p>
                        <div id="paymentResult" class="mt-3 small"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
        const fmt = (num) => new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
        }).format(num || 0);

        const renderOrder = () => {
            const items = JSON.parse(localStorage.getItem('room_cart') || '[]');
            const list = document.getElementById('orderItems');
            const empty = document.getElementById('orderEmpty');
            const subtotalEl = document.getElementById('orderSubtotal');
            const taxEl = document.getElementById('orderTax');
            const totalEl = document.getElementById('orderTotal');
            const payBtn = document.getElementById('payBtn');

            if (!list) return;

            list.innerHTML = '';

            if (!items.length) {
                empty?.classList.remove('d-none');
                subtotalEl.textContent = fmt(0);
                taxEl.textContent = fmt(0);
                totalEl.textContent = fmt(0);
                if (payBtn) payBtn.disabled = true;
                return;
            }

            empty?.classList.add('d-none');
            let subtotal = 0;

            items.forEach((item) => {
                const qty = Number(item.quantity || 1);
                const price = Number(item.harga || 0);
                const img = item.gambar || "{{ asset('images/default.jpg') }}";
                subtotal += price * qty;

                const row = document.createElement('div');
                row.className = 'order-item';
                row.innerHTML = `
                    <img src="${img}" alt="${item.nama || 'Kamar'}" class="order-thumb">
                    <div class="flex-grow-1">
                        <div class="fw-semibold">${item.nama || 'Kamar'}</div>
                        <div class="text-muted" style="font-size: 12px;">${qty} x ${fmt(price)}</div>
                    </div>
                    <div class="fw-semibold">${fmt(price * qty)}</div>
                `;
                list.appendChild(row);
            });

            const tax = Math.round(subtotal * 0.10);
            const total = subtotal + tax;

            subtotalEl.textContent = fmt(subtotal);
            taxEl.textContent = fmt(tax);
            totalEl.textContent = fmt(total);

            if (payBtn) {
                payBtn.disabled = false;
                payBtn.setAttribute('data-total', total.toString());
            }
        };

        window.addEventListener('DOMContentLoaded', renderOrder);
        window.addEventListener('cart:updated', renderOrder);

            const payBtn = document.getElementById('payBtn');
            const resultBox = document.getElementById('paymentResult');
            const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            const orderId = document.getElementById('orderIdHidden')?.value?.trim();

            const setResult = (html, variant = 'info') => {
                if (!resultBox) return;
                resultBox.className = `mt-3 small alert alert-${variant}`;
                resultBox.innerHTML = html;
            };
            const copyVA = async (text, buttonEl) => {
                try {
                    await navigator.clipboard.writeText(text);
                    buttonEl.textContent = 'Disalin';
                    setTimeout(() => { buttonEl.textContent = 'Copy'; }, 1200);
                } catch (err) {
                    setResult('Gagal menyalin VA. Salin manual: ' + text, 'warning');
                }
            };

            payBtn?.addEventListener('click', async () => {
                const items = JSON.parse(localStorage.getItem('room_cart') || '[]');
                if (!items.length) {
                    setResult('Keranjang masih kosong. Tambah kamar dulu.', 'warning');
                return;
            }

            const method = document.querySelector('input[name="pay_method"]:checked')?.value;
            if (!method) {
                setResult('Pilih metode pembayaran dulu.', 'warning');
                return;
            }

            const total = Number(payBtn.getAttribute('data-total') || 0);
            if (!total) {
                setResult('Total pembayaran tidak valid.', 'warning');
                return;
            }

            // Test mode - instant success
            if (method === 'test_success') {
                setResult('✅ Pembayaran berhasil (Test Mode)<br>Redirecting ke halaman sukses...', 'success');
                setTimeout(() => {
                    window.location.href = "{{ route('checkout.success') }}";
                }, 1500);
                return;
            }

            const payload = {
                payment_method: method,
                amount: total,
                items: items.map((item) => ({
                    id: item.id ?? item.kamar_id ?? item.room_id,
                    name: item.nama || 'Kamar',
                    price: Number(item.harga || 0),
                    quantity: Number(item.quantity || 1),
                })),
            };
            if (orderId) {
                payload.id_pemesanan = orderId;
            }

            setResult('Membuat transaksi ke Midtrans...', 'info');
            payBtn.disabled = true;

                try {
                    const res = await fetch("{{ route('api.payments.charge') }}", {
                        method: 'POST',
                        credentials: 'same-origin',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrf,
                        },
                        body: JSON.stringify(payload),
                    });
                const data = await res.json();
                if (!res.ok) {
                    const msg = data?.message || 'Gagal membuat pembayaran.';
                    setResult(msg, 'danger');
                    return;
                }

                let instruction = '';
                if (data.va_numbers?.length) {
                    const va = data.va_numbers[0];
                    const vaNum = va.va_number;
                    const bank = (va.bank || '').toUpperCase();
                    instruction = `
                        <div class="d-flex align-items-center gap-2">
                            <div>
                                <strong>Virtual Account ${bank}:</strong>
                                <div>${vaNum}</div>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-secondary" data-copy-va="${vaNum}">Copy</button>
                        </div>
                    `;
                } else if (data.actions?.length) {
                    const goAction = data.actions.find((a) => a.name === 'deeplink-redirect') || data.actions.find((a) => a.url) || data.actions[0];
                    const label = method === 'gopay' ? 'Buka GoPay' : 'Buka tautan pembayaran';
                    instruction = `${label}: <a href="${goAction.url}" target="_blank" rel="noreferrer">${goAction.url}</a>`;
                } else if (data.qr_string) {
                    instruction = `QRIS string:<br><code style="word-break: break-all;">${data.qr_string}</code>`;
                } else {
                    instruction = 'Transaksi dibuat. Detail:<br><pre class="mb-0 small bg-light p-2 border rounded">' + JSON.stringify(data, null, 2) + '</pre>';
                }

                setResult(`Transaksi berhasil dibuat.<br>${instruction}`, 'success');
                // Attach copy handler after render
                const copyBtn = resultBox?.querySelector('[data-copy-va]');
                if (copyBtn) {
                    copyBtn.addEventListener('click', () => copyVA(copyBtn.getAttribute('data-copy-va'), copyBtn));
                }
                if (method === 'qris' || method === 'gopay') {
                    setTimeout(() => {
                        window.location.href = "{{ route('checkout.success') }}";
                    }, 500);
                }
            } catch (error) {
                setResult('Terjadi kesalahan jaringan.', 'danger');
            } finally {
                payBtn.disabled = false;
            }
        });
    })();
</script>
@endsection
