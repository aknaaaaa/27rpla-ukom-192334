@extends('layouts.app')

@section('title', 'Daftar Kamar')

@section('content')
<h3 class="mb-4 fw-bold">Daftar Kamar</h3>

@foreach ($kamars as $kamar)
    @include('kamar.components.card', ['kamar' => $kamar])
@endforeach
@endsection
