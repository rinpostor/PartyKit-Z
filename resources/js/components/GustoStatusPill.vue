<template>
  <span :class="classes">
    <slot />
  </span>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  tone: {
    type: String,
    default: 'neutral',
  },
});

const toneMap = {
  neutral: 'bg-white text-[#1c1b1a] border-[#e8ddd3]',
  success: 'bg-[#d7f0e4] text-[#1e875f] border-transparent',
  coral: 'bg-[#fbede4] text-[#f45d48] border-transparent',
};

const classes = computed(() => [
  'inline-flex items-center gap-2 rounded-full border px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.08em]',
  toneMap[props.tone] ?? toneMap.neutral,
]);
</script>
