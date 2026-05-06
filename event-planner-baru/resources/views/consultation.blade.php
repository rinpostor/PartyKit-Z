@extends('layout')

@section('title', 'Konsultasi AI')

@section('content')
<div class="bg-gray-50 py-12 min-h-screen">
    <div class="container mx-auto px-4">
        
        <div class="text-center mb-10">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">
                <i class="fas fa-sparkles text-yellow-500 mr-2"></i>Konsultasi Cerdas
            </h1>
            <p class="text-gray-600">Bingung pilih paket? Ceritakan rencana acaramu, biarkan AI kami merekomendasikan yang terbaik.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            
            <div class="col-span-1 h-fit">
                <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 sticky top-24">
                    <div class="flex items-center gap-2 mb-4 border-b pb-3">
                        <i class="fas fa-robot text-blue-600 text-2xl"></i>
                        <h3 class="text-xl font-bold text-gray-800">Tanya Assistant</h3>
                    </div>
                    
                    <form id="aiForm" onsubmit="getAiRecommendation(event)">
                        <div class="mb-4">
                            <label class="block text-gray-700 font-medium mb-2">Ceritakan kebutuhan acaramu:</label>
                            <textarea id="userRequest" rows="6" 
                                class="w-full border-gray-300 rounded-xl p-4 bg-gray-50 border focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition"
                                placeholder="Contoh: Saya mau bikin acara ulang tahun anak di rumah untuk 20 orang. Budget sekitar 500 ribu. Pengennya yang ada menu bakaran sosis atau daging yang simple."></textarea>
                            <p class="text-xs text-gray-400 mt-2 text-right">Powered by Google Gemini AI</p>
                        </div>

                        <button type="submit" id="btnSubmit" class="w-full bg-blue-600 text-white font-bold py-3 rounded-xl hover:bg-blue-700 transition shadow-lg shadow-blue-600/20 flex justify-center items-center gap-2">
                            <span>Mulai Analisa</span> <i class="fas fa-paper-plane"></i>
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-span-1 md:col-span-2">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-bold text-gray-800">Rekomendasi Terbaik</h3>
                    <span id="resultCount" class="text-sm text-gray-500 hidden">Menampilkan hasil pencarian</span>
                </div>
                
                <div id="loadingResult" class="hidden text-center py-20 bg-white rounded-2xl border border-dashed border-gray-300">
                    <div class="spinner-border text-blue-600 w-10 h-10 mb-3" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <h5 class="text-gray-700 font-bold">Sedang Berpikir...</h5>
                    <p class="text-gray-500 text-sm">AI sedang mencocokkan paket dengan acaramu.</p>
                </div>

                <div id="resultContainer" class="space-y-6">
                    <div class="bg-blue-50 text-blue-800 p-8 rounded-2xl text-center border border-blue-100">
                        <i class="fas fa-search text-4xl mb-3 opacity-50"></i>
                        <p class="font-medium">Silakan isi formulir di samping untuk mendapatkan rekomendasi.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // --- Fungsi Menghubungi API AI ---
    function getAiRecommendation(e) {
        e.preventDefault();
        
        const userInput = document.getElementById('userRequest').value;
        const resultContainer = document.getElementById('resultContainer');
        const loading = document.getElementById('loadingResult');
        const btnSubmit = document.getElementById('btnSubmit');

        if(!userInput.trim()) {
            alert("Mohon isi deskripsi acara Anda terlebih dahulu!");
            return;
        }

        resultContainer.classList.add('hidden');
        loading.classList.remove('hidden');
        btnSubmit.disabled = true;
        btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Memproses...';
        btnSubmit.classList.add('opacity-75');

        fetch('/api/recommendation', {
            method: 'POST',
            headers: { 
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ user_request: userInput })
        })
        .then(res => res.json())
        .then(response => {
            
            loading.classList.add('hidden');
            resultContainer.classList.remove('hidden');
            btnSubmit.disabled = false;
            btnSubmit.innerHTML = '<span>Mulai Analisa</span> <i class="fas fa-paper-plane"></i>';
            btnSubmit.classList.remove('opacity-75');

            
            if(response.message && !response.data) {
                resultContainer.innerHTML = `<div class="bg-red-50 text-red-600 p-4 rounded-xl text-center border border-red-100"><p><strong>Error:</strong> ${response.message}</p></div>`;
            } else {
                renderResults(response.data);
            }
        })
        .catch(err => {
            console.error(err);
            loading.classList.add('hidden');
            resultContainer.classList.remove('hidden');
            btnSubmit.disabled = false;
            btnSubmit.innerHTML = '<span>Mulai Analisa</span> <i class="fas fa-paper-plane"></i>';
            alert("Gagal menghubungi server. Cek koneksi internet atau API Key.");
        });
    }

    function renderResults(data) {
        const container = document.getElementById('resultContainer');
        let html = '';

        if(!data || data.length === 0) {
            container.innerHTML = `<div class="bg-gray-100 p-6 rounded-xl text-center"><p>AI tidak menemukan paket yang cocok :(</p></div>`;
            return;
        }

        data.forEach((item, index) => {
           
            const highlightClass = index === 0 ? 'border-l-4 border-blue-500 shadow-md ring-1 ring-blue-100' : 'border border-gray-100 shadow-sm';
            const badge = index === 0 ? '<span class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded-full font-bold mb-2 inline-block">✨ Pilihan Utama</span>' : '';
            const harga = new Intl.NumberFormat('id-ID').format(item.price);
            
            const gambar = item.image_url || 'https://via.placeholder.com/300x200?text=No+Image';

            html += `
            <div class="bg-white rounded-xl overflow-hidden hover:shadow-lg transition duration-300 ${highlightClass}">
                <div class="flex flex-col md:flex-row">
                    <div class="w-full md:w-1/3 h-48 md:h-auto relative">
                        <img src="${gambar}" class="w-full h-full object-cover">
                    </div>
                    
                    <div class="p-6 flex-grow flex flex-col justify-between">
                        <div>
                            ${badge}
                            <div class="flex justify-between items-start mb-2">
                                <h4 class="text-xl font-bold text-gray-800">${item.name}</h4>
                                <span class="text-lg font-bold text-green-600">Rp ${harga}</span>
                            </div>
                            
                            <div class="bg-blue-50 p-4 rounded-xl border border-blue-100 mt-2">
                                <div class="flex gap-3">
                                    <i class="fas fa-robot text-blue-500 mt-1 flex-shrink-0"></i>
                                    <div>
                                        <p class="text-sm font-bold text-blue-800 mb-1">Kata AI:</p>
                                        <p class="text-sm text-gray-700 italic leading-relaxed">"${item.ai_reason}"</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 flex justify-end">
                            <a href="/booking?package_id=${item.id}" class="bg-gray-900 text-white px-6 py-2.5 rounded-full text-sm font-medium hover:bg-black transition shadow-lg shadow-gray-900/20 flex items-center gap-2 transform active:scale-95">
                                <i class="fas fa-shopping-cart"></i> Pesan Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            `;
        });

        container.innerHTML = html;
        document.getElementById('resultCount').classList.remove('hidden');
    }
</script>
@endsection