<template>
  <div>
    <section class="page-section">
      <div class="container mx-auto px-4 md:px-6">
        <div class="mb-6 text-sm text-[#5c5854] md:mb-8">
          <a href="/" class="hover:underline">Home</a>
          <span class="mx-2">›</span>
          <span class="text-[#1c1b1a]">Tentang Kami</span>
        </div>

        <div class="grid items-center gap-8 lg:grid-cols-[0.9fr_1.1fr] lg:gap-10">
          <div>
            <img
              src="https://images.unsplash.com/photo-1529193591184-b1d58069ecdd?q=80&w=800&auto=format&fit=crop"
              alt="Party moment"
              class="h-[340px] w-full rounded-[28px] object-cover sm:h-[420px] lg:h-[500px]"
            />
          </div>

          <GustoHeroCard label="Cerita kami">
            <div class="flex flex-wrap gap-3">
              <GustoStatusPill tone="success">Tim kecil, layanan personal</GustoStatusPill>
            </div>
            <h1 class="page-title mt-5">
              Membantu acara rumahan terasa lebih ringan dan terorganisir.
            </h1>
            <p class="section-copy mt-5">
              PartyKit'Z lahir dari kebutuhan yang sederhana: banyak orang ingin mengadakan acara di rumah tanpa repot menyiapkan alat, bahan, dan detail kecil satu per satu.
            </p>
            <p class="mt-4 text-sm leading-7 text-[#5c5854] md:text-base md:leading-8">
              Karena itu kami membuat layanan yang lebih praktis. Pengguna cukup memilih paket, menyesuaikan kebutuhan, lalu membiarkan tim kami membantu proses persiapan dasar agar acara berjalan lebih nyaman.
            </p>

            <div class="mt-8 grid gap-4 sm:grid-cols-2">
              <div v-for="stat in stats" :key="stat.label" class="card-premium p-5">
                <div class="kpi-value">{{ stat.value }}</div>
                <div class="kpi-label">{{ stat.label }}</div>
              </div>
            </div>

            <div class="mt-8">
              <a href="/packages" class="btn-primary md:w-auto">Lihat paket kami</a>
            </div>
          </GustoHeroCard>
        </div>
      </div>
    </section>

    <section class="page-section page-section-soft">
      <div class="container mx-auto px-4 md:px-6">
        <div class="mb-8 text-center md:mb-10">
          <div class="section-label mb-4">Keunggulan</div>
          <h2 class="section-title">Kenapa pelanggan memilih PartyKit'Z</h2>
        </div>

        <div class="grid gap-5 md:grid-cols-3 md:gap-6">
          <div v-for="value in values" :key="value.title" class="card-premium p-5 text-center md:p-6">
            <div class="mx-auto mb-4 inline-flex h-14 w-14 items-center justify-center rounded-full bg-[#fbede4] text-2xl">{{ value.icon }}</div>
            <h3 class="text-lg font-semibold text-[#1c1b1a] md:text-xl">{{ value.title }}</h3>
            <p class="mt-3 text-sm leading-6 text-[#5c5854]">{{ value.description }}</p>
          </div>
        </div>
      </div>
    </section>

    <section class="page-section">
      <div class="container mx-auto px-4 md:px-6 text-center">
        <div class="section-label mb-4">Tim</div>
        <h2 class="section-title">Orang di balik layanan</h2>
        <p class="mx-auto mt-4 max-w-2xl section-copy">
          Tim kecil yang fokus pada pengalaman pelanggan, kualitas paket, dan layanan yang mudah dipahami.
        </p>

        <div class="mt-8 grid gap-5 md:mt-10 md:grid-cols-3 md:gap-6">
          <div v-for="member in team" :key="member.name" class="card-premium p-6 md:p-8">
            <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-[#fbede4] text-4xl">{{ member.avatar }}</div>
            <div class="mt-5 text-sm font-semibold uppercase tracking-wide text-[#5c5854]">{{ member.role }}</div>
            <h3 class="mt-2 text-lg font-semibold text-[#1c1b1a] md:text-xl">{{ member.name }}</h3>
            <p class="mt-3 text-sm leading-6 text-[#5c5854]">{{ member.bio }}</p>
          </div>
        </div>
      </div>
    </section>

    <section class="page-section page-section-soft">
      <div class="container mx-auto px-4 md:px-6">
        <div class="section-grid items-start">
          <GustoInfoBanner
            icon="✓"
            title="Layanan disusun supaya tidak bikin bingung"
            description="Kami jaga agar bahasa, pilihan paket, dan langkah pemesanan tetap mudah dipahami untuk pengguna baru."
          />
          <GustoInfoBanner
            icon="✨"
            tone="success"
            title="Fokus pada pengalaman yang terasa ringan"
            description="Bukan sekadar menjual paket, tapi membantu proses persiapan acara terasa lebih aman dan terarah."
          />
        </div>

        <div class="mt-8">
          <GustoHeroCard label="Mulai dari sini">
            <div class="text-center">
              <h2 class="section-title">Siap pilih paket untuk acara berikutnya?</h2>
              <p class="mx-auto mt-4 max-w-2xl section-copy">
                Lihat katalog atau konsultasikan kebutuhan acara kamu lebih dulu agar pilihan paket lebih tepat.
              </p>
              <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
                <a href="/packages" class="btn-primary md:w-auto">Lihat semua paket</a>
                <a href="/consultation" class="btn-ghost md:w-auto">Konsultasi Paket</a>
              </div>
            </div>
          </GustoHeroCard>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import GustoHeroCard from '../components/GustoHeroCard.vue';
import GustoInfoBanner from '../components/GustoInfoBanner.vue';
import GustoStatusPill from '../components/GustoStatusPill.vue';

const stats = [
  { value: '500+', label: 'pelanggan happy' },
  { value: '50+', label: 'event sukses' },
  { value: '4.9★', label: 'rating kepuasan' },
  { value: '3+', label: 'tahun pengalaman' },
];

const values = [
  {
    icon: '✨',
    title: 'Paket lebih rapi',
    description: 'Kebutuhan acara dirangkum agar pelanggan tidak perlu menyusun semuanya dari nol.',
  },
  {
    icon: '🥩',
    title: 'Bahan terpilih',
    description: 'Paket makanan dirancang dengan fokus pada kualitas bahan dan kemudahan penyajian.',
  },
  {
    icon: '🚚',
    title: 'Proses praktis',
    description: 'Mulai dari memilih paket sampai pengantaran dibuat sesederhana mungkin untuk pengguna.',
  },
];

const team = [
  {
    name: 'Rizky Pratama',
    role: 'Founder',
    avatar: '👨‍🍳',
    bio: 'Fokus pada konsep layanan yang membuat acara rumahan jadi lebih mudah dijalankan.',
  },
  {
    name: 'Siti Rahma',
    role: 'Operations',
    avatar: '👩‍💼',
    bio: 'Menjaga alur pesanan dan pengalaman pelanggan tetap rapi dari awal sampai akhir.',
  },
  {
    name: 'Budi Santoso',
    role: 'Menu consultant',
    avatar: '👨‍🍳',
    bio: 'Membantu memastikan pilihan paket terasa pas untuk berbagai jenis acara santai.',
  },
];
</script>
