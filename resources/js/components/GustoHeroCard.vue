<template>
  <div class="hero-card overflow-hidden px-5 py-6 md:px-7 md:py-8">
    <div v-if="label" class="section-label mb-4">{{ label }}</div>
    <slot />
  </div>
</template>

<script setup>
defineProps({
  label: {
    type: String,
    default: '',
  },
});
</script>
