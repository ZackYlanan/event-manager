{{-- FRONTEND TEAM MOCK DATA --}}
{{-- This simulates the data the backend controller will eventually provide --}}
@php
    $totalEvents = 42;
    $activeEvents = 5;
    $totalStudents = 1250;
    $totalTickets = 890;

    // Simulating the Eloquent Collection of recent events
    $recentEvents = collect([
        (object) [
            'title' => 'Freshman Tech Orientation',
            'event_date' => '2026-08-15 09:00:00',
            'maximum_slots' => 500,
        ],
        (object) [
            'title' => 'Fall Career Fair',
            'event_date' => '2026-10-10 10:00:00',
            'maximum_slots' => 300,
        ],
        (object) [
            'title' => 'Spring Hackathon',
            'event_date' => '2026-03-22 08:00:00',
            'maximum_slots' => 150,
        ],
    ]);
@endphp

<x-sandbox-layout>
    <div class="min-h-screen bg-[#FFFDF9] font-sans text-gray-900 pb-12">

        <nav
            class="bg-white border-b border-orange-50/60 px-8 py-4 flex items-center justify-between sticky top-0 z-10 shadow-sm">
            <div class="flex items-center gap-2.5">
                <div
                    class="w-8 h-8 rounded-lg bg-gradient-to-tr from-amber-500 to-orange-500 flex items-center justify-center text-white shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
                <span class="text-2xl font-bold tracking-tight text-orange-500">vento</span>
            </div>

            <div class="hidden md:flex items-center gap-2 text-sm font-medium text-gray-500">
                <a href="#" class="px-5 py-2 rounded-full bg-[#FFE8D6] text-orange-700 transition-colors">Home</a>
                <a href="#" class="px-5 py-2 rounded-full hover:bg-gray-50 transition-colors">Events</a>
                <a href="#" class="px-5 py-2 rounded-full hover:bg-gray-50 transition-colors">Attendees</a>
                <a href="#" class="px-5 py-2 rounded-full hover:bg-gray-50 transition-colors">Reports</a>
            </div>

            <div
                class="flex items-center gap-3 pl-4 py-1 pr-1 border border-gray-200 rounded-full bg-white hover:shadow-sm transition-all cursor-pointer">
                <span class="text-sm font-semibold text-gray-700 pl-2">Admin</span>
                <div
                    class="w-8 h-8 rounded-full bg-gradient-to-r from-orange-400 to-orange-500 flex items-center justify-center text-white text-xs font-bold">
                    AD
                </div>
            </div>
        </nav>

        <main class="max-w-[1200px] mx-auto px-6 mt-10">

            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4 mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Admin Dashboard</h1>
                    <p class="text-sm text-gray-500 mt-1">Welcome back. Here's what's happening with your events.</p>
                </div>
                <a href="#"
                    class="py-2.5 px-5 bg-gradient-to-r from-[#F5A623] to-[#FF5722] hover:from-[#e0961f] hover:to-[#e64e1e] text-white font-semibold text-sm rounded-full shadow-lg shadow-orange-500/25 transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Create New Event
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <div
                    class="bg-white rounded-[20px] p-6 border border-orange-50 shadow-sm flex flex-col justify-between">
                    <div class="flex justify-between items-start">
                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Events</span>
                        <div class="p-2 bg-orange-100 text-orange-500 rounded-lg"><svg class="w-4 h-4" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg></div>
                    </div>
                    <div class="mt-4">
                        <h2 class="text-4xl font-extrabold text-gray-900">{{ $totalEvents }}</h2>
                        <p class="text-[11px] text-gray-400 mt-1 uppercase font-medium">across all categories</p>
                    </div>
                </div>

                <div
                    class="bg-white rounded-[20px] p-6 border border-orange-50 shadow-sm flex flex-col justify-between">
                    <div class="flex justify-between items-start">
                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Students</span>
                        <div class="p-2 bg-orange-100 text-orange-500 rounded-lg"><svg class="w-4 h-4" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                                </path>
                            </svg></div>
                    </div>
                    <div class="mt-4">
                        <h2 class="text-4xl font-extrabold text-gray-900">{{ $totalStudents }}</h2>
                        <p class="text-[11px] text-orange-500 mt-1 uppercase font-semibold">registered users</p>
                    </div>
                </div>

                <div
                    class="bg-white rounded-[20px] p-6 border border-orange-50 shadow-sm flex flex-col justify-between">
                    <div class="flex justify-between items-start">
                        <span class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Total Ticket
                            Issued</span>
                        <div class="p-2 bg-orange-100 text-orange-500 rounded-lg"><svg class="w-4 h-4" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg></div>
                    </div>
                    <div class="mt-4">
                        <h2 class="text-4xl font-extrabold text-gray-900">{{ $totalTickets }}</h2>
                        <p class="text-[11px] text-gray-400 mt-1 uppercase font-medium">last 30 days</p>
                    </div>
                </div>
            </div>

            <div class="flex justify-between items-center mb-6">
                <h2 class="text-lg font-bold text-gray-900">Next 3 Events</h2>
                <a href="#"
                    class="text-sm font-semibold text-orange-500 hover:text-orange-600 flex items-center gap-1">
                    See all <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse ($recentEvents as $event)
                    <div class="bg-white border border-gray-100 rounded-[20px] shadow-sm flex flex-col overflow-hidden">
                        <div class="p-5 flex gap-4">
                            <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?ixlib=rb-4.0.3&auto=format&fit=crop&w=200&q=80"
                                alt="Event" class="w-[84px] h-[84px] object-cover rounded-2xl shadow-sm shrink-0" />
                            <div class="flex-1 flex flex-col justify-between">
                                <div>
                                    <div class="flex justify-between items-start">
                                        <h3 class="font-bold text-gray-900 text-sm leading-tight">{{ $event->title }}
                                        </h3>
                                        <span
                                            class="bg-[#FFE8D6] text-orange-700 text-[10px] px-2.5 py-0.5 rounded-full font-bold uppercase tracking-wide">Upcoming</span>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y · h:i A') }}</p>
                                </div>
                                <div class="mt-3">
                                    <div class="flex justify-between text-[10px] font-semibold text-gray-500 mb-1.5">
                                        <span>Slots Capacity</span>
                                        <span class="text-gray-900">{{ $event->maximum_slots }}</span>
                                    </div>
                                    <div class="h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-gradient-to-r from-orange-400 to-orange-500 rounded-full"
                                            style="width: 0%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="border-t border-gray-50 p-2 flex gap-2 bg-gray-50/50">
                            <button
                                class="flex-1 py-2 text-xs font-semibold text-gray-600 hover:bg-white hover:shadow-sm rounded-xl transition-all">Edit</button>
                            <button
                                class="flex-1 py-2 text-xs font-bold text-orange-700 bg-[#FFE8D6] hover:bg-orange-200 rounded-xl transition-all">Attendees</button>
                        </div>
                    </div>
                @empty
                    <div class="col-span-2 py-10 text-center text-gray-500 text-sm font-medium">
                        No upcoming events scheduled.
                    </div>
                @endforelse
            </div>

        </main>
    </div>
</x-sandbox-layout>
