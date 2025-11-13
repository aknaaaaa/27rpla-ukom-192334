<div class="modal fade" id="kamarDetailModal" tabindex="-1" aria-labelledby="kamarDetailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-0" style="background-color:#c7a98a;">
      <div class="modal-body p-4">
        <div class="d-flex justify-content-between align-items-start mb-3">
          <h3 id="modalNamaKamar" class="fw-bold">KAMAR</h3>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="row">
          <div class="col-md-5">
            <img id="modalGambarKamar" src="{{ asset('images/default.jpg') }}" class="img-fluid rounded">
          </div>
          <div class="col-md-7">
            <p class="fw-bold mb-1" id="modalHargaKamar">Rp 0 / Malam</p>
            <p id="modalDeskripsiKamar">Deskripsi Kamar...</p>
            <ul class="list-unstyled mt-3">
              <li>🅿️ Area parkir tersedia</li>
              <li>💨 Kipas angin / ventilasi alami</li>
              <li>🛏️ Single bed nyaman</li>
              <li>🔌 Colokan listrik pribadi</li>
            </ul>
            <button class="btn btn-dark mt-3">Pilih</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const nama = button.getAttribute('data-nama');
    const deskripsi = button.getAttribute('data-deskripsi');
    document.getElementById('modalNamaKamar').textContent = nama;
    document.getElementById('modalDeskripsiKamar').textContent = deskripsi;
});
<<<<<<< HEAD
</script>
=======
</script>
>>>>>>> c744583985de79c63527125b81123ee127e9ef34
