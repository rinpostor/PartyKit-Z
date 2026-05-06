@extends('layout')

@section('content')


<section class="relative h-[80vh] flex items-center justify-center overflow-hidden bg-gray-900">

    <img src="{{ asset('images/img.jpeg') }}" alt="Party Background" 
         class="absolute inset-0 w-full h-full object-cover opacity-60">
    
    <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-transparent to-transparent"></div>
    <div class="relative z-10 text-center px-4 max-w-4xl mx-auto">
        <span class="inline-block py-1 px-3 rounded-full bg-yellow-500/20 text-yellow-400 text-sm font-bold mb-4 border border-yellow-500/50 backdrop-blur-sm">
            ✨ Solusi Acara Kamu
        </span>
        <h1 class="text-4xl md:text-6xl font-extrabold text-white tracking-tight mb-6 leading-tight">
            Bikin Momen Spesial <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-500">Tanpa Ribet</span>
        </h1>
        <p class="text-lg text-gray-200 mb-8 max-w-2xl mx-auto">
            Sedia alat dan bahan lengkap untuk Grill, Steak, dan Party di rumah. Tinggal pesan, kami antar sampai depan pintu.
        </p>
        <div class="flex flex-col md:flex-row gap-4 justify-center">
            <a href="/packages" class="bg-blue-600 text-white px-8 py-3 rounded-full font-bold text-lg hover:bg-blue-700 transition shadow-lg hover:shadow-blue-500/50">
                Lihat Katalog
            </a>
            <a href="/about" class="bg-white/10 backdrop-blur-md text-white border border-white/30 px-8 py-3 rounded-full font-bold text-lg hover:bg-white/20 transition">
                Tentang Kami
            </a>
        </div>
    </div>
</section>

<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12">
            <div class="flex justify-center items-center gap-2 mb-2">
                <span class="text-orange-500 text-xl">🔥</span>
                <span class="text-sm font-bold text-orange-600 tracking-wider uppercase">Paling Laris</span>
            </div>
            <h2 class="text-3xl font-bold text-gray-800">Best Seller Packages</h2>
        </div>

        <div id="bestseller-container" class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @for($i=0; $i<3; $i++)
            <div class="animate-pulse bg-gray-100 rounded-2xl h-80"></div>
            @endfor
        </div>

        <div class="text-center mt-12">
            <a href="/packages" class="inline-flex items-center text-blue-600 font-semibold hover:text-blue-800 transition">
                Lihat Semua Paket 
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>
    </div>
</section>

<section class="py-16 bg-gray-50 border-t border-gray-200">
    <div class="container mx-auto px-4 grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
        <div class="p-6">
            <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl">⚡</div>
            <h3 class="text-xl font-bold mb-2">Proses Cepat</h3>
            <p class="text-gray-500">Pesan sekarang, alat langsung dikirim ke lokasi Anda.</p>
        </div>
        <div class="p-6">
            <div class="w-16 h-16 bg-green-100 text-green-600 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl">🥩</div>
            <h3 class="text-xl font-bold mb-2">Bahan Segar</h3>
            <p class="text-gray-500">Daging premium dan sayuran fresh setiap hari.</p>
        </div>
        <div class="p-6">
            <div class="w-16 h-16 bg-purple-100 text-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-4 text-2xl">💎</div>
            <h3 class="text-xl font-bold mb-2">Alat Lengkap</h3>
            <p class="text-gray-500">Kompor, grill pan, hingga capit sudah kami sediakan.</p>
        </div>
    </div>
</section>

<script>
document.addEventListener("DOMContentLoaded", function() {

    fetch('/api/packages')
        .then(res => res.json())
        .then(result => {
            const container = document.getElementById('bestseller-container');
            const data = result.data.slice(0, 3); //

            let html = '';
            data.forEach(pkg => {
                let price = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(pkg.price);
                
                html += `
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition duration-300 overflow-hidden border border-gray-100 flex flex-col">
                    <div class="relative h-56 overflow-hidden group">
                        <img src="${pkg.image_url}" alt="${pkg.name}" class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
                        <div class="absolute top-3 right-3 bg-white/90 backdrop-blur px-3 py-1 rounded-lg text-xs font-bold text-gray-800 shadow-sm">
                            ${pkg.category}
                        </div>
                    </div>
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">${pkg.name}</h3>
                        <p class="text-gray-500 text-sm mb-4 line-clamp-2">${pkg.description}</p>
                        <div class="mt-auto flex items-center justify-between">
                            <span class="text-blue-600 font-bold text-lg">${price}</span>
                            <a href="/booking?package_id=${pkg.id}" class="bg-gray-900 text-white px-4 py-2 rounded-lg text-sm hover:bg-gray-700 transition">
                                Pesan
                            </a>
                        </div>
                    </div>
                </div>
                `;
            });

            container.innerHTML = html;
        })
        .catch(err => {
            console.error(err);
            document.getElementById('bestseller-container').innerHTML = '<p class="text-center col-span-3 text-red-500">Gagal memuat data.</p>';
        });
});
</script>

@endsection