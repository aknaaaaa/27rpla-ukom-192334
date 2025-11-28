@extends('layouts.app')

@section('title', 'Daftar Kamar - D\'Kasuari')

@section('content')

<style>
    .back{
        position: fixed;
        top: 100px; left: 18px;
        z-index: 5;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 12px;
        font-size: 14px;
        font-weight: 600;
        color: #2b2b2b;
        background: #fff;
        border-radius: 8px;
        text-decoration: none;
        box-shadow: 0 4px 16px rgba(0,0,0,.16);
        border: 1px solid rgba(0,0,0,.06);
    }
    .back svg{ width:16px; height:16px }
    .hero {
        background: #f4f4f5;
        color: #111827;
        border-radius: 18px;
        padding: 18px 18px;
        margin-bottom: 24px;
        box-shadow: 0 12px 28px rgba(0,0,0,0.08);
        border: 1px solid #e5e7eb;
    }
    .hero h3 { margin: 0 0 6px 0; letter-spacing: 0.6px; font-weight: 700; }
    .hero p { margin: 0 0 10px 0; color: #4b5563; }
    .date-form {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 12px;
        align-items: end;
    }
    .date-form label { font-size: 12px; letter-spacing: 0.3px; color: #4b5563; }
    .date-form input {
        border-radius: 10px;
        border: 1px solid #d1d5db;
        background: #f2f2f2;
        color: #111827;
        padding: 10px 12px;
    }
    .date-form input:focus { outline: 2px solid #9ca3af; }
    .date-form button {
        height: 42px;
        border: none;
        border-radius: 10px;
        background: #d1d5db;
        font-weight: 700;
        letter-spacing: 0.4px;
        color: #111827;
        border: 1px solid #c7c9d1;
    }
    .rooms-grid { display: grid; gap: 16px; }
    .cart-panel-sticky { position: sticky; top: 90px; }
</style>

<div class="container" style="margin-top: 75px;">
    {{-- Form Check-in / Check-out --}}
    <a class="back" href="{{ route('layouts.index') }}">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M15 18l-6-6 6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <span>Back</span>
    </a>
    <div class="hero">
        <h3>Booking kamar dengan tanggal pasti</h3>
        <p class="mb-3" style="color:#4b5563;">Pilih tanggal check-in & check-out untuk menghitung total malam secara otomatis.</p>
        <form class="date-form" id="dateForm">
            <div>
                <label>Check In</label>
                <input type="date" class="form-control" id="checkInInput">
            </div>
            <div>
                <label>Check Out</label>
                <input type="date" class="form-control" id="checkOutInput">
            </div>
            <button type="button" class="btn btn-dark" id="saveDatesBtn">Simpan tanggal</button>
        </form>
    </div>

    <div class="row">
        <div class="col-lg-8">
            {{-- Daftar kamar --}}
            <div class="row">
                @forelse ($kamars as $kamar)
                    <div class="col-md-12 mb-4 d-flex">
                        @include('components.kamar-card', ['kamar' => $kamar])
                    </div>
                @empty
                    <div class="col-12 text-center text-muted py-5">
                        Belum ada kamar yang tersedia.
                    </div>
                @endforelse
            </div>
        </div>
        <div class="col-lg-4">
            @include('components.cart-panel')
        </div>
    </div>
</div>

{{-- Modal Detail --}}
@include('components.kamar-detail')
@include('components.auth-alert')
@include('components.cart-script')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const backBtn = document.querySelector('.back');
    const loader = document.getElementById('pageLoader');
    const checkInInput = document.getElementById('checkInInput');
    const checkOutInput = document.getElementById('checkOutInput');
    const saveDatesBtn = document.getElementById('saveDatesBtn');

    const toInputDate = (dateObj) => dateObj.toISOString().split('T')[0];
    const addDays = (dateObj, days) => {
        const clone = new Date(dateObj);
        clone.setDate(clone.getDate() + days);
        return clone;
    };

    const getSavedBookingDates = () => {
        try { return JSON.parse(localStorage.getItem('booking_dates') || '{}'); }
        catch (_) { return {}; }
    };

    const ensureValidDates = () => {
        if (!checkInInput || !checkOutInput) return;
        if (!checkInInput.value) {
            checkInInput.value = toInputDate(new Date());
        }
        if (!checkOutInput.value || checkOutInput.value <= checkInInput.value) {
            checkOutInput.value = toInputDate(addDays(new Date(checkInInput.value), 1));
        }
    };

    const hydrateDates = () => {
        const saved = getSavedBookingDates();
        const today = new Date();
        if (checkInInput) {
            checkInInput.min = toInputDate(today);
            checkInInput.value = saved.check_in || toInputDate(today);
        }
        if (checkOutInput) {
            checkOutInput.min = toInputDate(addDays(today, 1));
            checkOutInput.value = saved.check_out || toInputDate(addDays(today, 1));
        }
        ensureValidDates();
    };

    const saveDates = () => {
        if (!checkInInput || !checkOutInput) return;
        ensureValidDates();
        const payload = {
            check_in: checkInInput.value,
            check_out: checkOutInput.value,
        };
        localStorage.setItem('booking_dates', JSON.stringify(payload));
        window.dispatchEvent(new CustomEvent('booking:updated', { detail: payload }));
        window.dispatchEvent(new CustomEvent('cart:updated'));
        window.showAppToast?.('Tanggal menginap disimpan.', 'success');
    };

    checkInInput?.addEventListener('change', ensureValidDates);
    checkOutInput?.addEventListener('change', ensureValidDates);
    saveDatesBtn?.addEventListener('click', saveDates);

    hydrateDates();

    if (backBtn && loader) {
        backBtn.addEventListener('click', (e) => {
            e.preventDefault();
            loader.classList.remove('is-hidden');
            location.href = backBtn.getAttribute('href');
        });
    }
});
</script>
@endsection
