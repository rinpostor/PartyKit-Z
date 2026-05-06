<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PartyKit'Z</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white font-sans text-gray-900 antialiased flex flex-col min-h-screen">

    <nav class="sticky top-0 z-30 bg-white/50 backdrop-blur-md shadow-sm border-b border-gray-100 w-full">
    <div class="container mx-auto px-5 py-3 flex justify-between items-center">
        <a href="/" class="text-xl font-bold flex items-center">
            <img src="/images/logo.png" alt="Logo PartyKit'Z" class="h-16 w-auto">
        </a>
        
        <div class="hidden md:flex space-x-8 font-medium text-gray-600">
            <a href="/" class="hover:text-blue-600 transition">Home</a>
            <a href="/packages" class="hover:text-blue-600 transition">Pilihan Paket</a>
            <a href="/about" class="hover:text-blue-600 transition">About Us</a>
            <a href="{{ route('consultation') }}" class="hover:text-blue-600 transition font-medium">Konsultasi AI</a>
        </div>

        <a href="/packages" class="bg-blue-600 text-white px-5 py-2 rounded-full hover:bg-blue-700 transition shadow-lg shadow-blue-600/30 font-medium">
            Pesan Sekarang
        </a>
    </div>
</nav>

    <main class="flex-grow w-full">
        @yield('content')  
    </main>

    <footer class="bg-gray-900 text-white py-8 w-full mt-auto">
        <div class="container mx-auto px-4 text-center">
            <p class="text-gray-400 text-sm">&copy; 2025 PartyKit'Z Official. All Rights Reserved.</p>
        </div>
    </footer>

</body>
</html>