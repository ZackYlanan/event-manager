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
                                            {{ $event->registrations_count ?? 0 }}/{{ $event->maximum_slots ?? 'N/A' }}
                                            {{-- should be dynamic (the 0 is the registered users) --}}
                                        </td>

                                        <td class="px-6 py-3">
                                            <span
                                                class="bg-[#FFE8D6] text-orange-700 text-[10px] px-3 py-1 rounded-full font-bold">
                                                {{ $event->status }} {{-- fix this as it still reflecting published --}}
                                            </span>
                                        </td>

                                        <td class="px-6 py-3">
                                            <div class="flex items-center justify-end gap-3 text-gray-400">
                                                <a href="{{ route('events.report.show', $event->id) }}"
                                                    class="hover:text-gray-900 transition-colors" title="Reports">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="size-6">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z" />
                                                    </svg>

                                                </a>
                                                <a href="{{ route('events.edit', $event->id) }}"
                                                    class="hover:text-[#FF7A00] transition-colors" title="Edit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        class="w-5 h-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                                    </svg>
                                                </a>

                                                <form action="{{ route('events.destroy', $event->id) }}" method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this event?');"
                                                    class="inline m-0 p-0 flex items-center">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="hover:text-red-600 transition-colors"
                                                        title="Delete">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="w-5 h-5">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
