<div class="min-h-screen bg-transparent">
    @if($packageError)
        <section class="page-section">
            <div class="container mx-auto px-4 md:px-6">
                <div class="mx-auto max-w-2xl hero-card px-6 py-8 text-center md:px-10 md:py-12">
                    <div class="section-label mb-4">Booking</div>
                    <h1 class="page-title text-center">Paket tidak ditemukan</h1>
                    <p class="section-copy mt-4">
                        Silakan kembali ke katalog lalu pilih paket yang ingin dipesan terlebih dahulu.
                    </p>
                    <div class="mt-8">
                        <a href="/packages" class="btn-primary md:w-auto">Lihat katalog paket</a>
                    </div>
                </div>
            </div>
        </section>
    @else
        <section class="page-section pt-10 md:pt-14">
            <div class="container mx-auto px-4 md:px-6">
                <div class="mb-6 text-sm text-[#5c5854] md:mb-8">
                    <a href="/" class="hover:underline">Home</a>
                    <span class="mx-2">›</span>
                    <a href="/packages" class="hover:underline">Katalog Paket</a>
                    <span class="mx-2">›</span>
                    <span class="text-[#1c1b1a]">Formulir Pemesanan</span>
                </div>

                <div class="hero-card overflow-hidden px-6 py-7 md:px-8 md:py-10">
                    <div class="flex flex-wrap gap-3">
                        <x-gusto-badge tone="coral">Booking flow</x-gusto-badge>
                        <x-gusto-badge tone="success">Konfirmasi cepat</x-gusto-badge>
                    </div>

                    <div class="mt-5 max-w-4xl">
                        <h1 class="page-title-lg">Pesan paket pilihanmu dengan alur yang ringkas dan jelas.</h1>
                        <p class="section-copy mt-5 max-w-3xl">
                            Tinjau detail paket, isi data pemesan, lalu lanjutkan ke instruksi pembayaran. Semua informasi utama dirangkum dalam satu halaman agar proses reservasi terasa sederhana.
                        </p>
                    </div>

                    @if($packageLoaded)
                        <div class="mt-8 flex flex-wrap gap-3">
                            <x-gusto-badge>{{ $package['category'] ?? 'Umum' }}</x-gusto-badge>
                            <x-gusto-badge tone="success">Siap dipesan</x-gusto-badge>
                            <x-gusto-badge>Pembayaran transfer</x-gusto-badge>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <section class="page-section page-section-soft pt-0">
            <div class="container mx-auto px-4 md:px-6">
                <div class="mx-auto grid max-w-7xl gap-6 xl:grid-cols-[1.2fr_0.8fr] items-start">
                    <div class="space-y-6">
                        <div class="card-premium overflow-hidden bg-white">
                            @if(!$packageLoaded)
                                <div class="h-72 bg-[#f7e7dc] md:h-[420px]"></div>
                                <div class="space-y-3 p-5 md:p-6">
                                    <div class="h-4 w-1/3 rounded-full bg-[#f7e7dc]"></div>
                                    <div class="h-6 w-2/3 rounded-full bg-[#f7e7dc]"></div>
                                    <div class="h-4 w-full rounded-full bg-[#fbede4]"></div>
                                </div>
                            @else
                                <div class="grid gap-0 lg:grid-cols-[1.08fr_0.92fr]">
                                    <img
                                        src="{{ $package['image_url'] ?? '' }}"
                                        alt="{{ $package['name'] ?? '' }}"
                                        class="h-80 w-full object-cover md:h-[420px]"
                                    >

                                    <div class="p-5 md:p-6 lg:p-8">
                                        <div class="mb-3">
                                            <x-gusto-badge>{{ $package['category'] ?? '' }}</x-gusto-badge>
                                        </div>

                                        <div class="flex flex-wrap items-center gap-3 text-sm text-[#5c5854]">
                                            <span>4.9 ★ rating pelanggan</span>
                                            <span>•</span>
                                            <span>Siap dipesan</span>
                                        </div>

                                        <h2 class="mt-4 text-2xl font-semibold leading-tight text-[#1c1b1a] md:text-3xl">
                                            {{ $package['name'] ?? '' }}
                                        </h2>

                                        <p class="mt-4 text-sm leading-7 text-[#5c5854] md:text-base md:leading-8">
                                            {{ $package['description'] ?? '' }}
                                        </p>

                                        <div class="mt-6 grid gap-3 sm:grid-cols-2">
                                            <x-gusto-step-card title="Harga paket" :description="$this->formatPrice($package['price'] ?? 0)">
                                                <div class="price-text mt-2 text-xl text-[#1c1b1a] md:text-2xl">
                                                    {{ $this->formatPrice($package['price'] ?? 0) }}
                                                </div>
                                            </x-gusto-step-card>
                                            <x-gusto-step-card title="Alur pemesanan" description="Isi data → konfirmasi → transfer" />
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="card-premium bg-white p-5 md:p-6">
                            <h3 class="text-lg font-semibold text-[#1c1b1a] md:text-xl">Yang akan kamu lakukan</h3>
                            <div class="mt-5 grid gap-4 md:grid-cols-3">
                                <x-gusto-step-card title="1. Isi data" description="Masukkan nama, email, nomor WhatsApp, dan tanggal acara." />
                                <x-gusto-step-card title="2. Tinjau total" description="Sistem menyiapkan total transfer beserta kode unik pembayaran." />
                                <x-gusto-step-card title="3. Konfirmasi" description="Lanjutkan pembayaran lalu simpan bukti transfer untuk verifikasi." />
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="card-premium sticky top-32 bg-white p-5 md:p-6 lg:p-8">
                            <div class="mb-5 border-b border-[#e8ddd3] pb-4">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <div class="text-sm text-[#5c5854]">Reserve</div>
                                        <h3 class="mt-1 text-xl font-semibold text-[#1c1b1a] md:text-2xl">Lengkapi detail pemesan</h3>
                                    </div>
                                    @if($packageLoaded)
                                        <div class="text-right">
                                            <div class="text-xs text-[#5c5854]">Mulai dari</div>
                                            <div class="price-text text-lg text-[#1c1b1a]">{{ $this->formatPrice($package['price'] ?? 0) }}</div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            @if($flashMessage)
                                <div class="mb-6 rounded-[20px] border px-5 py-4 text-sm font-medium {{ $flashType === 'success' ? 'border-green-200 bg-[#d7f0e4] text-[#1e875f]' : 'border-red-200 bg-red-50 text-red-700' }}">
                                    {{ $flashMessage }}
                                </div>
                            @endif

                            <form wire:submit="submitBooking" class="space-y-5 md:space-y-6">
                                <div>
                                    <label class="mb-2 block text-sm font-semibold text-[#1c1b1a]">
                                        Nama lengkap <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="text"
                                        wire:model.live.debounce.500ms="nama_pemesan"
                                        placeholder="Masukkan nama lengkap Anda"
                                        class="input-airbnb px-4 py-3.5 text-sm {{ $errors->has('nama_pemesan') ? 'border-red-400 bg-red-50 text-red-700' : '' }}"
                                    >
                                    @error('nama_pemesan')
                                        <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid gap-5 md:grid-cols-2">
                                    <div>
                                        <label class="mb-2 block text-sm font-semibold text-[#1c1b1a]">
                                            Email <span class="text-red-500">*</span>
                                        </label>
                                        <input
                                            type="email"
                                            wire:model.live.debounce.500ms="email_pemesan"
                                            placeholder="email@contoh.com"
                                            class="input-airbnb px-4 py-3.5 text-sm {{ $errors->has('email_pemesan') ? 'border-red-400 bg-red-50 text-red-700' : '' }}"
                                        >
                                        @error('email_pemesan')
                                            <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="mb-2 block text-sm font-semibold text-[#1c1b1a]">
                                            WhatsApp <span class="text-red-500">*</span>
                                        </label>
                                        <input
                                            type="number"
                                            wire:model.live.debounce.500ms="telepon_pemesan"
                                            placeholder="0812xxxx"
                                            class="input-airbnb px-4 py-3.5 text-sm {{ $errors->has('telepon_pemesan') ? 'border-red-400 bg-red-50 text-red-700' : '' }}"
                                        >
                                        @error('telepon_pemesan')
                                            <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-semibold text-[#1c1b1a]">
                                        Tanggal acara <span class="text-red-500">*</span>
                                    </label>
                                    <input
                                        type="date"
                                        wire:model.live="tanggal_event"
                                        min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                        class="input-airbnb cursor-pointer px-4 py-3.5 text-sm {{ $errors->has('tanggal_event') ? 'border-red-400 bg-red-50 text-red-700' : '' }}"
                                    >
                                    @error('tanggal_event')
                                        <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="rounded-[20px] bg-[#fbede4] p-4 text-sm leading-6 text-[#5c5854]">
                                    Pastikan tanggal acara, kontak, dan paket yang dipilih sudah benar sebelum lanjut ke tahap pembayaran.
                                </div>

                                <button
                                    type="submit"
                                    wire:loading.attr="disabled"
                                    class="btn-primary w-full disabled:cursor-not-allowed disabled:opacity-60"
                                >
                                    <span wire:loading.remove wire:target="submitBooking">Konfirmasi pesanan</span>
                                    <span wire:loading wire:target="submitBooking">Memproses pesanan...</span>
                                </button>

                                <p class="text-center text-xs leading-5 text-[#5c5854]">
                                    Data pemesanan digunakan untuk konfirmasi order dan proses pembayaran.
                                </p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
</div>

@if($showPaymentModal && $orderData)
<div class="fixed inset-0 z-[200] flex items-center justify-center bg-black/45 p-4">
    <div class="hero-card w-full max-w-md overflow-hidden bg-white shadow-[0_24px_80px_rgba(0,0,0,0.18)]">
        <div class="border-b border-[#e8ddd3] px-6 py-6 text-center md:px-8">
            <div class="section-label mb-4">Pembayaran</div>
            <h3 class="text-2xl font-semibold text-[#1c1b1a]">Instruksi transfer</h3>
            <p class="mt-2 text-sm leading-6 text-[#5c5854]">
                Pesanan berhasil dibuat. Silakan transfer sesuai detail di bawah ini, lalu tunggu konfirmasi admin.
            </p>
        </div>

        <div class="space-y-6 px-6 py-6 md:px-8">
            @php
                $harga = (int) ($orderData['total_bayar'] ?? 0);
                $kode = (int) ($orderData['kode_unik'] ?? 0);
                $total = (int) ($orderData['grand_total'] ?? ($harga + $kode));
            @endphp

            <div class="rounded-[20px] bg-[#fbede4] p-5 text-center">
                <div class="text-sm text-[#5c5854]">Transfer ke rekening {{ $orderData['nama_bank'] ?? 'BCA' }}</div>
                <div class="price-text mt-2 text-2xl tracking-wide text-[#1c1b1a] md:text-3xl">{{ $orderData['nomor_rekening'] ?? '-' }}</div>
                <div class="mt-2 text-sm text-[#5c5854]">a.n. {{ $orderData['atas_nama_rekening'] ?? "PartyKit'Z Official" }}</div>
                <div class="mt-3 rounded-2xl bg-white/75 px-4 py-3 text-xs text-[#5c5854]">
                    Kode booking: <span class="font-semibold text-[#1c1b1a]">{{ $orderData['kode_booking'] ?? '-' }}</span>
                </div>
            </div>

            <div class="space-y-3 rounded-[20px] border border-[#e8ddd3] bg-white p-5">
                <div class="flex items-center justify-between gap-4 text-sm text-[#5c5854]">
                    <span>Harga paket</span>
                    <span class="price-text text-[#1c1b1a]">{{ $this->formatPrice($harga) }}</span>
                </div>
                <div class="flex items-center justify-between gap-4 text-sm text-[#5c5854]">
                    <span>Kode unik</span>
                    <span class="price-text text-[#1c1b1a]">{{ $kode }}</span>
                </div>
                <div class="border-t border-[#e8ddd3] pt-3">
                    <div class="flex items-center justify-between gap-4">
                        <span class="text-sm font-semibold text-[#1c1b1a]">Total transfer</span>
                        <span class="price-text text-xl text-[#1c1b1a] md:text-2xl">{{ $this->formatPrice($total) }}</span>
                    </div>
                </div>
            </div>

            <div class="rounded-[20px] border border-[#e8ddd3] bg-[#fffaf6] p-4 text-sm leading-6 text-[#5c5854]">
                Setelah transfer, admin akan mengecek pembayaran dari menu pesanan. Jika pembayaran sudah dikonfirmasi, sistem otomatis mengirim email ke customer.
            </div>

            <button
                wire:click="closeModal"
                class="btn-primary w-full"
            >
                Tutup popup
            </button>

            <p class="text-center text-xs leading-5 text-[#5c5854]">
                Simpan bukti transfer untuk keperluan verifikasi pesanan.
            </p>
        </div>
    </div>
</div>
@endif
