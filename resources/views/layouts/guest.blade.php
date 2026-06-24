<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div
        class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-[#FFFDF9] via-[#FFF5EB] to-[#FFE8D6] p-4">

        <div
            class="w-full max-w-[420px] bg-white rounded-[28px] p-8 sm:p-10 shadow-[0_10px_40px_rgba(0,0,0,0.05)] border border-orange-50/60">

            <!-- Logo Section -->
            <div class="flex flex-col items-center mb-6">
                <a href="/" class="flex items-center gap-2.5 mb-3">
                    <x-application-logo class="w-auto h-8" />
                </a>
                @if (isset($header))
                    {{ $header }}
                @endif
            </div>

            {{ $slot }}
        </div>

    </div>
</body>

</html>
