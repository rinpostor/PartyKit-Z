@extends('layout') 

@section('content')


<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Katalog Paket</h2>
            <p class="text-gray-500">Temukan paket yang cocok untuk acaramu</p>
        </div>

      
        <div class="flex justify-center gap-4 mb-8">
            <button onclick="fetchPackages('semua-paket')" class="filter-btn active px-6 py-2 rounded-full border border-blue-600 bg-blue-600 text-white hover:bg-blue-700 transition" id="btn-semua">
                Semua Paket
            </button>
            <button onclick="fetchPackages('grill')" class="filter-btn px-6 py-2 rounded-full border border-gray-300 text-gray-600 hover:border-blue-500 hover:text-blue-500 transition" id="btn-grill">
                Paket Grill
            </button>
            <button onclick="fetchPackages('steak')" class="filter-btn px-6 py-2 rounded-full border border-gray-300 text-gray-600 hover:border-blue-500 hover:text-blue-500 transition" id="btn-steak">
                Paket Steak
            </button>
        </div>


        <div id="skeleton-loader" class="grid grid-cols-1 md:grid-cols-3 gap-8 hidden">
            @for ($i = 0; $i < 3; $i++)
            <div class="bg-white rounded-xl shadow-md overflow-hidden animate-pulse">
                <div class="h-48 bg-gray-300 w-full"></div> {{-- Kotak Gambar --}}
                <div class="p-5">
                    <div class="h-4 bg-gray-300 rounded w-1/3 mb-2"></div> {{-- Kategori --}}
                    <div class="h-6 bg-gray-300 rounded w-3/4 mb-4"></div> {{-- Judul --}}
                    <div class="h-4 bg-gray-200 rounded w-full mb-2"></div> {{-- Deskripsi --}}
                    <div class="h-4 bg-gray-200 rounded w-2/3 mb-4"></div>
                    <div class="flex justify-between items-center mt-4">
                        <div class="h-6 bg-gray-300 rounded w-1/4"></div>
                        <div class="h-10 bg-gray-300 rounded w-1/3"></div>
                    </div>
                </div>
            </div>
            @endfor
        </div>

        <div id="package-container" class="grid grid-cols-1 md:grid-cols-3 gap-8 transition-opacity duration-500">
        </div>

        <div id="empty-state" class="hidden text-center py-16">
            <div class="mb-4 flex justify-center">
                <svg class="w-32 h-32 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-700">Yah, Paket ini sedang kosong!</h3>
            <p class="text-gray-500 mt-2">Coba pilih kategori paket yang lain ya.</p>
        </div>

    </div>
</section>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        fetchPackages('semua-paket'); 
    });

    function fetchPackages(categorySlug) {
        const container = document.getElementById('package-container');
        const skeleton = document.getElementById('skeleton-loader');
        const emptyState = document.getElementById('empty-state');
        

        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.classList.remove('bg-blue-600', 'text-white', 'border-blue-600');
            btn.classList.add('text-gray-600', 'border-gray-300');
        });

        let activeBtnId = 'btn-semua';
        if(categorySlug.includes('grill')) activeBtnId = 'btn-grill';
        if(categorySlug.includes('steak')) activeBtnId = 'btn-steak';
        
        const activeBtn = document.getElementById(activeBtnId);
        if(activeBtn) {
            activeBtn.classList.remove('text-gray-600', 'border-gray-300');
            activeBtn.classList.add('bg-blue-600', 'text-white', 'border-blue-600');
        }

        container.classList.add('hidden');
        emptyState.classList.add('hidden');
        skeleton.classList.remove('hidden');
        skeleton.classList.add('grid');

        let url = `/api/packages`;
        if (categorySlug !== 'semua-paket') {
            url += `?category=${categorySlug}`;
        }

        fetch(url)
            .then(response => response.json())
            .then(result => {
              
                skeleton.classList.add('hidden');
                skeleton.classList.remove('grid');

                const data = result.data;

                if (data.length === 0) {
                    emptyState.classList.remove('hidden');
                    return;
                }

                container.classList.remove('hidden');
                container.innerHTML = '';

                data.forEach(pkg => {
                    let price = new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(pkg.price);

                    const cardHtml = `
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden transform transition duration-300 hover:-translate-y-2 hover:shadow-2xl flex flex-col h-full">
                            <div class="relative h-48 overflow-hidden">
                                <img src="${pkg.image_url}" alt="${pkg.name}" class="w-full h-full object-cover transition duration-500 hover:scale-110">
                                <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-bold text-blue-600 shadow-sm">
                                    ${pkg.category}
                                </div>
                            </div>
                            
                            <div class="p-6 flex flex-col flex-grow">
                                <h3 class="text-xl font-bold text-gray-800 mb-2">${pkg.name}</h3>
                                <p class="text-gray-500 text-sm mb-4 line-clamp-2 flex-grow">${pkg.description}</p>
                                
                                <div class="mt-auto border-t pt-4 flex items-center justify-between">
                                    <div class="text-lg font-bold text-blue-600">${price}</div>
                                    <a href="/booking?package_id=${pkg.id}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-blue-700 transition shadow-md hover:shadow-lg">
                                        Pesan Sekarang
                                    </a>
                                </div>
                            </div>
                        </div>
                    `;
                    container.innerHTML += cardHtml;
                });
            })
            .catch(error => {
                console.error('Error:', error);
                skeleton.classList.add('hidden');
            });
    }
    
    
    
</script>
@endsection