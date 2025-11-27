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
    .booking-shell {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: 20px;
    }
    @media (max-width: 992px) {
        .booking-shell {
            grid-template-columns: 1fr;
        }
    }
    .info-card {
        border: 1px solid #d6d6d6;
        border-radius: 16px;
        padding: 20px;
        background: #fbfbfb;
    }
    .info-card h6 {
        letter-spacing: 0.8px;
        margin-bottom: 16px;
    }
    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 12px;
    }
    .form-grid label {
        display: block;
        font-size: 12px;
        color: #7c7c7c;
        margin-bottom: 4px;
    }
    .form-grid input,
    .form-grid textarea {
        border-radius: 8px;
        border: 1px solid #ddd;
        padding: 10px;
        background: #fff;
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
    .summary-card {
        border: 1px solid #cda582;
        border-radius: 16px;
        padding: 20px;
        background: linear-gradient(135deg, #fdf3ea, #f6ebe0);
    }
    .summary-header {
        font-weight: 700;
        color: #6b5138;
        margin-bottom: 12px;
    }
    .summary-item {
        border: 1px solid #d3b59a;
        border-radius: 12px;
        padding: 12px;
        background: rgba(255,255,255,0.75);
        margin-bottom: 10px;
    }
    .summary-item strong {
        color: #704c2f;
    }
    .summary-total {
        display: flex;
        justify-content: space-between;
        font-size: 16px;
        font-weight: 700;
        color: #5a4129;
        margin-top: 12px;
        border-top: 1px solid #d3b59a;
        padding-top: 10px;
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
    .method-groups { display: grid; gap: 12px; }
    .method-group {
        border: 1px solid #d5d5d5;
        border-radius: 12px;
        padding: 14px;
        background: #fefefe;
    }
    .group-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }
    .group-title { font-weight: 700; letter-spacing: 0.4px; }
    .group-desc { font-size: 12px; color: #6a6a6a; margin-top: 2px; }
    .group-body { margin-top: 10px; display: flex; align-items: center; justify-content: space-between; gap: 10px; flex-wrap: wrap; }
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
    .method-chip {
        background: #f1f7ff;
        color: #1f5fbf;
        border: 1px solid #cfe0ff;
        border-radius: 30px;
        padding: 4px 10px;
        font-size: 11px;
        letter-spacing: 0.4px;
        font-weight: 600;
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
            </div>

            <div class="booking-shell mt-4">
                <div class="info-card">
                    <h6>Informasi Tamu</h6>
                    <div class="form-grid mb-3">
                        <div>
                            <label>Nama Lengkap</label>
                            <input type="text" id="guestName" value="{{ $user->nama_user ?? '' }}" placeholder="Nama pemesan">
                        </div>
                        <div>
                            <label>Email</label>
                            <input type="email" id="guestEmail" value="{{ $user->email ?? '' }}" placeholder="email@example.com">
                        </div>
                        <div>
                            <label>Nomor Telepon</label>
                            <input type="text" id="guestPhone" value="{{ $user->phone_number ?? '' }}" placeholder="08xxxxxxxxxxx">
                        </div>
                        <div>
                            <label>Check-in</label>
                            <input type="date" id="checkInInput">
                        </div>
                        <div>
                            <label>Check-out</label>
                            <input type="date" id="checkOutInput">
                        </div>
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="otherGuestSwitch">
                        <label class="form-check-label" for="otherGuestSwitch">Saya memesan untuk orang lain</label>
                    </div>
                </div>
                <div class="summary-card">
                    <div class="summary-header">Ringkasan Pemesanan Anda</div>
                    <div id="summaryItems"></div>
                    <div id="summaryAddons"></div>
                    <div class="summary-item" id="dateSummary">
                        <div>Check-in: <strong id="summaryCheckIn">-</strong></div>
                        <div>Check-out: <strong id="summaryCheckOut">-</strong></div>
                    </div>
                    <div class="summary-item d-flex justify-content-between align-items-center">
                        <span>Durasi Menginap</span>
                        <strong id="summaryNights">1 malam</strong>
                    </div>
                    <div class="summary-item d-flex justify-content-between align-items-center">
                        <span>Pajak & Service (10%)</span>
                        <strong id="summaryTax">Rp0</strong>
                    </div>
                    <div class="summary-total">
                        <span>Total</span>
                        <span id="summaryTotal">Rp0</span>
                    </div>
                    <div id="summaryAlert" class="alert alert-warning mt-2 py-2 px-3 small d-none"></div>
                </div>
            </div>

            <div class="row mt-4 g-3">
                <div class="col-12">
                    <div class="pill-card">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <h6 class="mb-0">Tambahan Fasilitas</h6>
                            <small class="text-muted">Opsional, akan menambah total</small>
                        </div>
                        <div class="addon-list">
                            <div class="addon-item d-flex justify-content-between align-items-center py-2 border-bottom" data-addon-id="EXTRA_BED" data-addon-price="150000" data-addon-per-night="1">
                                <div>
                                    <strong>Extra Bed</strong>
                                    <div class="text-muted small">Per malam</div>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="text-muted small">Rp150.000</span>
                                    <input type="number" min="0" value="0" step="1" class="form-control form-control-sm" style="width:90px;" data-addon-qty>
                                </div>
                            </div>
                            <div class="addon-item d-flex justify-content-between align-items-center py-2 border-bottom" data-addon-id="BREAKFAST" data-addon-price="50000" data-addon-per-night="1">
                                <div>
                                    <strong>Sarapan</strong>
                                    <div class="text-muted small">Per malam / orang</div>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="text-muted small">Rp50.000</span>
                                    <input type="number" min="0" value="0" step="1" class="form-control form-control-sm" style="width:90px;" data-addon-qty>
                                </div>
                            </div>
                            <div class="addon-item d-flex justify-content-between align-items-center py-2" data-addon-id="LATE_CHECKOUT" data-addon-price="75000" data-addon-per-night="0">
                                <div>
                                    <strong>Late Checkout</strong>
                                    <div class="text-muted small">Sekali bayar</div>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="text-muted small">Rp75.000</span>
                                    <input type="number" min="0" value="0" step="1" class="form-control form-control-sm" style="width:90px;" data-addon-qty>
                                </div>
                            </div>
                        </div>
                        <small class="text-muted d-block mt-2" style="font-size: 12px;">Tambahan akan otomatis dihitung di ringkasan & tagihan.</small>
                    </div>
                </div>
            </div>

            <div class="row mt-3 g-4">
                <div class="col-12">
                    <div class="pill-card">
                        <input type="hidden" id="orderIdHidden" value="{{ session('checkout_order.id_pemesanan') ?? request('order_id') }}">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="mb-0">Pilih Metode Pembayaran</h6>
                            <small class="mini-label">BCA | BNI | GOPAY | QRIS</small>
                        </div>

                        <div class="method-groups">
                            <label class="method-group">
                                <div class="group-head">
                                    <div>
                                        <div class="mini-label">Virtual Account</div>
                                        <div class="group-title">Transfer bank otomatis</div>
                                        <div class="group-desc">BCA / BNI VA, verifikasi instan</div>
                                    </div>
                                    <input type="radio" name="pay_group" id="payVa" value="va" checked>
                                </div>
                                <div class="group-body">
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ asset('images/bca.jpeg') }}" alt="BCA" height="36" width="60" class="rounded border">
                                        <img src="{{ asset('images/bni.jpeg') }}" alt="BNI" height="36" width="60" class="rounded border">
                                    </div>
                                    <select id="vaSelect" class="form-select form-select-sm" style="max-width: 210px;">
                                        <option value="bca">BCA Virtual Account</option>
                                        <option value="bni">BNI Virtual Account</option>
                                    </select>
                                </div>
                            </label>
                            <label class="method-group">
                                <div class="group-head">
                                    <div>
                                        <div class="mini-label">E-Wallet</div>
                                        <div class="group-title">Bayar lewat GoPay</div>
                                        <div class="group-desc">Buka aplikasi GoPay untuk selesaikan pembayaran</div>
                                    </div>
                                    <input type="radio" name="pay_group" id="payEwallet" value="ewallet">
                                </div>
                                <div class="group-body">
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ asset('images/gopay.jpeg') }}" alt="GoPay" height="42" width="80" class="rounded border">
                                        <div class="text-muted" style="font-size: 12px;">Scan / deeplink</div>
                                    </div>
                                    <span class="method-chip">GoPay</span>
                                </div>
                            </label>
                            <label class="method-group">
                                <div class="group-head">
                                    <div>
                                        <div class="mini-label">QRIS</div>
                                        <div class="group-title">Semua dompet digital</div>
                                        <div class="group-desc">Scan QRIS dari saldo apa saja</div>
                                    </div>
                                    <input type="radio" name="pay_group" id="payQris" value="qris">
                                </div>
                                <div class="group-body">
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ asset('images/qris.jpeg') }}" alt="QRIS" height="42" width="80" class="rounded border">
                                        <div class="text-muted" style="font-size: 12px;">Dukungan OVO, DANA, ShopeePay, dll</div>
                                    </div>
                                    <span class="method-chip">QRIS</span>
                                </div>
                            </label>
                        </div>

                        <button id="payBtn" class="w-100 pay-btn mt-3" type="button">Bayar Sekarang</button>
                        <small class="text-muted d-block mt-2" style="font-size: 12px;">Jumlah pembayaran mengikuti ringkasan pesanan di kanan.</small>
                    </div>
                </div>
            </div>
            <div id="paymentResult" class="mt-3 small"></div>
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

        const summaryItems = document.getElementById('summaryItems');
        const summaryTotal = document.getElementById('summaryTotal');
        const summaryTax = document.getElementById('summaryTax');
        const summaryCheckIn = document.getElementById('summaryCheckIn');
        const summaryCheckOut = document.getElementById('summaryCheckOut');
        const summaryNights = document.getElementById('summaryNights');
        const summaryAddons = document.getElementById('summaryAddons');
        const summaryAlert = document.getElementById('summaryAlert');
        const payBtn = document.getElementById('payBtn');
        const resultBox = document.getElementById('paymentResult');
        const csrf = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        const orderId = document.getElementById('orderIdHidden')?.value?.trim();
        const statusBaseUrl = "{{ url('/api/payments/status') }}";
        let statusTimer = null;
        const LAST_PAYMENT_KEY = 'last_payment_state';

        const guestName = document.getElementById('guestName');
        const guestEmail = document.getElementById('guestEmail');
        const guestPhone = document.getElementById('guestPhone');
        const checkInInput = document.getElementById('checkInInput');
        const checkOutInput = document.getElementById('checkOutInput');
        const otherGuestSwitch = document.getElementById('otherGuestSwitch');
        const addonNodes = Array.from(document.querySelectorAll('[data-addon-id]'));

        const toInputDate = (dateObj) => dateObj.toISOString().split('T')[0];
        const addDays = (dateObj, days) => {
            const clone = new Date(dateObj);
            clone.setDate(clone.getDate() + days);
            return clone;
        };

        const getSavedBookingDates = () => {
            try {
                return JSON.parse(localStorage.getItem('booking_dates') || '{}');
            } catch (err) {
                return {};
            }
        };

        const saveBookingDates = (payload) => {
            localStorage.setItem('booking_dates', JSON.stringify(payload));
            window.dispatchEvent(new CustomEvent('booking:updated', { detail: payload }));
        };

        const getSelectedPaymentMethod = () => {
            const selectedGroup = document.querySelector('input[name="pay_group"]:checked')?.value;
            if (selectedGroup === 'va') {
                return vaSelect?.value || '';
            }
            if (selectedGroup === 'ewallet') {
                return 'gopay';
            }
            if (selectedGroup === 'qris') {
                return 'qris';
            }
            return '';
        };

        const computeNights = () => {
            if (!checkInInput?.value || !checkOutInput?.value) return 1;
            const start = new Date(checkInInput.value);
            const end = new Date(checkOutInput.value);
            const diffMs = end.getTime() - start.getTime();
            const nights = Math.round(diffMs / (1000 * 60 * 60 * 24));
            return nights > 0 ? nights : 1;
        };

        const getSelectedAddons = () => {
            return addonNodes.map((node) => {
                const id = node.getAttribute('data-addon-id');
                const price = Number(node.getAttribute('data-addon-price') || 0);
                const perNight = node.getAttribute('data-addon-per-night') === '1';
                const qtyInput = node.querySelector('[data-addon-qty]');
                const qtyRaw = Number(qtyInput?.value || 0);
                const qty = Math.max(0, Math.round(qtyRaw));
                const name = node.querySelector('strong')?.textContent?.trim() || id;
                return { id, name, price, qty, perNight };
            }).filter((item) => item.qty > 0 && item.price > 0);
        };

        const isBlockedStatus = (status) => {
            const normalized = (status || 'Tersedia').toLowerCase();
            return normalized !== 'tersedia' && normalized !== 'available';
        };

        const ensureValidDates = () => {
            if (!checkInInput || !checkOutInput) return;
            if (!checkInInput.value) {
                const today = new Date();
                checkInInput.value = toInputDate(today);
            }
            if (!checkOutInput.value || checkOutInput.value <= checkInInput.value) {
                checkOutInput.value = toInputDate(addDays(new Date(checkInInput.value), 1));
            }
        };

        const hydrateDatesFromStorage = () => {
            if (!checkInInput || !checkOutInput) return;
            const saved = getSavedBookingDates();
            const today = new Date();
            checkInInput.value = saved.check_in || toInputDate(today);
            checkOutInput.value = saved.check_out || toInputDate(addDays(today, 1));
            ensureValidDates();
        };

        const updateDates = (persist = false) => {
            ensureValidDates();
            if (summaryCheckIn) summaryCheckIn.textContent = checkInInput?.value || '-';
            if (summaryCheckOut) summaryCheckOut.textContent = checkOutInput?.value || '-';
            if (persist) {
                saveBookingDates({
                    check_in: checkInInput?.value || '',
                    check_out: checkOutInput?.value || '',
                });
            }
            renderSummary();
        };

        checkInInput?.addEventListener('change', () => updateDates(true));
        checkOutInput?.addEventListener('change', () => updateDates(true));

        const renderSummary = () => {
            const items = JSON.parse(localStorage.getItem('room_cart') || '[]');
            if (!summaryItems) return;

            summaryItems.innerHTML = '';
            if (summaryAddons) summaryAddons.innerHTML = '';
            if (summaryAlert) {
                summaryAlert.classList.add('d-none');
                summaryAlert.textContent = '';
            }

            if (!items.length) {
                summaryItems.innerHTML = `<div class="alert alert-warning py-2 px-3 small">Keranjang masih kosong. Tambah kamar dahulu.</div>`;
                summaryTotal.textContent = fmt(0);
                summaryTax.textContent = fmt(0);
                if (payBtn) payBtn.disabled = true;
                return;
            }

            const nights = computeNights();
            if (summaryNights) {
                summaryNights.textContent = `${nights} malam`;
            }

            let subtotal = 0;
            let hasBlocked = false;

            items.forEach((item) => {
                const qty = Number(item.quantity || 1);
                const price = Number(item.harga || 0);
                const isBlocked = isBlockedStatus(item.status);
                if (isBlocked) hasBlocked = true;

                const itemTotal = price * qty * nights;
                if (!isBlocked) {
                    subtotal += itemTotal;
                }

                const div = document.createElement('div');
                div.className = 'summary-item';
                div.innerHTML = `
                    <strong>${item.nama || 'Kamar'}</strong>
                    <div style="font-size:12px;color:#7a6b5f;">
                        ${qty} x ${fmt(price)} x ${nights} malam
                        ${isBlocked ? '<span class="text-danger fw-semibold ms-1">Tidak tersedia</span>' : ''}
                    </div>
                    <div style="text-align:right;font-weight:700;">${fmt(isBlocked ? 0 : itemTotal)}</div>
                `;
                summaryItems.appendChild(div);
            });

            const addons = getSelectedAddons();
            let addonSubtotal = 0;
            addons.forEach((addon) => {
                const addonTotal = addon.price * addon.qty * (addon.perNight ? nights : 1);
                addonSubtotal += addonTotal;

                if (summaryAddons) {
                    const div = document.createElement('div');
                    div.className = 'summary-item';
                    div.innerHTML = `
                        <strong>${addon.name}</strong>
                        <div style="font-size:12px;color:#7a6b5f;">${addon.qty} x ${fmt(addon.price)} ${addon.perNight ? 'per malam' : ''}</div>
                        <div style="text-align:right;font-weight:700;">${fmt(addonTotal)}</div>
                    `;
                    summaryAddons.appendChild(div);
                }
            });

            subtotal += addonSubtotal;

            const tax = Math.round(subtotal * 0.10);
            const total = subtotal + tax;
            summaryTax.textContent = fmt(tax);
            summaryTotal.textContent = fmt(total);

            if (payBtn) {
                payBtn.disabled = hasBlocked;
                payBtn.setAttribute('data-total', total.toString());
            }
            if (hasBlocked && summaryAlert) {
                summaryAlert.textContent = 'Ada kamar yang sedang maintenance / sudah direservasi. Hapus kamar tersebut sebelum checkout.';
                summaryAlert.classList.remove('d-none');
            }
        };

        window.addEventListener('DOMContentLoaded', () => {
            hydrateDatesFromStorage();
            renderSummary();
            updateDates();
            restorePaymentState();
        });
        window.addEventListener('cart:updated', renderSummary);
        addonNodes.forEach((node) => {
            const qtyInput = node.querySelector('[data-addon-qty]');
            qtyInput?.addEventListener('input', renderSummary);
            qtyInput?.addEventListener('change', renderSummary);
        });
        vaSelect?.addEventListener('change', () => {
            const vaRadio = document.getElementById('payVa');
            if (vaRadio) vaRadio.checked = true;
        });

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

        const getBookingData = () => ({
            name: guestName?.value?.trim() || '',
            email: guestEmail?.value?.trim() || '',
            phone: guestPhone?.value?.trim() || '',
            check_in: checkInInput?.value || '',
            check_out: checkOutInput?.value || '',
            other_guest: !!otherGuestSwitch?.checked,
        });

        const persistPaymentState = (payload) => {
            try {
                localStorage.setItem(LAST_PAYMENT_KEY, JSON.stringify(payload));
            } catch (e) {}
        };

        const clearPaymentState = () => {
            localStorage.removeItem(LAST_PAYMENT_KEY);
        };

        const renderInstruction = (state) => {
            let instruction = '';
            if (state.vaNumber) {
                instruction = `
                    <div class="d-flex align-items-center gap-2">
                        <div>
                            <strong>Virtual Account ${state.bank || ''}:</strong>
                            <div>${state.vaNumber}</div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-secondary" data-copy-va="${state.vaNumber}">Copy</button>
                    </div>
                `;
            } else if (state.qrUrl) {
                instruction = `
                    <div class="text-center">
                        <strong>Scan QRIS</strong>
                        <div class="mt-2">
                            <img src="${state.qrUrl}" alt="QRIS" class="border rounded" style="max-width:220px;">
                        </div>
                    </div>
                `;
            } else if (state.linkUrl) {
                instruction = `<a href="${state.linkUrl}" target="_blank" rel="noreferrer">Buka tautan pembayaran</a>`;
            }

            if (instruction) {
                setResult(`Transaksi dibuat.<br>${instruction}<div class="mt-1">Status awal: <strong>${state.statusText ?? 'pending'}</strong>. Menunggu konfirmasi pembayaran...</div>`, 'success');
                const copyBtn = resultBox?.querySelector('[data-copy-va]');
                if (copyBtn) {
                    copyBtn.addEventListener('click', () => copyVA(copyBtn.getAttribute('data-copy-va'), copyBtn));
                }
            }
        };

        const restorePaymentState = () => {
            try {
                const saved = JSON.parse(localStorage.getItem(LAST_PAYMENT_KEY) || '{}');
                if (!saved.orderId) return;
                renderInstruction(saved);
                startStatusPolling(saved.orderId);
            } catch (e) {}
        };

        const stopStatusPolling = () => {
            if (statusTimer) {
                clearInterval(statusTimer);
                statusTimer = null;
            }
        };

        const startStatusPolling = (midtransOrderId) => {
            if (!midtransOrderId || !statusBaseUrl) return;

            stopStatusPolling();
            let attempts = 0;
            const maxAttempts = 60; // ~3 menit

            statusTimer = setInterval(async () => {
                attempts += 1;
                try {
                    const res = await fetch(`${statusBaseUrl}/${encodeURIComponent(midtransOrderId)}`, {
                        method: 'GET',
                        credentials: 'same-origin',
                        headers: {
                            'Accept': 'application/json',
                        },
                    });
                    const data = await res.json();
                    if (!res.ok) {
                        throw new Error(data?.message || 'Gagal cek status pembayaran.');
                    }

                    const txStatus = (data.transaction_status || '').toLowerCase();
                    const normalizedStatus = (data.status_pembayaran || '').toLowerCase();
                    const paidStatuses = ['capture', 'settlement', 'success'];
                    const canceledStatuses = ['cancel', 'deny', 'expire', 'refund', 'chargeback', 'partial_refund'];

                    if (normalizedStatus === 'telah dibayar' || paidStatuses.includes(txStatus)) {
                        stopStatusPolling();
                        localStorage.removeItem('last_payment_state');
                        window.location.href = "{{ route('checkout.success') }}";
                        return;
                    }

                    if (normalizedStatus === 'dibatalkan' || canceledStatuses.includes(txStatus)) {
                        stopStatusPolling();
                        localStorage.removeItem('last_payment_state');
                        setResult('Pembayaran dibatalkan/ditolak oleh Midtrans.', 'danger');
                        return;
                    }

                    if (attempts >= maxAttempts) {
                        stopStatusPolling();
                        setResult('Belum ada konfirmasi pembayaran. Silakan cek riwayat atau coba lagi.', 'warning');
                    }
                } catch (err) {
                    if (attempts % 4 === 0) {
                        setResult('Gagal mengecek status pembayaran. Pastikan koneksi internet.', 'warning');
                    }
                }
            }, 3000);
        };

        payBtn?.addEventListener('click', async () => {
            const items = JSON.parse(localStorage.getItem('room_cart') || '[]');
            if (!items.length) {
                setResult('Keranjang masih kosong. Tambah kamar dulu.', 'warning');
                return;
            }

            const unavailable = items.filter((item) => isBlockedStatus(item.status));
            if (unavailable.length) {
                setResult('Ada kamar yang sedang maintenance / sudah direservasi. Hapus dulu sebelum checkout.', 'warning');
                return;
            }

            const booking = getBookingData();
            if (!booking.name || !booking.email || !booking.phone || !booking.check_in || !booking.check_out) {
                setResult('Lengkapi data tamu dan tanggal check-in/out.', 'warning');
                return;
            }

            const method = getSelectedPaymentMethod();
            if (!method) {
                setResult('Pilih metode pembayaran dulu.', 'warning');
                return;
            }

            const total = Number(payBtn.getAttribute('data-total') || 0);
            if (!total) {
                setResult('Total pembayaran tidak valid.', 'warning');
                return;
            }

            const nights = computeNights();
            const addons = getSelectedAddons();
            const payload = {
                payment_method: method,
                amount: total,
                items: items.map((item) => ({
                    id: item.id ?? item.kamar_id ?? item.room_id,
                    name: item.nama || 'Kamar',
                    price: Number(item.harga || 0),
                    quantity: Number(item.quantity || 1) * nights,
                })),
                booking,
            };
            const addonItems = addons.map((addon, idx) => ({
                id: `ADDON-${idx + 1}-${addon.id}`,
                name: addon.name,
                price: Number(addon.price || 0),
                quantity: addon.qty * (addon.perNight ? nights : 1),
            }));
            payload.items.push(...addonItems);
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
                let saveState = { orderId: data.order_id || data.app_order_id || data.orderId, method, statusText: data.transaction_status || 'pending' };
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
                    saveState.vaNumber = vaNum;
                    saveState.bank = bank;
                } else if (data.qr_string) {
                    const qrUrl = `https://api.qrserver.com/v1/create-qr-code/?size=220x220&data=${encodeURIComponent(data.qr_string)}`;
                    instruction = `
                        <div class="text-center">
                            <strong>Scan QRIS</strong>
                            <div class="mt-2">
                                <img src="${qrUrl}" alt="QRIS" class="border rounded" style="max-width:220px;">
                            </div>
                            <div class="small text-muted mt-1">Atau gunakan string:<br><code style="word-break: break-all;">${data.qr_string}</code></div>
                        </div>
                    `;
                    saveState.qrString = data.qr_string;
                    saveState.qrUrl = qrUrl;
                } else if (data.actions?.length) {
                    const goAction = data.actions.find((a) => a.name === 'deeplink-redirect') || data.actions.find((a) => a.url) || data.actions[0];
                    const label = method === 'gopay' ? 'Buka GoPay' : 'Buka tautan pembayaran';
                    const url = goAction.url;
                    instruction = `${label}: <a href="${url}" target="_blank" rel="noreferrer">${url}</a>`;
                    saveState.linkUrl = url;
                } else {
                    instruction = 'Transaksi dibuat. Detail:<br><pre class="mb-0 small bg-light p-2 border rounded">' + JSON.stringify(data, null, 2) + '</pre>';
                }

                const txStatus = data.transaction_status || '';
                renderInstruction({ ...saveState, statusText: txStatus || 'pending' });
                persistPaymentState(saveState);
                startStatusPolling(saveState.orderId);
            } catch (error) {
                setResult('Terjadi kesalahan jaringan.', 'danger');
            } finally {
                payBtn.disabled = false;
            }
        });
    })();
</script>
@endsection