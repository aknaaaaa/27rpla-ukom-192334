@extends('layouts.template')
{{-- 🔹 Navbar --}}
    @include('components.navigation')

@section('title', 'Halaman Utama')

@section('content')
<style>
/* === HERO SECTION === */
.superhero-section {
  position: relative;
  height: 70vh;
  background: url("{{ asset('images/resort-bg.jpg') }}") no-repeat center center;
  background-size: cover;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  color: white;
  font-family: aboreto;
}
.superhero-section::after {
  content: '';
  position: absolute;
  inset: 0;
  background: rgba(0,0,0,0.3);
}
.superhero-content {
  position: relative;
  z-index: 2;
}
.superhero-content h1 {
  font-size: 48px;
  letter-spacing: 2px;
  font-family: 'Aboreto', cursive;
}

/* === ABOUT SECTION === */
.about-section {
  background-color: #fff;
  padding-top: 100px;
  padding-bottom: 100px;
  background-image: url("{{ asset('images/background.jpg') }}");
  background-size: cover;
}
.warna-h2 {
  letter-spacing: 2px;
  color: #493628;
}
.warna-emas {
  color: #AB886D !important;
}
.garis-bawah {
  font-weight: 600;
  color: #4a2c2a;
  letter-spacing: 2px;
  position: relative;
}
.garis-bawah::after {
  content: '';
  display: block;
  width: 60px;
  height: 2px;
  background-color: #b22222;
  margin: 8px auto 0;
}

/* === DISCOVER CAROUSEL (fix width & arrows near image) === */
#discoverCarousel {
  max-width: 340px;     
  margin: 0 auto;      
  position: relative;
}

#discoverCarousel .carousel-inner {
  border-radius: 12px;
  overflow: hidden;
}

#discoverCarousel .carousel-control-prev,
#discoverCarousel .carousel-control-next {
  width: auto;
  height: 48px;
  top: 50%;
  transform: translateY(-50%);
  opacity: 0.9;
}

#discoverCarousel .carousel-control-prev {
  left: -28px;  
}

#discoverCarousel .carousel-control-next {
  right: -28px; 
}

#discoverCarousel .carousel-control-prev-icon,
#discoverCarousel .carousel-control-next-icon {
  width: 24px;
  height: 24px;
  filter: invert(100%);
}

/* transisi & efek gambar (opsional, bisa pertahankan punyamu) */
#discoverCarousel .carousel-item {
  transition: transform 0.5s ;
}
#discoverCarousel .carousel-item.active img {
  transform: scale(1.02);
  transition: transform 0.5s ;
}

</style>

<!-- HERO -->
<div class="superhero-section">
  <div class="superhero-content">
    <h1>HOTEL D'KASUARI</h1>
    <p>Warisan Lama, Kemewahan Modern.</p>
  </div>
</div>

<!-- ABOUT -->
<section class="hero-section about-section text-center py-5">
  <div class="container">
    <p class="warna-p warna-emas text-uppercase mb-1 font-aboreto">WELCOME TO</p>
    <h2 class="warna-h2 fw-bold mb-3 font-aboreto garis-bawah">HOTEL D'KASUARI</h2>
    <p class="warna-p warna-emas text-secondary mb-4 font-aboreto">
      Menghadirkan harmoni antara warisan arsitektur tradisional dan kemewahan modern. Setiap sudut dirancang untuk memberikan kenyamanan, keanggunan, dan pengalaman menginap yang tak terlupakan. Temukan ketenangan masa lalu yang dipadukan dengan sentuhan kemewahan masa kini.
    </p>
  </div>

  <!-- DISCOVER -->
  <div class="container mt-5">
    <h2 class="warna-h2 fw-bold mb-3 font-aboreto garis-bawah">DISCOVER</h2>

    <div id="discoverCarousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner text-center">
        <div class="carousel-item active">
          <img src="{{ asset('images/discover%20(1).jpg') }}" class="d-block mx-auto img-fluid" alt="Discover 1"
               style="max-width:300px; height:auto; border-radius:12px;">
        </div>
        <div class="carousel-item">
          <img src="{{ asset('images/discover%20(2).jpg') }}" class="d-block mx-auto img-fluid" alt="Discover 2"
               style="max-width:300px; height:auto; border-radius:12px;">
        </div>
        <div class="carousel-item">
          <img src="{{ asset('images/discover%20(3).jpg') }}" class="d-block mx-auto img-fluid" alt="Discover 3"
               style="max-width:300px; height:auto; border-radius:12px;">
        </div>
      </div>

      <button class="carousel-control-prev" type="button" data-bs-target="#discoverCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#discoverCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>
  </div>
</section>

@include('components.kamar-detail')
@endsection
