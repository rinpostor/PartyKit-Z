<template>
  <nav class="fixed top-0 left-0 right-0 z-50 px-4 pt-4 md:px-6">
    <div class="container mx-auto">
      <div class="hero-card border border-[#e8ddd3]/80 bg-white/90 px-4 py-3 backdrop-blur-md md:px-6">
        <div class="flex items-center justify-between gap-4">
          <a href="/" class="flex items-center gap-3" id="nav-logo">
            <img src="/images/logo.png" alt="PartyKit'Z" class="h-11 w-auto rounded-2xl object-contain" />
            <div>
              <div class="text-[15px] font-semibold text-[#1c1b1a]">PartyKit'Z</div>
              <div class="text-xs text-[#5c5854]">Paket pesta rumahan yang rapi dan terasa ringan</div>
            </div>
          </a>

          <div class="hidden xl:flex items-center gap-3" id="nav-links">
            <div class="surface-pill flex items-center gap-2 px-2 py-2">
              <a
                v-for="link in navLinks"
                :key="link.href"
                :href="link.href"
                :class="[
                  'px-4 py-2 text-sm font-semibold rounded-full transition-all duration-200',
                  isActive(link.href)
                    ? 'bg-[#fbede4] text-[#1c1b1a]'
                    : 'text-[#5c5854] hover:bg-[#fbede4] hover:text-[#1c1b1a]'
                ]"
              >
                {{ link.label }}
              </a>
            </div>
          </div>

          <div class="hidden md:flex items-center gap-3" id="nav-cta">
            <a href="/packages" id="nav-cta-btn" class="btn-primary text-sm px-5">Lihat katalog</a>
          </div>

          <button
            @click="mobileOpen = !mobileOpen"
            class="md:hidden inline-flex h-11 w-11 items-center justify-center rounded-full border border-[#e8ddd3] bg-white text-[#1c1b1a]"
            aria-label="Toggle menu"
            id="nav-hamburger"
          >
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
          </button>
        </div>

        <div v-if="mobileOpen" class="md:hidden pt-4" id="mobile-menu">
          <div class="rounded-[20px] border border-[#e8ddd3] bg-white p-4 shadow-[0_12px_24px_rgba(0,0,0,0.08)]">
            <div class="space-y-2">
              <a
                v-for="link in navLinks"
                :key="link.href"
                :href="link.href"
                :class="[
                  'block rounded-2xl px-4 py-3 text-sm font-semibold',
                  isActive(link.href)
                    ? 'bg-[#fbede4] text-[#1c1b1a]'
                    : 'text-[#5c5854]'
                ]"
                @click="mobileOpen = false"
              >
                {{ link.label }}
              </a>
            </div>
            <div class="mt-4 grid gap-2">
              <a href="/packages" class="btn-primary w-full" @click="mobileOpen = false">Lihat katalog</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </nav>
</template>

<script setup>
import { ref } from 'vue';

const mobileOpen = ref(false);

const navLinks = [
  { href: '/', label: 'Beranda' },
  { href: '/packages', label: 'Katalog Paket' },
  { href: '/about', label: 'Tentang Kami' },
  { href: '/consultation', label: 'Konsultasi Paket' },
];

function isActive(href) {
  if (href === '/') return window.location.pathname === '/';
  return window.location.pathname.startsWith(href);
}
</script>
