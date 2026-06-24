<nav x-data="{ open: false }" class="bg-white border-b border-orange-50/60 sticky top-0 z-10 shadow-sm">
    <div class="px-4 md:px-8 py-4 flex items-center justify-between w-full">
        <!-- Logo -->
        <div class="flex items-center gap-2.5">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5">
                <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
            </a>
        </div>

        <!-- Desktop Navigation Links -->
        <div class="hidden md:flex items-center gap-2 text-sm font-medium text-gray-500">
            @if (Auth::user()->role === 'admin')
                <a href="{{ route('admin.dashboard') }}"
                    class="px-5 py-2 rounded-full transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-[#FFE8D6] text-orange-700' : 'hover:bg-gray-50' }}">Home</a>
                <a href="{{ route('events.index') }}"
                    class="px-5 py-2 rounded-full transition-colors {{ request()->routeIs('events.index') ? 'bg-[#FFE8D6] text-orange-700' : 'hover:bg-gray-50' }}">Events</a>
                <a href="{{ route('events.create') }}"
                    class="px-5 py-2 rounded-full transition-colors {{ request()->routeIs('events.create') ? 'bg-[#FFE8D6] text-orange-700' : 'hover:bg-gray-50' }}">Create
                    Event</a>
                <a href="{{ route('admin.checkin') }}"
                    class="px-5 py-2 rounded-full transition-colors {{ request()->routeIs('admin.checkin') ? 'bg-[#FFE8D6] text-orange-700' : 'hover:bg-gray-50' }}">Attendance</a>
            @endif

            @if (Auth::user()->role === 'student')
                <a href="{{ route('events.directory') }}"
                    class="px-5 py-2 rounded-full transition-colors {{ request()->routeIs('events.directory') ? 'bg-[#FFE8D6] text-orange-700' : 'hover:bg-gray-50' }}">Event
                    Directory</a>
                <a href="{{ route('tickets.index') }}"
                    class="px-5 py-2 rounded-full transition-colors {{ request()->routeIs('tickets.index') ? 'bg-[#FFE8D6] text-orange-700' : 'hover:bg-gray-50' }}">My
                    Tickets</a>
            @endif
        </div>

        <!-- Settings Dropdown -->
        <div class="hidden md:flex items-center">
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button
                        class="flex items-center gap-3 pl-1 py-1 pr-4 border border-gray-200 rounded-full bg-white hover:shadow-sm transition-all cursor-pointer focus:outline-none">
                        @php
                            $initials = collect(explode(' ', Auth::user()->name))
                                ->map(fn($segment) => substr($segment, 0, 1))
                                ->take(2)
                                ->join('');
                        @endphp
                        <div
                            class="w-8 h-8 rounded-full bg-[#FF7A00] flex items-center justify-center text-white text-xs font-bold uppercase">
                            {{ $initials }}
                        </div>
                        <span
                            class="text-sm font-semibold text-gray-700 pr-2 capitalize">{{ Auth::user()->role }}</span>
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')">
                        {{ __('Profile') }}
                    </x-dropdown-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>

        <!-- Hamburger -->
        <div class="-me-2 flex items-center md:hidden">
            <button @click="open = ! open"
                class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                        stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden md:hidden border-t border-gray-100 bg-white">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @if (Auth::user()->role === 'admin')
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    Home
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('events.index')" :active="request()->routeIs('events.index')">
                    Events
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('events.create')" :active="request()->routeIs('events.create')">
                    Create Event
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.checkin')" :active="request()->routeIs('admin.checkin')">
                    Check-In
                </x-responsive-nav-link>
            @endif

            @if (Auth::user()->role === 'student')
                <x-responsive-nav-link :href="route('events.directory')" :active="request()->routeIs('events.directory')">
                    Event Directory
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('tickets.index')" :active="request()->routeIs('tickets.index')">
                    My Tickets
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4 flex items-center gap-3">
                @php
                    $initials = collect(explode(' ', Auth::user()->name))
                        ->map(fn($segment) => substr($segment, 0, 1))
                        ->take(2)
                        ->join('');
                @endphp
                <div
                    class="w-10 h-10 rounded-full bg-[#FF7A00] flex items-center justify-center text-white text-sm font-bold uppercase">
                    {{ $initials }}
                </div>
                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
