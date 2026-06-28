<template>
  <div :class="wrapperClasses">
    <div class="info-banner__icon">{{ icon }}</div>
    <div>
      <div class="text-sm font-semibold text-[#1c1b1a]">{{ title }}</div>
      <p class="mt-1 text-sm leading-6 text-[#5c5854]">{{ description }}</p>
      <slot />
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue';

const props = defineProps({
  icon: {
    type: String,
    default: 'i',
  },
  title: {
    type: String,
    required: true,
  },
  description: {
    type: String,
    required: true,
  },
  tone: {
    type: String,
    default: 'soft',
  },
});

const toneMap = {
  soft: 'info-banner info-banner--soft',
  success: 'info-banner info-banner--success',
  plain: 'info-banner',
};

const wrapperClasses = computed(() => toneMap[props.tone] ?? toneMap.soft);
</script>
