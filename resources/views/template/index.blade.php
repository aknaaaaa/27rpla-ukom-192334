@extends('template.template')

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

/* === NAVBAR === */
.navbar-custom {
  position: fixed;
  top: 0; left: 0;
  width: 100%;
  background-color: rgba(255, 255, 255, 0.5) !important;
  backdrop-filter: blur(5px);
  box-shadow: none;
  z-index: 1000;
  transition: all 0.4s ease;
}
.navbar-custom.scrolled {
  background-color: white !important;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}
.navbar .nav-link {
  color: #000 !important;
  transition: color 0.3s ease;
}
.btn-dark {
  background-color: rgb(20, 20, 20);
  color: white;
}
.btn-dark:hover {
  background-color: rgba(255,255,255,0.4);
  color: rgb(0,0,0);
  transition: all 0.5s ease-in-out;
}

/* === DISCOVER MULTI-CAROUSEL === */
#discoverCarousel {
  margin-top: 50px;
}
.carousel-item {
  display: flex;
  gap: 15px;
  justify-content: center;
}
.carousel-item img {
  width: 32%;
  height: 250px;
  object-fit: cover;
  border-radius: 12px;
}
.carousel-control-prev-icon,
.carousel-control-next-icon {
  filter: invert(100%);
}
.carousel-indicators [data-bs-target] {
  background-color: #AB886D;
}
</style>

<!-- HERO -->
<div class="superhero-section">
  <div class="superhero-content">
    <h1>HOTEL D'KASUARI</h1>
    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Odit, officia!</p>
  </div>
</div>

<!-- ABOUT -->
<section class="hero-section about-section text-center py-5">
  <div class="container">
    <p class="warna-p warna-emas text-uppercase mb-1 font-aboreto">WELCOME TO</p>
    <h2 class="warna-h2 fw-bold mb-3 font-aboreto garis-bawah">HOTEL D'KASUARI</h2>
    <p class="warna-p warna-emas text-secondary mb-4 font-aboreto">
      Lorem ipsum dolor sit amet consectetur adipisicing elit. Fugit sunt, doloribus quo voluptatem veniam ea,
      consequatur tempore beatae, doloremque voluptate ipsam aliquam.
    </p>
  </div>

  <br><br>

  <!-- DISCOVER SECTION -->
  <div class="container">
    <h2 class="warna-h2 fw-bold mb-3 font-aboreto garis-bawah">DISCOVER</h2>

    <div id="discoverCarousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">

        <!-- SLIDE 1 -->
        <div class="carousel-item active">
          <img src="{{ asset('images/discover (1).jpg') }}" alt="Discover 1">
          <img src="{{ asset('images/discover (2).jpg') }}" alt="Discover 2">
          <img src="{{ asset('images/discover (3).jpg') }}" alt="Discover 3">
        </div>

        <!-- SLIDE 2 -->
        <div class="carousel-item">
          <img src="{{ asset('images/discover (4).jpg') }}" alt="Discover 4">
          <img src="{{ asset('images/discover (2).jpg') }}" alt="Discover 2">
          <img src="{{ asset('images/discover (3).jpg') }}" alt="Discover 3">
        </div>

      </div>

      <!-- Controls -->
      <button class="carousel-control-prev" type="button" data-bs-target="#discoverCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#discoverCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
      </button>

      <!-- Indicators -->
      <div class="carousel-indicators mt-3">
        <button type="button" data-bs-target="#discoverCarousel" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#discoverCarousel" data-bs-slide-to="1"></button>
      </div>
    </div>
  </div>
</section>

<script>
window.addEventListener('scroll', function() {
  const navbar = document.querySelector('.navbar-custom');
  navbar.classList.toggle('scrolled', window.scrollY > 50);
});
</script>
@endsection
