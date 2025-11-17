@extends('layouts.template')
{{-- 🔹 Navbar --}}
    @include('layouts.navigation')

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
  transition: opacity 0.4s ease;
  overflow: hidden;
}
.superhero-section::before {
  content: '';
  position: absolute;
  inset: 0;
  background: var(--hero-next, none) no-repeat center center;
  background-size: cover;
  opacity: 0;
  transition: opacity 1s ease;
  z-index: 1;
}
.superhero-section::after {
  content: '';
  position: absolute;
  inset: 0;
  background: rgba(0,0,0,0.3);
  z-index: 2;
}
.superhero-section.is-fading {
  opacity: 0.55;
}
.superhero-section.is-transitioning::before {
  opacity: 1;
}
.superhero-content {
  position: relative;
  z-index: 3;
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

#discoverCarousel .discover-img {
  width: 100%;
  max-width: 320px;
  height: 240px;
  object-fit: cover;
  border-radius: 12px;
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

.map-section {
  background: #fff7ef;
  padding: 80px 0;
}
.map-section h2 {
  letter-spacing: 2px;
  color: #493628;
}
.map-embed {
  position: relative;
  padding-bottom: 56.25%;
  height: 0;
  overflow: hidden;
  border-radius: 16px;
  box-shadow: 0 10px 30px rgba(0,0,0,0.12);
}
.map-embed iframe {
  position: absolute;
  top: 0; left: 0;
  width: 100%;
  height: 100%;
  border: 0;
}

/* === SEKILAS SECTION === */
.sekilas-section {
  background: #f1e1d4;
  padding: 70px 0;
}
.sekilas-section h2 {
  letter-spacing: 2px;
  color: #493628;
}
.sekilas-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 18px;
  margin-top: 28px;
}
.sekilas-card {
  background: linear-gradient(180deg, #c59a7a 0%, #9a6d4c 100%);
  border-radius: 10px;
  padding: 16px;
  color: #fff;
  text-align: center;
  box-shadow: 0 10px 22px rgba(0,0,0,0.12);
}
.sekilas-card img {
  width: 100%;
  height: 160px;
  object-fit: cover;
  border-radius: 8px;
  margin-bottom: 12px;
  background: #d8c3b3;
}
.sekilas-card h5 {
  margin: 0;
  font-family: 'Aboreto', cursive;
  letter-spacing: 1px;
  font-size: 14px;
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
        @if(!empty($discoverRooms) && $discoverRooms->count())
          @foreach ($discoverRooms as $room)
            @php
              $image = $room->gambar ?: asset('images/discover%20(1).jpg');
            @endphp
            <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
              <img src="{{ $image }}" class="d-block mx-auto discover-img" alt="{{ $room->nama_kamar }}">
            </div>
          @endforeach
        @else
          <div class="carousel-item active">
            <img src="{{ asset('images/discover%20(2).jpg') }}" class="d-block mx-auto discover-img" alt="Discover 2">
          </div>
          <div class="carousel-item">
            <img src="{{ asset('images/discover%20(3).jpg') }}" class="d-block mx-auto discover-img" alt="Discover 3">
          </div>
        @endif
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

<!-- SEKILAS -->
<section class="sekilas-section">
  <div class="container text-center">
    <h2 class="fw-bold mb-1 font-aboreto garis-bawah">SEKILAS</h2>
    @if(!empty($sekilasRooms) && $sekilasRooms->count())
      <div class="sekilas-grid">
        @foreach ($sekilasRooms as $room)
          @php
            $image = $room->gambar ?: asset('images/discover%20(1).jpg');
          @endphp
          <div class="sekilas-card">
            <img src="{{ $image }}" alt="{{ $room->nama_kamar }}">
            <h5>{{ $room->nama_kamar }}</h5>
          </div>
        @endforeach
      </div>
    @else
      <p class="text-muted font-aboreto">Belum ada data kamar untuk ditampilkan.</p>
    @endif
  </div>
</section>

<!-- LOCATION -->
<section class="map-section">
  <div class="container">
    <h2 class="fw-bold mb-3 font-aboreto garis-bawah text-center">LOKASI</h2>
    <p class="text-center font-aboreto text-muted mb-4">Kunjungi kami di lokasi berikut:</p>
    <div class="map-embed">
      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d491.638864232258!2d106.9682652393092!3d-6.241167466734645!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e698dabeb95492f%3A0xe7073bdd8ba43a30!2sVerticaland%20T-Shirt!5e1!3m2!1sid!2sid!4v1763359179669!5m2!1sid!2sid"
              allowfullscreen=""
              loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
  </div>
</section>

@include('components.kamar-detail')
<script>
document.addEventListener('DOMContentLoaded', () => {
  const hero = document.querySelector('.superhero-section');
  if (!hero) return;

  const images = [
    "{{ asset('images/resort-bg.jpg') }}",
    "{{ asset('images/discover%20(1).jpg') }}",
    "{{ asset('images/discover%20(2).jpg') }}",
    "{{ asset('images/discover%20(3).jpg') }}"
  ];

  let current = 0;
  hero.style.backgroundImage = `url('${images[current]}')`;

  const swap = () => {
    const next = (current + 1) % images.length;
    hero.style.setProperty('--hero-next', `url('${images[next]}')`);
    hero.classList.add('is-transitioning');

    setTimeout(() => {
      hero.style.backgroundImage = `url('${images[next]}')`;
      hero.classList.remove('is-transitioning');
      current = next;
    }, 1000);
  };

  setInterval(swap, 5000);
});
</script>
@endsection
