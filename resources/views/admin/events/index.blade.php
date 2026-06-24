<x-app-layout>
    <div class="min-h-screen bg-[#FFFDF9] font-sans text-gray-900 pb-12">
        <div class="max-w-[1100px] mx-auto px-6 pt-10">

            @if (session('success'))
                <div
                    class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm font-medium flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4 mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Events</h1>
                    <p class="text-sm text-gray-500 mt-1">Manage all your events in one place.</p>
                </div>
                <a href="{{ route('events.create') }}"
                    class="py-2.5 px-5 bg-[#FF7A00] hover:bg-orange-600 text-white font-semibold text-sm rounded-full shadow-md transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Create New Event
                </a>
            </div>

            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">

                @if ($events->isEmpty())
                    <div class="p-10 text-center text-gray-500 text-sm font-medium">
                        You haven't created any events yet.
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-600 whitespace-nowrap">

                            <thead
                                class="bg-white border-b border-gray-100 text-[11px] uppercase tracking-wider font-semibold text-gray-400">
                                <tr>
                                    <th class="px-6 py-4 font-semibold">Event</th>
                                    <th class="px-6 py-4 font-semibold">Category</th>
                                    <th class="px-6 py-4 font-semibold">Date</th>
                                    <th class="px-6 py-4 font-semibold">Slots</th>
                                    <th class="px-6 py-4 font-semibold">Status</th>
                                    <th class="px-6 py-4 font-semibold text-right">Action</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-50">
                                @foreach ($events as $event)
                                    <tr class="hover:bg-gray-50/50 transition-colors">

                                        <td class="px-6 py-3 flex items-center gap-3">
                                            <div
                                                class="w-9 h-9 rounded-xl shadow-sm shrink-0 {{ $event->cover_gradient }}">
                                            </div>
                                            <span class="font-bold text-gray-900 text-xs">{{ $event->title }}</span>
                                        </td>

                                        <td class="px-6 py-3">
                                            <span
                                                class="border border-gray-200 text-gray-600 text-[10px] px-3 py-1 rounded-full font-bold">
                                                {{ $event->category->display_name ?? 'N/A' }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-3 text-xs font-medium">
                                            {{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}
                                        </td>

                                        <td class="px-6 py-3 text-xs font-medium">
                                            0/{{ $event->maximum_slots ?? 'N/A' }} {{-- should be dynamic (the 0 is the registered users) --}}
                                        </td>

                                        <td class="px-6 py-3">
                                            <span
                                                class="bg-[#FFE8D6] text-orange-700 text-[10px] px-3 py-1 rounded-full font-bold">
                                                {{ $event->status }} {{-- fix this as it still reflecting published --}}
                                            </span>
                                        </td>

                                        <td class="px-6 py-3">
                                            <div class="flex items-center justify-end gap-4 text-[11px] font-semibold">
                                                <a href="{{ route('events.report.show', $event->id) }}"
                                                    class="text-gray-400 hover:text-gray-900 transition-colors uppercase">View</a>
                                                <a href="{{ route('events.edit', $event->id) }}"
                                                    class="text-gray-400 hover:text-gray-900 transition-colors uppercase">Edit</a>

                                    <form action="{{ route('events.destroy', $event->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this event?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-4 py-2 border-2 border-black bg-gray-300 text-black font-bold text-xs uppercase tracking-widest hover:bg-white hover:text-black transition-colors">
                                            Delete
                                        </button>
                                    </form>

                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
