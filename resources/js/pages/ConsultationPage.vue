<template>
  <div>
    <section class="page-section">
      <div class="container mx-auto px-4 md:px-6">
        <div class="mb-6 text-sm text-[#5c5854] md:mb-8">
          <a href="/" class="hover:underline">Home</a>
          <span class="mx-2">›</span>
          <span class="text-[#1c1b1a]">Tanya AI</span>
        </div>

        <GustoHeroCard label="Konsultasi paket">
          <div class="flex flex-wrap gap-3">
            <GustoStatusPill tone="success">Respons lebih terarah</GustoStatusPill>
            <GustoStatusPill tone="coral">Cocokkan budget & tamu</GustoStatusPill>
          </div>
          <h1 class="page-title mt-5">Ceritakan kebutuhan acara, lalu biarkan AI membantu memilih paket.</h1>
          <p class="section-copy mt-5 max-w-3xl">
            Tulis jumlah tamu, perkiraan budget, dan jenis acara. Sistem akan memberi rekomendasi paket yang paling relevan dengan bahasa yang lebih mudah dipahami.
          </p>
        </GustoHeroCard>
      </div>
    </section>

    <section class="page-section page-section-soft pt-0">
      <div class="container mx-auto px-4 md:px-6">
        <div class="grid gap-6 lg:grid-cols-[0.95fr_1.05fr]">
          <div id="consultation-form-wrapper">
            <div class="card-premium sticky top-28 bg-white p-5 md:p-6">
              <div class="mb-5 flex items-center justify-between gap-3 border-b border-[#e8ddd3] pb-4">
                <div>
                  <h3 class="text-lg font-semibold text-[#1c1b1a]">Konsultator paket</h3>
                  <p class="text-sm text-[#5c5854]">{{ isLoading ? 'Sedang memproses...' : 'Siap membantu memilih paket' }}</p>
                </div>
              </div>

              <form @submit.prevent="getRecommendation" id="consultation-form">
                <label class="mb-3 block text-sm font-semibold text-[#1c1b1a]">
                  Ceritakan kebutuhan acaramu
                </label>

                <textarea
                  v-model="userInput"
                  rows="8"
                  id="consultation-textarea"
                  class="textarea-airbnb p-4 text-sm leading-6"
                  placeholder="Contoh: Saya mau bikin acara ulang tahun anak di rumah untuk 20 orang. Budget sekitar 500 ribu. Pengennya ada menu bakaran yang simple."
                  :disabled="isLoading"
                  maxlength="500"
                ></textarea>

                <div class="mt-2 text-right text-xs text-[#5c5854]">{{ userInput.length }}/500</div>

                <button
                  type="submit"
                  id="consultation-submit"
                  :disabled="isLoading || !userInput.trim()"
                  class="btn-primary mt-5 w-full disabled:cursor-not-allowed disabled:opacity-50"
                >
                  {{ isLoading ? 'Sedang mencari paket...' : 'Lihat rekomendasi paket' }}
                </button>
              </form>

              <div class="mt-5 space-y-3">
                <GustoInfoBanner
                  icon="i"
                  title="Tips agar hasil lebih tepat"
                  description="Sebutkan jumlah tamu, budget, jenis acara, dan preferensi menu utama bila ada."
                />
                <div class="rounded-[20px] bg-[#fbede4] p-4">
                  <ul class="space-y-2 text-sm text-[#5c5854]">
                    <li v-for="tip in tips" :key="tip">• {{ tip }}</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>

          <div id="consultation-results">
            <div
              v-if="!hasResult && !isLoading"
              class="hero-card flex min-h-[420px] flex-col justify-center p-8 md:min-h-[480px] md:p-10"
            >
              <GustoStatusPill tone="neutral">Mulai dari kebutuhan acara</GustoStatusPill>
              <h3 class="mt-5 text-2xl font-semibold text-[#1c1b1a] md:text-3xl">Ceritakan acara yang sedang kamu rencanakan</h3>
              <p class="mt-3 max-w-md text-base leading-7 text-[#5c5854] md:text-lg md:leading-8">Isi formulir di samping, lalu AI akan membantu mencocokkan kebutuhanmu dengan paket yang tersedia.</p>

              <div class="mt-8 flex flex-wrap gap-2">
                <button
                  v-for="suggestion in suggestions"
                  :key="suggestion"
                  @click="userInput = suggestion"
                  class="rounded-full border border-[#e8ddd3] bg-white px-4 py-2 text-sm text-[#5c5854] transition hover:border-[#1c1b1a] hover:text-[#1c1b1a]"
                >
                  {{ suggestion }}
                </button>
              </div>
            </div>

            <div v-if="isLoading" class="card-premium bg-white p-8 text-center md:p-10">
              <h3 class="text-xl font-semibold text-[#1c1b1a] md:text-2xl">Sedang mencari paket yang sesuai</h3>
              <p class="mt-3 text-sm leading-7 text-[#5c5854] md:text-base">Sistem sedang membaca kebutuhanmu dan menyiapkan rekomendasi paket.</p>
            </div>

            <div v-if="error && !isLoading" class="card-premium border-red-200 bg-white p-8 text-center md:p-10">
              <h3 class="text-xl font-semibold text-red-600">Terjadi kesalahan</h3>
              <p class="mt-2 text-sm text-red-500">{{ error }}</p>
            </div>

            <div v-if="hasResult && !isLoading && results.length > 0" class="space-y-5">
              <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div>
                  <h3 class="text-2xl font-semibold text-[#1c1b1a]">Rekomendasi AI</h3>
                  <p class="text-sm text-[#5c5854]">Hasil berdasarkan informasi yang kamu kirim</p>
                </div>
                <GustoStatusPill tone="neutral">{{ results.length }} paket</GustoStatusPill>
              </div>

              <article
                v-for="(item, index) in results"
                :key="item.id"
                class="card-premium overflow-hidden bg-white"
              >
                <div v-if="index === 0" class="bg-[#1c1b1a] px-5 py-3 text-xs font-semibold uppercase tracking-wide text-white">
                  Pilihan utama AI
                </div>
                <div class="grid gap-0 md:grid-cols-[220px_1fr]">
                  <img
                    :src="item.image_url || 'https://via.placeholder.com/400x300'"
                    :alt="item.name"
                    class="h-56 w-full object-cover md:h-full md:min-h-[220px]"
                  />
                  <div class="p-5 md:p-6">
                    <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
                      <div>
                        <div class="text-xs font-semibold uppercase tracking-wide text-[#5c5854]">{{ item.category }}</div>
                        <h4 class="mt-2 text-lg font-semibold text-[#1c1b1a] md:text-xl">{{ item.name }}</h4>
                      </div>
                      <div class="text-left md:text-right">
                        <div class="text-xs text-[#5c5854]">Mulai dari</div>
                        <div class="price-text text-lg text-[#1c1b1a] md:text-xl">{{ formatPrice(item.price) }}</div>
                      </div>
                    </div>

                    <div class="mt-5 rounded-[20px] bg-[#fbede4] p-4">
                      <div class="mb-2 text-sm font-semibold text-[#1c1b1a]">Alasan AI memilih ini</div>
                      <p class="text-sm leading-6 text-[#5c5854]">{{ item.ai_reason }}</p>
                    </div>

                    <div class="mt-5 flex justify-end">
                      <a :href="`/booking?package_id=${item.id}`" class="btn-primary md:w-auto">Pesan paket ini</a>
                    </div>
                  </div>
                </div>
              </article>
            </div>

            <div v-if="hasResult && !isLoading && results.length === 0" class="card-premium bg-white p-8 text-center md:p-10">
              <h3 class="text-xl font-semibold text-[#1c1b1a] md:text-2xl">Belum ada paket yang cocok</h3>
              <p class="mt-3 text-sm leading-7 text-[#5c5854] md:text-base">Coba jelaskan jumlah tamu, budget, dan jenis acara dengan lebih rinci.</p>
              <button @click="userInput = ''; hasResult = false; error = ''" class="btn-ghost mt-6 md:w-auto">Coba lagi</button>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import GustoHeroCard from '../components/GustoHeroCard.vue';
import GustoInfoBanner from '../components/GustoInfoBanner.vue';
import GustoStatusPill from '../components/GustoStatusPill.vue';

const userInput = ref('');
const isLoading = ref(false);
const hasResult = ref(false);
const results = ref([]);
const error = ref('');

const tips = [
  'Sebutkan jumlah tamu yang akan hadir',
  'Tambahkan kisaran budget yang tersedia',
  'Tuliskan jenis acara yang sedang direncanakan',
  'Jelaskan preferensi menu utama bila ada',
];

const suggestions = [
  'Ulang tahun 15 orang, budget 300 ribu',
  'Gathering keluarga 30 orang, mau yang praktis',
  'Acara kantor santai untuk 20 orang',
  'Dinner kecil 2 sampai 4 orang',
];

function formatPrice(price) {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0,
  }).format(price);
}

async function getRecommendation() {
  if (!userInput.value.trim()) return;

  isLoading.value = true;
  hasResult.value = false;
  error.value = '';
  results.value = [];

  try {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
    const res = await fetch('/api/recommendation', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-CSRF-TOKEN': csrfToken,
      },
      body: JSON.stringify({ user_request: userInput.value }),
    });

    const data = await res.json();

    if (data.data) {
      results.value = data.data;
    } else if (data.message) {
      error.value = data.message;
    }

    hasResult.value = true;
  } catch (err) {
    error.value = 'Gagal menghubungi server. Pastikan koneksi internet dan API Key tersedia.';
    hasResult.value = true;
  } finally {
    isLoading.value = false;
  }
}
</script>
