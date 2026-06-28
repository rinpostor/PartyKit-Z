@props([
    'title',
    'description' => null,
])

<div {{ $attributes->merge(['class' => 'rounded-[20px] bg-[#fbede4] p-4']) }}>
    <div class="text-sm font-semibold text-[#1c1b1a]">{{ $title }}</div>
    @if(trim($slot) !== '')
        {{ $slot }}
    @elseif($description)
        <p class="mt-2 text-sm leading-6 text-[#5c5854]">{{ $description }}</p>
    @endif
</div>
