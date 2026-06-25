<x-app-layout>
    <div class="relative w-full min-h-[75vh] flex items-center bg-[#FFFBF4] overflow-hidden">

        <div
            class="absolute top-[-15%] right-[-5%] w-[600px] h-[600px] bg-[#FFDAB9] rounded-full mix-blend-multiply opacity-50 blur-[120px] pointer-events-none">
        </div>
        <div
            class="absolute bottom-[-10%] left-[-5%] w-[500px] h-[500px] bg-[#FFDAB9] rounded-full mix-blend-multiply opacity-50 blur-[120px] pointer-events-none">
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8 w-full pt-20 pb-24">

            <div class="max-w-3xl">

                <div
                    class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white border border-gray-100 shadow-sm mb-8">
                    <svg class="w-3.5 h-3.5 text-[#FF6B00]" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 0L14.59 9.41L24 12L14.59 14.59L12 24L9.41 14.59L0 12L9.41 9.41L12 0Z" />
                    </svg>
                    <span class="text-xs font-medium text-gray-500 tracking-wide">The easiest way to run events</span>
                </div>

                <h1 class="text-6xl md:text-[5rem] font-bold text-[#1A1A1A] tracking-tight leading-[1.05] mb-8">
                    Events worth <br class="hidden sm:block">
                    <span class="bg-gradient-to-r from-[#FF8A00] to-[#FF3D00] bg-clip-text text-transparent">showing <br
                            class="hidden sm:block"> up</span> for.
                </h1>

                <p class="text-lg text-gray-500 max-w-xl mb-10 leading-relaxed">
                    Discover hackathons, seminars, and workshops near you. Register in seconds and keep your tickets in
                    one place.
                </p>

                <a href="{{ route('events.directory') }}"
                    class="inline-block px-8 py-3.5 rounded-full text-white font-medium text-sm transition-all duration-300 hover:scale-[1.03] active:scale-95 bg-gradient-to-r from-[#FF8A00] to-[#FF4500] shadow-[0_8px_20px_-6px_rgba(255,69,0,0.6)] hover:shadow-[0_12px_25px_-6px_rgba(255,69,0,0.7)]">
                    Browse events
                </a>

            </div>
        </div>
    </div>

    <div id="event-directory" class="bg-white py-16 md:py-24">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            <div class="flex items-end justify-between mb-8 md:mb-10">
                <div>
                    <h2 class="text-3xl font-bold text-[#1A1A1A] tracking-tight">Happening soon</h2>
                    <p class="text-gray-500 mt-2 text-sm md:text-base">Don't miss what's coming up.</p>
                </div>
                <a href="{{ route('events.directory') }}"
                    class="text-[#FF8A00] font-medium text-sm hover:text-[#FF4500] flex items-center gap-1 transition-colors">
                    See all <span aria-hidden="true">&rarr;</span>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

                @forelse($events as $event)
                    <a href="{{ route('events.show', $event->id) }}"
                        class="group bg-white border border-gray-100 rounded-2xl overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 flex flex-col cursor-pointer shadow-sm">

                        <div class="relative h-48 w-full bg-gray-50 border-b border-gray-100">
                            <div
                                class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-xs font-semibold text-gray-700 shadow-sm z-10">
                                {{ $event->category->display_name ?? 'General' }}
                            </div>

                            <div class="w-full h-full {{ $event->cover_gradient }}">
                            </div>
                        </div>

                        <div class="p-5 flex flex-col flex-grow">
                            <h3
                                class="text-lg font-bold text-gray-900 mb-3 group-hover:text-[#FF7A00] transition-colors line-clamp-1">
                                {{ $event->title }}
                            </h3>

                            <div class="space-y-2 mb-6">
                                <div class="flex items-center text-sm text-gray-500">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    {{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}
                                </div>

                                <div class="flex items-center text-sm text-gray-500">
                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span class="truncate">{{ $event->venue }}</span>
                                </div>
                            </div>

                            <div class="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between">
                                <div class="flex items-center text-sm text-gray-500">
                                    <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                        </path>
                                    </svg>
                                    {{ $event->registrations_count }}/{{ $event->maximum_slots }}
                                </div>

                                <span
                                    class="text-[#FF7A00] font-medium text-sm flex items-center group-hover:text-orange-600">
                                    View
                                    <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </a>
                @empty
                    <div
                        class="col-span-full py-12 text-center bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                        <p class="text-gray-500 font-medium">No upcoming events right now. Check back soon!</p>
                    </div>
                @endforelse

            </div>
        </div>
    </div>
</x-app-layout>
