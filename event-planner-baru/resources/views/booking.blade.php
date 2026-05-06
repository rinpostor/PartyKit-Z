@extends('layout')

@section('content')

<div class="bg-gray-50 py-12 w-full min-h-screen">
    <div class="container mx-auto px-4">
        
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-gray-800">Formulir Pemesanan</h1>
            <p class="text-gray-500 mt-2">Lengkapi data di bawah ini untuk melanjutkan sewa.</p>
        </div>

        <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-3 gap-8 items-start">
            
            <div class="md:col-span-1">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 sticky top-28">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 border-b pb-3">Detail Pesanan</h3>
                    
                    <div id="loading-skeleton" class="animate-pulse space-y-4">
                        <div class="h-32 bg-gray-200 rounded-lg w-full"></div>
                        <div class="h-4 bg-gray-200 rounded w-3/4"></div>
                        <div class="h-4 bg-gray-200 rounded w-1/2"></div>
                    </div>

                    <div id="package-detail" class="hidden">
                        <div class="relative w-full h-40 mb-4 rounded-lg overflow-hidden">
                            <img id="pkg-img" src="" alt="Paket" class="w-full h-full object-cover">
                        </div>
                        <h4 id="pkg-name" class="text-xl font-bold text-gray-900 mb-1">Nama Paket</h4>
                        <span id="pkg-category" class="inline-block bg-blue-50 text-blue-600 text-xs font-bold px-2 py-1 rounded mb-3">Kategori</span>
                        
                        <div class="flex justify-between items-center border-t pt-3 mt-2">
                            <span class="text-gray-500 text-sm">Harga Sewa:</span>
                            <span id="pkg-price" class="text-xl font-bold text-blue-600">Rp 0</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="md:col-span-2">
                <div class="bg-white p-8 rounded-2xl shadow-lg border border-gray-100">
                    <form id="bookingForm" onsubmit="submitBooking(event)">
                        <input type="hidden" name="package_id" id="package_id_input">

                        <div class="space-y-5">
                            {{-- Nama --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                                <input type="text" name="nama_pemesan" required 
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition outline-none"
                                    placeholder="Masukkan nama lengkap">
                            </div>

                            {{-- Kontak --}}
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                                    <input type="email" name="email_pemesan" required 
                                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition outline-none"
                                        placeholder="email@anda.com">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">WhatsApp</label>
                                    <input type="number" name="telepon_pemesan" required 
                                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition outline-none"
                                        placeholder="0812...">
                                </div>
                            </div>

                            {{-- Tanggal --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Acara</label>
                                <input type="date" name="tanggal_event" required 
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition outline-none cursor-pointer">
                            </div>
                        </div>

                        {{-- Tombol --}}
                        <button type="submit" id="btn-submit" 
                            class="w-full mt-8 bg-blue-600 text-white font-bold py-4 rounded-xl hover:bg-blue-700 transition transform active:scale-95 shadow-lg shadow-blue-600/20">
                            Konfirmasi Pesanan
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<div id="payment-modal" class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
    <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full overflow-hidden transform transition-all scale-100">
        <div class="bg-blue-600 p-6 text-center">
            <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-3">
                <span class="text-3xl">💳</span>
            </div>
            <h3 class="text-white text-xl font-bold">Instruksi Pembayaran</h3>
            <p class="text-blue-100 text-sm">Selesaikan pembayaran untuk memproses pesanan.</p>
        </div>

        <div class="p-8 space-y-6">
            
            <div class="text-center">
                <p class="text-gray-500 text-sm mb-1">Silakan transfer ke Bank BCA:</p>
                <div class="flex items-center justify-center gap-2 bg-gray-50 p-3 rounded-xl border border-gray-200">
                    <span class="font-mono text-xl font-bold text-gray-800">123 456 7890</span>
                    <button onclick="copyText('1234567890')" class="text-blue-600 text-xs hover:underline">Salin</button>
                </div>
                <p class="text-xs text-gray-400 mt-1">a.n PartyKitz Official</p>
            </div>

            <div class="border-t border-dashed border-gray-300 pt-4">
                <div class="flex justify-between text-sm text-gray-600 mb-2">
                    <span>Harga Paket</span>
                    <span id="bill-price">Rp 0</span>
                </div>
                <div class="flex justify-between text-sm text-gray-600 mb-2">
                    <span>Kode Unik <span class="text-xs text-orange-500">(Penting!)</span></span>
                    <span id="bill-code" class="font-bold text-orange-500">0</span>
                </div>
                <div class="flex justify-between items-center bg-blue-50 p-3 rounded-lg mt-2">
                    <span class="font-bold text-blue-800">Total Transfer</span>
                    <span id="bill-total" class="font-bold text-2xl text-blue-700">Rp 0</span>
                </div>
            </div>

            <button onclick="finishOrder()" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 rounded-xl transition shadow-lg shadow-green-600/30">
                Saya Sudah Transfer
            </button>
            <p class="text-center text-xs text-gray-400 mt-2">Screenshot bukti transfer Anda untuk verifikasi.</p>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const urlParams = new URLSearchParams(window.location.search);
        const packageId = urlParams.get('package_id');

        if(packageId) {
            loadPackageDetail(packageId);
        } else {
            alert("Paket tidak ditemukan!");
            window.location.href = '/packages';
        }
    });

    function loadPackageDetail(id) {
        fetch('/api/packages') 
            .then(res => res.json())
            .then(result => {
                const pkg = result.data.find(p => p.id == id);
                if(pkg) {
                    document.getElementById('package_id_input').value = pkg.id;
                    document.getElementById('pkg-name').innerText = pkg.name;
                    document.getElementById('pkg-category').innerText = pkg.category;
                    document.getElementById('pkg-img').src = pkg.image_url;
                    
                    let price = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(pkg.price);
                    document.getElementById('pkg-price').innerText = price;

                    document.getElementById('loading-skeleton').classList.add('hidden');
                    document.getElementById('package-detail').classList.remove('hidden');
                }
            });
    }

    function submitBooking(e) {
        e.preventDefault(); 
        const btn = document.getElementById('btn-submit');
        const originalText = btn.innerText;
        btn.innerText = 'Memproses...';
        btn.disabled = true;

        const formData = new FormData(e.target);
        const data = Object.fromEntries(formData.entries());

        fetch('/api/bookings', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            if (!response.ok) return response.json().then(err => { throw err; });
            return response.json();
        })
        .then(result => {
            showPaymentModal(result.data);
            
            btn.innerText = originalText;
            btn.disabled = false;
        })
        .catch(error => {
            console.error(error);
            let pesans = error.message || "Terjadi kesalahan.";
            if(error.errors) pesans = Object.values(error.errors).flat().join('\n');
            alert('Gagal:\n' + pesans);
            btn.innerText = originalText;
            btn.disabled = false;
        });
    }

    function showPaymentModal(data) {
        const modal = document.getElementById('payment-modal');
        
        const hargaPaket = parseInt(data.total_bayar); 
        const kodeUnik = parseInt(data.kode_unik);
        const grandTotal = hargaPaket + kodeUnik;

        const fmt = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 });

        document.getElementById('bill-price').innerText = fmt.format(hargaPaket);
        document.getElementById('bill-code').innerText = kodeUnik;
        document.getElementById('bill-total').innerText = fmt.format(grandTotal);

        modal.classList.remove('hidden');
    }

    function finishOrder() {
        alert("Terima kasih! Pesanan Anda sedang kami proses.");
        window.location.href = '/'; 
    }

    function copyText(text) {
        navigator.clipboard.writeText(text);
        alert('Nomor rekening disalin!');
    }
</script>

@endsection