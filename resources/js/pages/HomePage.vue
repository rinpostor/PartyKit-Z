<template>
  <div>
    <section class="page-section pt-10 md:pt-16">
      <div class="container mx-auto px-4 md:px-6">
        <div class="grid items-center gap-8 lg:grid-cols-[1.05fr_0.95fr] lg:gap-12">
          <GustoHeroCard label="Party planning made simple">
            <div class="flex flex-wrap gap-3">
              <GustoStatusPill tone="coral">Siap kirim ke lokasi</GustoStatusPill>
              <GustoStatusPill tone="success">Paket lengkap & praktis</GustoStatusPill>
            </div>

            <h1 class="page-title-lg mt-5 max-w-3xl">
              Cari paket pesta rumahan yang hangat, rapi, dan gampang dipilih.
            </h1>
            <p class="section-copy mt-5 max-w-2xl">
              PartyKit'Z membantu kamu memilih paket grill, steak, dan perlengkapan acara tanpa ribet. Tinggal pilih kebutuhan, atur budget, lalu pesan dengan alur yang terasa ringan.
            </p>

            <div class="surface-pill mt-8 flex flex-col gap-3 p-3 md:flex-row md:items-center md:gap-0 md:p-2">
              <div class="flex-1 rounded-full px-4 py-3 md:border-r md:border-[#e8ddd3] md:px-5">
                <div class="text-xs font-semibold uppercase tracking-wide text-[#1c1b1a]">Acara</div>
                <div class="mt-1 text-sm text-[#5c5854]">Ulang tahun, gathering, BBQ</div>
              </div>
              <div class="flex-1 rounded-full px-4 py-3 md:border-r md:border-[#e8ddd3] md:px-5">
                <div class="text-xs font-semibold uppercase tracking-wide text-[#1c1b1a]">Budget</div>
                <div class="mt-1 text-sm text-[#5c5854]">Mulai dari paket yang paling pas</div>
              </div>
              <div class="flex-1 rounded-full px-4 py-3 md:px-5">
                <div class="text-xs font-semibold uppercase tracking-wide text-[#1c1b1a]">Layanan</div>
                <div class="mt-1 text-sm text-[#5c5854]">Antar, alat, bahan, AI consult</div>
              </div>
              <a href="/packages" class="btn-primary shrink-0 px-6 md:w-auto">Cari paket</a>
            </div>

            <div class="kpi-grid mt-8">
              <div v-for="stat in stats" :key="stat.label" class="card-premium kpi-card">
                <div class="kpi-value">{{ stat.value }}</div>
                <div class="kpi-label">{{ stat.label }}</div>
              </div>
            </div>
          </GustoHeroCard>

          <div class="relative">
            <img
              src="/images/img.jpeg"
              alt="Party setup"
              class="h-[360px] w-full rounded-[28px] object-cover sm:h-[440px] lg:h-[560px]"
            />
            <div class="absolute inset-x-4 bottom-4 space-y-3 sm:inset-x-auto sm:left-6 sm:right-6">
              <GustoInfoBanner
                icon="✓"
                tone="success"
                title="Paket mudah dipilih"
                description="Setiap paket dirancang supaya kamu tidak perlu menyusun alat dan bahan satu per satu."
              />
              <div class="card-premium max-w-sm bg-white p-5">
                <div class="mb-3 flex items-center justify-between">
                  <GustoStatusPill tone="neutral">Paling sering dipilih</GustoStatusPill>
                  <div class="text-sm font-semibold text-[#1c1b1a]">4.9 ★</div>
                </div>
                <div class="text-lg font-semibold text-[#1c1b1a]">Paket grill untuk acara santai di rumah</div>
                <div class="mt-2 text-sm leading-6 text-[#5c5854]">Alat, bahan, dan pengiriman dalam satu paket praktis yang cocok untuk acara keluarga.</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="border-y border-[#e8ddd3] bg-[#fbede4] py-3 md:py-4 overflow-hidden">
      <div class="flex animate-marquee whitespace-nowrap">
        <span v-for="item in [...tickerItems, ...tickerItems]" :key="item.text + Math.random()" class="inline-flex items-center gap-4 px-6 text-xs font-medium text-[#5c5854] md:px-8 md:text-sm">
          <span class="text-[#f45d48]">•</span>{{ item.text }}
        </span>
      </div>
    </section>

    <section class="page-section">
      <div class="container mx-auto px-4 md:px-6">
        <div class="mb-8 flex flex-col gap-4 md:mb-10 md:flex-row md:items-end md:justify-between">
          <div>
            <div class="section-label mb-4">Best seller</div>
            <h2 class="section-title">Paket favorit pelanggan</h2>
            <p class="mt-3 max-w-2xl text-sm leading-7 text-[#5c5854] md:text-base">Pilihan paket yang paling sering dipakai untuk acara kecil sampai menengah.</p>
          </div>
          <a href="/packages" class="text-sm font-semibold text-[#1c1b1a] hover:underline md:block">Lihat semua</a>
        </div>

        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3 md:gap-6">
          <div v-if="loading" v-for="i in 3" :key="i" class="card-premium overflow-hidden">
            <div class="h-56 bg-[#f7e7dc] md:h-64"></div>
            <div class="space-y-3 p-5">
              <div class="h-4 w-1/3 rounded-full bg-[#f7e7dc]"></div>
              <div class="h-5 w-2/3 rounded-full bg-[#f7e7dc]"></div>
              <div class="h-4 w-full rounded-full bg-[#fbede4]"></div>
            </div>
          </div>

          <article v-else v-for="pkg in packages" :key="pkg.id" class="card-premium overflow-hidden">
            <div class="relative">
              <img :src="pkg.image_url" :alt="pkg.name" class="h-64 w-full object-cover md:h-72" />
              <div class="absolute left-4 top-4">
                <GustoStatusPill tone="neutral">{{ pkg.category }}</GustoStatusPill>
              </div>
            </div>
            <div class="p-5">
              <div class="flex items-start justify-between gap-4">
                <div>
                  <h3 class="text-lg font-semibold text-[#1c1b1a]">{{ pkg.name }}</h3>
                  <p class="mt-2 line-clamp-2 text-sm leading-6 text-[#5c5854]">{{ pkg.description }}</p>
                </div>
                <div class="text-sm font-medium text-[#1c1b1a]">4.9 ★</div>
              </div>
              <div class="mt-5 flex items-center justify-between gap-4 border-t border-[#e8ddd3] pt-5">
                <div>
                  <div class="text-xs text-[#5c5854]">Mulai dari</div>
                  <div class="price-text text-lg text-[#1c1b1a]">{{ formatPrice(pkg.price) }}</div>
                </div>
                <a :href="`/booking?package_id=${pkg.id}`" class="btn-primary px-5 text-sm md:w-auto">Pesan</a>
              </div>
            </div>
          </article>
        </div>
      </div>
    </section>

    <section class="page-section page-section-soft">
      <div class="container mx-auto px-4 md:px-6">
        <div class="mb-8 text-center md:mb-10">
          <div class="section-label mb-4">Kenapa pilih kami</div>
          <h2 class="section-title">Layanan yang terasa ringan dan jelas</h2>
        </div>

        <div class="grid gap-5 md:grid-cols-3 md:gap-6">
          <div v-for="feature in features" :key="feature.title" class="card-premium p-5 md:p-6">
            <div class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-full bg-[#fbede4] text-2xl">{{ feature.icon }}</div>
            <h3 class="text-lg font-semibold text-[#1c1b1a] md:text-xl">{{ feature.title }}</h3>
            <p class="mt-3 text-sm leading-6 text-[#5c5854]">{{ feature.description }}</p>
          </div>
        </div>
      </div>
    </section>

    <section class="page-section">
      <div class="container mx-auto px-4 md:px-6">
        <div class="section-grid items-start">
          <GustoInfoBanner
            icon="✓"
            title="Alur pesan lebih mudah dipahami"
            description="Dari pilih paket sampai checkout, kami jaga supaya informasi penting tetap ringkas dan mudah dibaca."
          />
          <GustoInfoBanner
            icon="🤖"
            tone="success"
            title="Konsultasi saat kamu masih bingung"
            description="Tinggal tulis jumlah tamu, budget, dan jenis acara, lalu sistem bantu arahkan ke paket yang paling cocok."
          />
        </div>

        <div class="mt-10 grid gap-5 md:grid-cols-3 md:gap-6">
          <div v-for="review in testimonials" :key="review.name" class="card-premium p-5 md:p-6">
            <div class="mb-4 text-sm text-[#1c1b1a]">★★★★★</div>
            <p class="text-sm leading-6 text-[#5c5854]">"{{ review.text }}"</p>
            <div class="mt-5 border-t border-[#e8ddd3] pt-4">
              <div class="font-semibold text-[#1c1b1a]">{{ review.name }}</div>
              <div class="text-sm text-[#5c5854]">{{ review.location }}</div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="page-section page-section-soft">
      <div class="container mx-auto px-4 md:px-6">
        <GustoHeroCard label="Konsultasi gratis">
          <div class="text-center">
            <h2 class="section-title">Butuh rekomendasi paket yang paling pas?</h2>
            <p class="mx-auto mt-4 max-w-2xl section-copy">
              Ceritakan jumlah tamu, budget, dan gaya acara. AI kami bantu pilihkan paket terbaik dengan cepat.
            </p>
            <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
              <a href="/consultation" class="btn-primary md:w-auto">Konsultasi gratis</a>
              <a href="/packages" class="btn-ghost md:w-auto">Lihat katalog</a>
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

const tickerItems = [
  { text: 'Paket grill premium untuk acara santai' },
  { text: 'Bahan segar dan alat lengkap dalam satu pemesanan' },
  { text: 'Konsultasi gratis untuk bantu pilih paket' },
  { text: 'Pengiriman praktis ke lokasi acara' },
];

const stats = [
  { value: '500+', label: 'pelanggan puas' },
  { value: '50+', label: 'acara selesai' },
  { value: '4.9', label: 'rating layanan' },
];

const features = [
  {
    icon: '🎉',
    title: 'Paket lengkap',
    description: 'Alat, bahan, dan kebutuhan utama acara dirangkum dalam satu paket yang mudah dipilih.',
  },
  {
    icon: '🚚',
    title: 'Antar praktis',
    description: 'Pengiriman dibuat sederhana supaya kamu bisa fokus ke tamu dan jalannya acara.',
  },
  {
    icon: '🤖',
    title: 'Konsultasi paket',
    description: 'Kalau bingung, cukup ceritakan rencana acara dan sistem akan bantu memberi rekomendasi.',
  },
];

const testimonials = [
  {
    text: 'Pesannya gampang, paketnya jelas, dan acara keluarga jadi jauh lebih santai.',
    name: 'Sari Dewi',
    location: 'Palembang',
  },
  {
    text: 'Sudah beberapa kali pakai. Paling suka karena tidak perlu mikir alat dan bahan satu-satu.',
    name: 'Ahmad Fauzi',
    location: 'Palembang',
  },
  {
    text: 'Fitur konsultasi membantu banget waktu saya belum yakin mau ambil paket yang mana.',
    name: 'Rizki Putri',
    location: 'Palembang',
  },
];

function formatPrice(price) {
  return new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0,
  }).format(price);
}

async function fetchPackages() {
  try {
    const res = await fetch('/api/packages');
    const result = await res.json();
    packages.value = result.data.slice(0, 3);
  } catch (err) {
    console.error(err);
  } finally {
    loading.value = false;
  }
}

onMounted(fetchPackages);
</script>
