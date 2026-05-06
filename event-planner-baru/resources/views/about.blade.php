@extends('layout')

@section('content')

<section class="bg-white py-16">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl font-extrabold text-gray-900 mb-4">
            Tentang <span class="text-blue-600">PartyKit'Z</span>
        </h1>
        <p class="text-lg text-gray-500 max-w-2xl mx-auto">
            Kami hadir untuk mengubah cara Anda menikmati momen kebersamaan. 
            Lupakan ribetnya persiapan, fokus saja pada kebahagiaan.
        </p>
    </div>
</section>

<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="flex flex-col md:flex-row items-center gap-12">
            <div class="w-full md:w-1/2">
                <div class="relative rounded-2xl overflow-hidden shadow-2xl rotate-2 hover:rotate-0 transition duration-500">
                    <img src="https://images.unsplash.com/photo-1529193591184-b1d58069ecdd?q=80&w=800&auto=format&fit=crop" 
                         alt="Party Moment" 
                         class="w-full h-full object-cover">
                </div>
            </div>

            <div class="w-full md:w-1/2 space-y-6">
                <h2 class="text-3xl font-bold text-gray-800">
                    Berawal dari <span class="text-blue-600">"Ribet Banget Sih?"</span>
                </h2>
                <p class="text-gray-600 leading-relaxed">
                    Pernah nggak sih mau grill-an di rumah tapi males beli alatnya karena mahal dan jarang dipake? Belum lagi harus belanja daging, bumbu, dan cuci-cuci alat yang berminyak setelah acara selesai.
                </p>
                <p class="text-gray-600 leading-relaxed">
                    Itulah kenapa <strong>PartyKit'Z</strong> lahir. Kami menyediakan solusi *One-Stop-Service* untuk kebutuhan pesta rumahan kamu. Mulai dari sewa kompor portable, grill pan, hingga paket daging premium yang sudah dimarinasi.
                </p>
                <div class="flex gap-4 pt-4">
                    <div class="text-center">
                        <span class="block text-2xl font-bold text-blue-600">500+</span>
                        <span class="text-xs text-gray-500 uppercase tracking-wide">Pelanggan Happy</span>
                    </div>
                    <div class="w-px bg-gray-300 h-12"></div>
                    <div class="text-center">
                        <span class="block text-2xl font-bold text-blue-600">50+</span>
                        <span class="text-xs text-gray-500 uppercase tracking-wide">Event Sukses</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            {{-- Card 1 --}}
            <div class="p-8 border border-gray-100 rounded-2xl shadow-sm hover:shadow-lg transition">
                <div class="w-14 h-14 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6 text-2xl">✨</div>
                <h3 class="text-xl font-bold mb-3">Dijamin Bersih</h3>
                <p class="text-gray-500 text-sm">Semua alat dicuci dengan standar kebersihan tinggi dan disterilkan sebelum dikirim.</p>
            </div>
            {{-- Card 2 --}}
            <div class="p-8 border border-gray-100 rounded-2xl shadow-sm hover:shadow-lg transition">
                <div class="w-14 h-14 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-6 text-2xl">🥩</div>
                <h3 class="text-xl font-bold mb-3">Daging Premium</h3>
                <p class="text-gray-500 text-sm">Bekerja sama dengan supplier daging terpercaya untuk menjamin rasa dan kualitas.</p>
            </div>
            {{-- Card 3 --}}
            <div class="p-8 border border-gray-100 rounded-2xl shadow-sm hover:shadow-lg transition">
                <div class="w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-6 text-2xl">🚀</div>
                <h3 class="text-xl font-bold mb-3">Antar Jemput</h3>
                <p class="text-gray-500 text-sm">Kamu duduk manis saja, tim kami yang akan mengantar dan menjemput alatnya.</p>
            </div>
        </div>
    </div>
</section>

