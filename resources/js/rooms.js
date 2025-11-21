        function openKategoriModal() {
    document.getElementById("modalKategori").style.display = "block";
}
function closeKategoriModal() {
    document.getElementById("modalKategori").style.display = "none";
}
        const roomModal = document.getElementById('roomModal');
        const roomForm = document.getElementById('roomModalForm');
        const methodInput = document.getElementById('roomModalMethod');
        const titleEl = document.getElementById('roomModalTitle');
        const submitBtn = document.getElementById('roomModalSubmit');
        const nameInput = document.getElementById('roomNameInput');
        const hargaInput = document.getElementById('roomHargaInput');
        const ukuranInput = document.getElementById('roomUkuranInput');
        const statusSelect = document.getElementById('roomStatusSelect');
        const deskripsiInput = document.getElementById('roomDeskripsiInput');
        const imageInput = document.getElementById('roomImageInput');

        function openModal(){
            resetForm();
            titleEl.textContent = 'Buat kamar baru';
            submitBtn.textContent = 'Simpan kamar';
            methodInput.value = '';
            roomForm.action = "{{ route('admin.rooms.store') }}";
            imageInput.required = true;
            roomModal.classList.add('is-open');
        }
        function closeModal(){ roomModal.classList.remove('is-open'); }

        function resetForm() {
            nameInput.value = "{{ old('nama_kamar') }}";
            hargaInput.value = "{{ old('harga_permalam') }}";
            ukuranInput.value = "{{ old('ukuran_kamar') }}";
            statusSelect.value = "{{ old('status_kamar') ?? 'Tersedia' }}";
            deskripsiInput.value = `{{ old('deskripsi') }}`;
            imageInput.value = '';
        }

        function openEditModal(button){
            const action = button.getAttribute('data-action');
            const nama = button.getAttribute('data-nama') || '';
            const harga = button.getAttribute('data-harga') || '';
            const ukuran = button.getAttribute('data-ukuran') || '';
            const status = button.getAttribute('data-status') || 'Tersedia';
            const deskripsi = button.getAttribute('data-deskripsi') || '';
            const img = button.getAttribute('data-img') || '';

            roomForm.action = action;
            methodInput.value = 'PUT';
            titleEl.textContent = 'Edit kamar';
            submitBtn.textContent = 'Update kamar';

            nameInput.value = nama;
            hargaInput.value = harga;
            ukuranInput.value = ukuran;
            statusSelect.value = status;
            deskripsiInput.value = deskripsi;

            imageInput.required = false;

            roomModal.classList.add('is-open');
        }

        @if($errors->any())
            // auto open modal when validation fails so user sees errors and data
            openModal();
        @endif

        // Auto-hide flash success
        document.addEventListener('DOMContentLoaded', function () {
            const flashStack = document.getElementById('flashStack');
            if (!flashStack) return;
            setTimeout(() => flashStack.remove(), 4200);
        });

        // Loader saat pindah halaman dari admin rooms
        document.addEventListener('DOMContentLoaded', function () {
            const loader = document.getElementById('pageLoader');
            if (!loader) return;

            const showLoader = () => loader.classList.add('is-visible');

            document.querySelectorAll('a[href]').forEach((link) => {
                const href = link.getAttribute('href');
                if (!href || href === '#' || href.startsWith('javascript:')) return;

                link.addEventListener('click', function () {
                    if (this.target === '_blank' || this.href === window.location.href) return;
                    showLoader();
                });
            });

            window.addEventListener('beforeunload', showLoader);
        });

        // Handle delete confirmation
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('confirmDeleteModal');
            const confirmBtn = document.getElementById('confirmDeleteBtn');
            const deleteForm = document.getElementById('deleteRoomForm');
            let selectedId = null;

            document.querySelectorAll('.btn-delete').forEach((btn) => {
                btn.addEventListener('click', function () {
                    selectedId = this.dataset.roomId;
                    modal.classList.add('is-open');
                });
            });

            modal?.addEventListener('click', function (e) {
                if (e.target === modal) {
                    modal.classList.remove('is-open');
                }
            });

            confirmBtn?.addEventListener('click', function () {
                if (!selectedId || !deleteForm) return;
                const template = "{{ route('admin.rooms.destroy', ['id' => ':id']) }}";
                deleteForm.action = template.replace(':id', selectedId);
                deleteForm.submit();
            });
        });
        // Sidebar toggle on mobile
        document.addEventListener('DOMContentLoaded', function () {
            const toggle = document.getElementById('sidebarToggle');
            const sidebar = document.querySelector('.sidebar');
            toggle?.addEventListener('click', function (e) {
                e.stopPropagation();
                sidebar?.classList.toggle('is-open');
            });
            document.addEventListener('click', function (e) {
                if (window.innerWidth > 960) return;
                if (!sidebar?.classList.contains('is-open')) return;
                if (!sidebar.contains(e.target) && e.target !== toggle) {
                    sidebar.classList.remove('is-open');
                }
            });
        });