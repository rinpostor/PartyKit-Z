<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="PartyKit'Z - Solusi sewa alat pesta, grill, dan steak lengkap untuk acara spesialmu. Pesan online, antar ke depan pintu.">
    <meta name="theme-color" content="#FFF7F0">
    <title>@yield('title', "PartyKit'Z") | PartyKit'Z</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body>
    <div id="vue-navbar"></div>

    <main class="min-h-screen w-full page-shell pt-20">
        @yield('content')
    </main>

    <footer class="border-t border-[#e8ddd3] bg-[#fbede4]">
        <div class="container mx-auto px-4 py-12 md:px-6">
            <div class="grid gap-10 border-b border-[#e8ddd3] pb-10 md:grid-cols-2 lg:grid-cols-4">
                <div class="lg:col-span-2">
                    <div class="mb-4 flex items-center gap-3">
                        <img src="/images/logo.png" alt="PartyKit'Z" class="h-12 w-auto rounded-xl object-contain">
                        <div>
                            <div class="text-base font-semibold text-[#1c1b1a]">PartyKit'Z</div>
                            <div class="text-sm text-[#5c5854]">Paket pesta rumahan yang rapi dan praktis</div>
                        </div>
                    </div>
                    <p class="max-w-md text-sm leading-6 text-[#5c5854]">
                        Solusi lengkap untuk grill, steak, dan acara santai di rumah. Pilih paket, konsultasikan kebutuhan, lalu tim kami bantu kirim sampai lokasi.
                    </p>
                </div>

                <div>
                    <h4 class="mb-4 text-sm font-semibold text-[#1c1b1a]">Navigasi</h4>
                    <ul class="space-y-3 text-sm text-[#5c5854]">
                        @foreach ([['/', 'Home'], ['/packages', 'Katalog Paket'], ['/about', 'Tentang Kami'], ['/consultation', 'Konsultasi Paket']] as [$href, $label])
                        <li><a href="{{ $href }}" class="hover:text-[#1c1b1a] hover:underline">{{ $label }}</a></li>
                        @endforeach
                    </ul>
                </div>

                <div>
                    <h4 class="mb-4 text-sm font-semibold text-[#1c1b1a]">Kontak</h4>
                    <ul class="space-y-3 text-sm text-[#5c5854]">
                        <li><a href="https://wa.me/6281200000000" class="hover:text-[#1c1b1a] hover:underline">WhatsApp: 0812-xxxx-xxxx</a></li>
                        <li><a href="mailto:partykitz2025@gmail.com" class="hover:text-[#1c1b1a] hover:underline">partykitz2025@gmail.com</a></li>
                        <li>Palembang, Sumatera Selatan</li>
                    </ul>
                </div>
            </div>

            <div class="flex flex-col gap-3 pt-6 text-sm text-[#5c5854] md:flex-row md:items-center md:justify-between">
                <p>&copy; {{ date('Y') }} PartyKit'Z. Semua hak dilindungi.</p>
                <p>Tampilan dirancang lebih ringan, rapi, dan mudah dijelajahi.</p>
            </div>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
