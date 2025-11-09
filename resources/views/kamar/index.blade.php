@extends('layouts.app')

@section('title', 'Daftar Kamar - D\'Kasuari')

@section('content')
<div class="container my-4">
    {{-- Form Check-in / Check-out --}}
    <div class="d-flex justify-content-center mb-5">
        <form class="d-flex gap-3 align-items-center">
            <div>
                <label>Check In</label>
                <input type="date" class="form-control">
            </div>
            <div>
                <label>Check Out</label>
                <input type="date" class="form-control">
            </div>
            <button class="btn btn-dark mt-3">Cari</button>
        </form>
    </div>

    {{-- Daftar kamar --}}
    <div class="row">
        @foreach ($kamars as $kamar)
            <div class="col-md-6 mb-4">
                @include('components.kamar-card', ['kamar' => $kamar])
            </div>
        @endforeach
    </div>
</div>

{{-- Modal Detail --}}
@include('components.kamar-detail')
@endsection
