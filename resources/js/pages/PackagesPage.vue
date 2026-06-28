<template>
  <div>
    <section class="page-section">
      <div class="container mx-auto px-4 md:px-6">
        <div class="mb-6 text-sm text-[#5c5854] md:mb-8">
          <a href="/" class="hover:underline">Home</a>
          <span class="mx-2">›</span>
          <span class="text-[#1c1b1a]">Katalog Paket</span>
        </div>

        <GustoHeroCard label="Katalog paket">
          <div class="flex flex-wrap gap-3">
            <GustoStatusPill tone="coral">Pilihan untuk acara kecil-menengah</GustoStatusPill>
            <GustoStatusPill tone="success">Filter per kategori</GustoStatusPill>
          </div>
          <h1 class="page-title mt-5">Pilih paket yang sesuai dengan acara kamu.</h1>
          <p class="section-copy mt-5 max-w-3xl">
            Jelajahi pilihan paket grill dan steak dengan tampilan yang lebih jelas, ringkas, dan mudah dibandingkan melihat kebutuhan satu per satu.
          </p>
        </GustoHeroCard>
      </div>
    </section>

    <section class="page-section page-section-soft pt-0">
      <div class="container mx-auto px-4 md:px-6">
        <GustoInfoBanner
          icon="i"
          title="Mulai dari kategori yang paling mendekati kebutuhanmu"
          description="Setelah memilih kategori, kamu bisa langsung membandingkan isi paket dan harga awal tanpa harus membuka terlalu banyak halaman."
        />

        <div class="surface-pill mt-6 mb-8 flex flex-wrap gap-3 p-2 md:mb-10" id="package-filters">
          <button
            v-for="cat in categories"
            :key="cat.slug"
            @click="selectCategory(cat.slug)"
            :id="`filter-${cat.slug}`"
            class="rounded-full px-4 py-3 text-sm font-semibold transition-all duration-200 md:px-5"
            :class="activeCategory === cat.slug ? 'bg-[#1c1b1a] text-white' : 'text-[#5c5854] hover:bg-[#fbede4] hover:text-[#1c1b1a]'"
          >
            {{ cat.label }}
          </button>
        </div>

        <div v-if="loading" class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3 md:gap-6">
          <div v-for="i in 6" :key="i" class="card-premium overflow-hidden bg-white">
            <div class="h-56 bg-[#f7e7dc] md:h-60"></div>
            <div class="space-y-3 p-5">
              <div class="h-4 w-1/3 rounded-full bg-[#f7e7dc]"></div>
              <div class="h-5 w-3/4 rounded-full bg-[#f7e7dc]"></div>
              <div class="h-4 w-full rounded-full bg-[#fbede4]"></div>
            </div>
          </div>
        </div>

        <div v-else-if="packages.length === 0" class="card-premium bg-white p-8 text-center md:p-12">
          <div class="text-4xl">🙂</div>
          <h3 class="mt-4 text-xl font-semibold text-[#1c1b1a] md:text-2xl">Belum ada paket untuk kategori ini</h3>
          <p class="mt-2 text-sm leading-6 text-[#5c5854] md:text-base">Coba pilih kategori lain atau cek kembali beberapa saat lagi.</p>
        </div>

        <Transition name="fade-up" mode="out-in">
          <div
            v-if="!loading && packages.length > 0"
            :key="activeCategory"
            class="grid grid-cols-1 gap-5 md:grid-cols-2 xl:grid-cols-3 md:gap-6"
            id="packages-grid"
          >
            <article v-for="pkg in packages" :key="pkg.id" class="card-premium overflow-hidden bg-white">
              <div class="relative">
                <img
                  :src="pkg.image_url"
                  :alt="pkg.name"
                  class="h-60 w-full object-cover md:h-64"
                  loading="lazy"
                />
                <div class="absolute left-4 top-4">
                  <GustoStatusPill tone="neutral">{{ pkg.category }}</GustoStatusPill>
                </div>
              </div>

              <div class="p-5">
                <div class="flex items-start justify-between gap-4">
                  <h3 class="text-lg font-semibold text-[#1c1b1a]">{{ pkg.name }}</h3>
                  <div class="text-sm text-[#1c1b1a]">4.8 ★</div>
                </div>
                <p class="mt-3 line-clamp-3 text-sm leading-6 text-[#5c5854]">
                  {{ pkg.description }}
                </p>

                <div class="mt-5 flex items-center justify-between border-t border-[#e8ddd3] pt-5">
                  <div>
                    <div class="text-xs text-[#5c5854]">Mulai dari</div>
                    <div class="price-text text-lg text-[#1c1b1a]">{{ formatPrice(pkg.price) }}</div>
                  </div>
                  <a :href="`/booking?package_id=${pkg.id}`" class="btn-primary px-5 text-sm md:w-auto">Pesan</a>
                </div>
              </div>
            </article>
          </div>
        </Transition>
      </div>
    </section>

    <section class="page-section">
      <div class="container mx-auto px-4 md:px-6">
        <GustoHeroCard label="Butuh bantuan?">
          <div class="text-center">
            <h3 class="section-title">Masih bingung pilih paket?</h3>
            <p class="mx-auto mt-4 max-w-2xl section-copy">
              Gunakan konsultasi paket untuk menyesuaikan paket dengan jumlah tamu, jenis acara, dan budget yang kamu punya.
            </p>
            <div class="mt-8">
              <a href="/consultation" class="btn-primary md:w-auto">Konsultasi paket</a>
            </div>
          </div>
        </GustoHeroCard>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import GustoHeroCard from '../components/GustoHeroCard.vue';
import GustoInfoBanner from '../components/GustoInfoBanner.vue';
import GustoStatusPill from '../components/GustoStatusPill.vue';

const loading = ref(true);
const packages = ref([]);
const activeCategory = ref('semua-paket');

const categories = [
  { slug: 'semua-paket', label: 'Semua paket' },
  { slug: 'grill', label: 'Paket grill' },
  { slug: 'steak', label: 'Paket steak' },
];

function formatPrice(price) {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0,
  }).format(price);
}

async function selectCategory(slug) {
  activeCategory.value = slug;
  await fetchPackages();
}

async function fetchPackages() {
  loading.value = true;
  try {
    let url = '/api/packages';
    if (activeCategory.value !== 'semua-paket') {
      url += `?category=${activeCategory.value}`;
    }
    const res = await fetch(url);
    const result = await res.json();
    packages.value = result.data;
  } catch (err) {
    console.error(err);
    packages.value = [];
  } finally {
    loading.value = false;
  }
}

onMounted(fetchPackages);
</script>
