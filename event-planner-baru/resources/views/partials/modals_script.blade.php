<div class="modal fade" id="bookingModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Form Pemesanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="bookingForm" onsubmit="submitBooking(event)">
                <div class="modal-body">
                    <input type="hidden" id="modalProductId" name="product_id">
                    <div class="mb-3">
                        <label class="form-label">Paket Dipilih</label>
                        <input type="text" id="modalProductName" class="form-control" readonly>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Pemesan</label>
                        <input type="text" name="customer_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email / WhatsApp</label>
                        <input type="text" name="contact_info" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tanggal Sewa</label>
                        <input type="date" name="booking_date" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Kirim Pesanan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>

    function renderPackages(data, containerId) {
    const container = document.getElementById(containerId);
    let html = '';
    
    if (data.length === 0) {
        container.innerHTML = '<div class="col-12 text-center text-muted py-5"><h4>Belum ada paket tersedia.</h4></div>';
        return;
    }

    data.forEach(item => {
        const imgDisplay = item.image_url ? item.image_url : 'https://via.placeholder.com/400x300?text=No+Image';
        const hargaRupiah = new Intl.NumberFormat('id-ID').format(item.price);

        html += `
        <div class="col-md-4">
            <div class="card card-package h-100">
                <img src="${imgDisplay}" class="card-img-top" alt="${item.name}" style="height: 200px; object-fit: cover;">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="card-title fw-bold mb-0">${item.name}</h5>
                        <span class="badge bg-success">Rp ${hargaRupiah}</span>
                    </div>
                    
                    <div class="mb-2">
                        <span class="badge bg-secondary">${item.category}</span>
                    </div>

                    <p class="card-text text-muted small">${item.description}</p>
                    
                    <div class="mt-auto pt-3">
                        <button onclick="openBooking(${item.id}, '${item.name}')" class="btn btn-primary w-100 rounded-pill">
                            <i class="fas fa-shopping-cart me-1"></i> Sewa Sekarang
                        </button>
                    </div>
                </div>
            </div>
        </div>
        `;
    });
    container.innerHTML = html;
}

    function openBooking(id, name) {
        document.getElementById('modalProductId').value = id;
        document.getElementById('modalProductName').value = name;
        new bootstrap.Modal(document.getElementById('bookingModal')).show();
    }

    function submitBooking(e) {
        e.preventDefault();
        const formData = new FormData(e.target);
        const data = Object.fromEntries(formData.entries());
        const btn = e.target.querySelector('button[type="submit"]');
        const originalText = btn.innerText;
        btn.innerText = 'Mengirim...';
        btn.disabled = true;

        fetch('/api/bookings', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}' 
            },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(response => {
            alert('Pesanan berhasil! Kami akan menghubungi Anda segera.');
            bootstrap.Modal.getInstance(document.getElementById('bookingModal')).hide();
            e.target.reset();
        })
        .catch(err => {
            console.error(err);
            alert('Gagal mengirim pesanan. Silakan coba lagi.');
        })
        .finally(() => {
            btn.innerText = originalText;
            btn.disabled = false;
        });
    }
</script>