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

    .room-card {
        height: 100%;
    }
    .room-card .card-body {
        display: flex;
        flex-direction: column;
        justify-content: center;
        height: 100%;
    }
    .room-card-img {
        width: 100%;
        height: 100%;
        min-height: 260px;
        object-fit: cover;
    }
</style>

<div class="container" style="margin-top: 75px;">
    {{-- Form Check-in / Check-out --}}
    <a class="back" href="{{ route('layouts.index') }}">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path d="M15 18l-6-6 6-6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <span>Back</span>
    </a>
    <div class="d-flex justify-content-center mb-5">
        <form id="dateSearchForm" class="d-flex gap-3 align-items-center">
            <div>
                <label>Check In</label>
                <input type="date" id="checkInField" class="form-control">
            </div>
            <div>
                <label>Check Out</label>
                <input type="date" id="checkOutField" class="form-control">
            </div>
            <button class="btn btn-dark mt-3" type="submit">Simpan</button>
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
    if (backBtn && loader) {
        backBtn.addEventListener('click', (e) => {
            e.preventDefault();
            loader.classList.remove('is-hidden');
            location.href = backBtn.getAttribute('href');
        });
    }

    // sinkronisasi tanggal dari halaman kamar ke checkout melalui localStorage
    const checkInField = document.getElementById('checkInField');
    const checkOutField = document.getElementById('checkOutField');
    const dateForm = document.getElementById('dateSearchForm');
    const today = new Date();

    const toInputDate = (dateObj) => dateObj.toISOString().split('T')[0];
    const addDays = (dateObj, days) => {
        const clone = new Date(dateObj);
        clone.setDate(clone.getDate() + days);
        return clone;
    };

    const persistDates = (showToast = false) => {
        const payload = {
            check_in: checkInField?.value || '',
            check_out: checkOutField?.value || '',
        };
        localStorage.setItem('booking_dates', JSON.stringify(payload));
        window.dispatchEvent(new CustomEvent('booking:updated', { detail: payload }));
        if (showToast) {
            window.showAppToast?.('Tanggal menginap disimpan. Silakan lanjut ke checkout.', 'success');
        }
    };

    const ensureCheckoutAfterCheckin = () => {
        if (!checkInField || !checkOutField) return;
        if (!checkInField.value) return;
        if (!checkOutField.value || checkOutField.value <= checkInField.value) {
            checkOutField.value = toInputDate(addDays(new Date(checkInField.value), 1));
        }
    };

    const hydrateDates = () => {
        if (!checkInField || !checkOutField) return;
        const saved = JSON.parse(localStorage.getItem('booking_dates') || '{}');
        const defaultCheckIn = toInputDate(today);
        const defaultCheckOut = toInputDate(addDays(today, 1));

        checkInField.value = saved.check_in || defaultCheckIn;
        checkOutField.value = saved.check_out || defaultCheckOut;
        ensureCheckoutAfterCheckin();
    };

    hydrateDates();

    checkInField?.addEventListener('change', () => {
        ensureCheckoutAfterCheckin();
        persistDates();
    });
    checkOutField?.addEventListener('change', () => {
        ensureCheckoutAfterCheckin();
        persistDates();
    });

    dateForm?.addEventListener('submit', (e) => {
        e.preventDefault();
        ensureCheckoutAfterCheckin();
        persistDates(true);
    });
});
</script>
@endsection
