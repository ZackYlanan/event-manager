<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 - Page Not Found</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body
    class="font-sans antialiased bg-[#FFF9F2] text-gray-900 min-h-screen flex flex-col items-center justify-center selection:bg-orange-500 selection:text-white">
    <div
        class="w-full max-w-2xl px-6 py-12 bg-white shadow-2xl rounded-3xl text-center border border-orange-50 relative overflow-hidden">

        <!-- Decorative Background Elements -->
        <div class="absolute -top-24 -right-24 w-48 h-48 bg-orange-100 rounded-full opacity-50 blur-3xl"></div>
        <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-[#FFE8D6] rounded-full opacity-50 blur-3xl"></div>

        <div class="relative z-10">
            <!-- 404 Text -->
            <h1
                class="text-9xl font-black text-transparent bg-clip-text bg-gradient-to-br from-[#FF7A00] to-orange-400 tracking-tighter drop-shadow-sm">
                404
            </h1>

            <h2 class="mt-4 text-3xl font-extrabold tracking-tight sm:text-4xl">
                Oops! Page not found.
            </h2>

            <p class="mt-4 text-base text-gray-500 max-w-md mx-auto">
                We couldn't find the page you're looking for. It might have been removed, renamed, or didn't exist in
                the first place.
            </p>

            <div class="mt-10 flex justify-center">
                @if (auth()->check() && auth()->user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}"
                        class="inline-flex items-center justify-center px-8 py-3.5 text-sm font-bold text-white transition-all bg-[#FF7A00] rounded-full hover:bg-orange-600 shadow-md hover:shadow-lg uppercase tracking-wider transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Return to Dashboard
                    </a>
                @else
                    <a href="{{ route('events.directory') }}"
                        class="inline-flex items-center justify-center px-8 py-3.5 text-sm font-bold text-white transition-all bg-[#FF7A00] rounded-full hover:bg-orange-600 shadow-md hover:shadow-lg uppercase tracking-wider transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5 mr-2 -ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Browse Events
                    </a>
                @endif
            </div>
        </div>
    </div>
</body>

</html>
