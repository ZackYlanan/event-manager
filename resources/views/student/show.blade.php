<x-app-layout>

    <div class="relative w-full h-64 md:h-96 bg-gray-900 overflow-hidden">
        <div class="absolute inset-0 {{ $event->cover_gradient }}"></div>

        <div class="absolute inset-0 bg-gradient-to-b from-black/30 via-transparent to-[#FAFAFA]"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-24 md:-mt-32 pb-24">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 md:gap-12">

            <div class="lg:col-span-2 pt-8">

                <span
                    class="inline-block px-3 py-1 bg-[#FF7A00] text-white text-xs font-bold uppercase tracking-wider rounded-full mb-4 shadow-sm">
                    {{ $event->category->display_name ?? 'General' }}
                </span>

                <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 tracking-tight mb-6">
                    {{ $event->title }}
                </h1>

                <div class="flex flex-wrap items-center gap-y-3 gap-x-6 text-sm text-gray-600 font-medium mb-10">
                    <div class="flex items-center text-[#FF7A00]">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        {{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}
                    </div>

                    <div class="flex items-center text-[#FF7A00]">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ \Carbon\Carbon::parse($event->event_date)->format('h:i A') }}
                    </div>

                    <div class="flex items-center text-[#FF7A00]">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                        {{ $event->venue }}
                    </div>
                </div>

                <div class="prose prose-orange max-w-none text-gray-600">
                    <h3 class="text-xl font-bold text-gray-900 mb-4">About this event</h3>
                    <p class="whitespace-pre-line leading-relaxed">
                        {{ $event->description }}
                    </p>
                </div>

            </div>

            <div class="lg:col-span-1 mt-8 lg:mt-0">

                <div
                    class="sticky top-24 bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.08)] border border-gray-100 p-6 md:p-8">

                    @php
                        $percentage =
                            $event->maximum_slots > 0
                                ? min(100, ($event->registrations_count / $event->maximum_slots) * 100)
                                : 0;
                    @endphp

                    <div class="flex items-center justify-between text-sm font-semibold text-gray-700 mb-2">
                        <div class="flex items-center">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                </path>
                            </svg>
                            Spots filled
                        </div>
                        <div>{{ $event->registrations_count }} / {{ $event->maximum_slots }}</div>
                    </div>

                    <div class="w-full h-2 bg-orange-100 rounded-full mb-6 overflow-hidden">
                        <div class="h-full bg-[#FF7A00] rounded-full transition-all duration-500"
                            style="width: {{ $percentage }}%;"></div>
                    </div>

                    <div class="bg-[#FFF5E6] rounded-xl p-4 text-center mb-6">
                        <p class="text-[10px] font-bold text-gray-500 uppercase tracking-widest mb-1">Free Entry</p>
                        <p class="text-3xl font-black text-[#FF7A00]">FREE</p>
                    </div>

                    @if ($event->registrations_count >= $event->maximum_slots)
                        <button disabled
                            class="w-full bg-gray-300 text-gray-500 font-bold py-3.5 px-4 rounded-xl cursor-not-allowed">
                            Event is Full
                        </button>
                    @else
                        <form method="POST" action="{{ route('events.register', $event->id) }}">
                            @csrf
                            <button type="submit"
                                class="w-full bg-[#FF7A00] hover:bg-orange-600 text-white font-bold py-3.5 px-4 rounded-xl transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                Register now
                            </button>
                        </form>
                    @endif

                    <p class="text-xs text-center text-gray-400 mt-4 font-medium">
                        Instant confirmation. Free cancellation.
                    </p>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
