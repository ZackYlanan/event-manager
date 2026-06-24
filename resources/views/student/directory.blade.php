<x-app-layout>
    <div class="bg-gradient-to-b from-[#FFF5E6] to-[#FAFAFA] pt-12 pb-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-6">
                <h1 class="text-4xl font-extrabold text-[#2A2321] tracking-tight">Browse events</h1>
                <p class="text-gray-500 mt-2 text-sm">{{ $events->count() }} events found</p>
            </div>

            {{--  Category fillering --}}
            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('events.directory') }}"
                    class="px-6 py-2 rounded-full text-sm font-medium transition-colors shadow-sm {{ !request('category') ? 'bg-[#FF7A00] text-white hover:bg-orange-600' : 'bg-white text-gray-600 hover:bg-orange-50 hover:text-orange-600' }}">
                    All
                </a>

                @foreach ($categories as $category)
                    <a href="{{ route('events.directory', ['category' => $category->id]) }}"
                        class="px-6 py-2 rounded-full text-sm font-medium transition-colors shadow-sm {{ request('category') == $category->id ? 'bg-[#FF7A00] text-white hover:bg-orange-600' : 'bg-white text-gray-600 hover:bg-orange-50 hover:text-orange-600' }}">
                        {{ $category->display_name }}
                    </a>
                @endforeach
            </div>

        </div>
    </div>

    <div class="bg-[#FAFAFA] pb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
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
                        class="col-span-1 md:col-span-2 lg:col-span-3 text-center py-16 bg-white rounded-2xl border border-gray-200 shadow-sm">
                        <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                        <p class="text-gray-500 font-medium mt-4">No upcoming events are currently published.</p>
                    </div>
                @endforelse

            </div>
        </div>
    </div>
</x-app-layout>
