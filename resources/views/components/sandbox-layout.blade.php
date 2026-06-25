<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Frontend Sandbox</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,900&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased text-black bg-gray-100">
    <div class="min-h-screen">
        {{-- SANDBOX NAVIGATION (SAFE FOR FRONTEND)     --}}

        @php
            // FRONTEND DEVELOPERS: Change this to 'student' to test the student menu!
            $mockRole = 'admin';
            $mockName = 'Sandbox Developer';
            $mockEmail = 'dev@sandbox.local';
        @endphp

        <nav x-data="{ open: false }" class="bg-white border-b-4 border-black">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex">

                        <div class="shrink-0 flex items-center">
                            <div class="font-black text-xl tracking-widest uppercase bg-black text-white px-2 py-1">
                                Vento
                            </div>
                        </div>

                        <div
                            class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex items-center font-bold uppercase text-sm">

                            @if ($mockRole === 'admin')
                                <a href="#" class="text-gray-500 hover:text-black py-5 transition-colors">Admin
                                    Dashboard</a>
                                <a href="#" class="text-gray-500 hover:text-black py-5 transition-colors">🛡️
                                    Manage Events</a>
                                <a href="#" class="text-gray-500 hover:text-black py-5 transition-colors">+ Create
                                    Event</a>
                                <a href="#" class="text-gray-500 hover:text-black py-5 transition-colors">🎟️
                                    Check-In</a>
                            @endif

                            @if ($mockRole === 'student')
                                <a href="#" class="text-black border-b-4 border-black py-5">🎓 Event Directory</a>
                                <a href="#" class="text-gray-500 hover:text-black py-5 transition-colors">My
                                    Tickets</a>
                            @endif

                        </div>
                    </div>

                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <div class="relative" x-data="{ dropdownOpen: false }">
                            <button @click="dropdownOpen = !dropdownOpen"
                                class="inline-flex items-center px-3 py-2 border-2 border-black text-sm font-bold uppercase hover:bg-black hover:text-white transition-colors">
                                <div>{{ $mockName }} ({{ $mockRole }})</div>
                                <div class="ms-1">▼</div>
                            </button>

                            <div x-show="dropdownOpen" @click.away="dropdownOpen = false"
                                class="absolute right-0 mt-2 w-48 bg-white border-2 border-black shadow-[4px_4px_0px_0px_rgba(0,0,0,1)]"
                                style="display: none;">
                                <a href="#"
                                    class="block px-4 py-2 text-sm font-bold hover:bg-gray-200">Profile</a>
                                <a href="#"
                                    class="block px-4 py-2 text-sm font-bold text-red-600 hover:bg-gray-200">Log Out</a>
                            </div>
                        </div>
                    </div>

                    <div class="-me-2 flex items-center sm:hidden">
                        <button @click="open = ! open"
                            class="inline-flex items-center justify-center p-2 text-black hover:bg-gray-200 focus:outline-none transition">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                                    stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div :class="{ 'block': open, 'hidden': !open }"
                class="hidden sm:hidden bg-gray-50 border-t-2 border-black">
                <div class="pt-2 pb-3 space-y-1 px-4 font-bold uppercase text-sm">
                    @if ($mockRole === 'admin')
                        <a href="#" class="block py-2 text-black border-l-4 border-black pl-2">Dashboard</a>
                        <a href="#" class="block py-2 text-gray-600 hover:text-black">🛡️ Manage Events</a>
                        <a href="#" class="block py-2 text-gray-600 hover:text-black">+ Create Event</a>
                    @endif

                    @if ($mockRole === 'student')
                        <a href="#" class="block py-2 text-black border-l-4 border-black pl-2">🎓 Event
                            Directory</a>
                        <a href="#" class="block py-2 text-gray-600 hover:text-black">My Tickets</a>
                    @endif
                </div>
            </div>
        </nav>

        @isset($header)
            <header class="bg-white border-b-4 border-black">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <main>
            {{ $slot }}
        </main>

    </div>
</body>

</html>
