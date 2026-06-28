@props([
    'tone' => 'neutral',
])

@php
    $toneClasses = [
        'neutral' => 'border-[#e8ddd3] bg-white text-[#1c1b1a]',
        'soft' => 'border-transparent bg-[#fbede4] text-[#1c1b1a]',
        'coral' => 'border-transparent bg-[#fbede4] text-[#f45d48]',
        'success' => 'border-transparent bg-[#d7f0e4] text-[#1e875f]',
    ];

    $classes = $toneClasses[$tone] ?? $toneClasses['neutral'];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-2 rounded-full border px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.08em] {$classes}"]) }}>
    {{ $slot }}
</span>
