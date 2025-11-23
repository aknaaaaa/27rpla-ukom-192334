<div class="modal fade" id="kamarDetailModal" tabindex="-1" aria-labelledby="kamarDetailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-0" style="background-color:#c7a98a;">
      <div class="modal-body p-4">
        <div class="d-flex justify-content-between align-items-start mb-3">
          <h3 id="modalNamaKamar" class="fw-bold">Kamar</h3>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="row">
          <div class="col-md-5">
            <img id="modalGambarKamar" src="{{ asset('images/default.jpg') }}" class="img-fluid rounded" alt="Kamar" onerror="this.onerror=null;this.src='{{ asset('images/default.jpg') }}';">
          </div>
          <div class="col-md-7">
            <p class="fw-bold mb-1" id="modalHargaKamar">Rp 0 / Malam</p>
            <p id="modalDeskripsiKamar" class="mb-2">Deskripsi kamar masih kosong.</p>
            <ul class="list-unstyled mt-3">
              <li id="modalUkuranKamar">Ukuran: -</li>
              <li id="modalStatusKamar">Status: -</li>
            </ul>
            <a id="modalPilihBtn" class="btn btn-dark mt-3" href="#">Buka halaman</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('show.bs.modal', function (event) {
    if (event.target.id !== 'kamarDetailModal') return;

    const button = event.relatedTarget;
    if (!button) return;

    const nama = button.getAttribute('data-nama') || 'Kamar';
    const deskripsi = button.getAttribute('data-deskripsi') || 'Deskripsi kamar masih kosong.';
    const gambar = button.getAttribute('data-gambar') || "{{ asset('images/default.jpg') }}";
    const harga = button.getAttribute('data-harga') || 'Rp 0 / Malam';
    const ukuran = button.getAttribute('data-ukuran') || '-';
    const status = button.getAttribute('data-status') || '-';
    const url = button.getAttribute('data-url') || '#';

    document.getElementById('modalNamaKamar').textContent = nama;
    document.getElementById('modalDeskripsiKamar').textContent = deskripsi;
    document.getElementById('modalGambarKamar').src = gambar;
    document.getElementById('modalHargaKamar').textContent = harga;
    document.getElementById('modalUkuranKamar').textContent = `Ukuran: ${ukuran}`;
    document.getElementById('modalStatusKamar').textContent = `Status: ${status}`;
    document.getElementById('modalPilihBtn').setAttribute('href', url);
});
</script>
