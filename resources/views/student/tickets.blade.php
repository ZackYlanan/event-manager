<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-10">
                <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">My tickets</h1>
                <p class="text-gray-500 mt-2 text-sm">Show these registration codes at the door for check-in.</p>
            </div>

            @if ($registrations->isEmpty())
                <div
                    class="bg-white rounded-3xl p-12 text-center border border-gray-100 shadow-sm flex flex-col items-center">
                    <svg class="h-16 w-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z">
                        </path>
                    </svg>
                    <h3 class="text-xl font-bold text-gray-900">No tickets yet</h3>
                    <p class="mt-2 text-gray-500">You haven't registered for any upcoming events.</p>
                </div>
            @else
                <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
                    @foreach ($registrations as $registration)
                        <div
                            class="flex flex-col sm:flex-row bg-[#FFFCF9] border border-orange-100 rounded-3xl shadow-sm hover:shadow-md transition-shadow overflow-hidden relative">

                            <div class="flex-1 p-6 sm:p-8">
                                <div class="text-[10px] font-extrabold text-[#FF7A00] uppercase tracking-widest mb-3">
                                    {{ $registration->event->category->display_name ?? 'EVENT' }}
                                </div>

                                <h3 class="text-2xl font-black text-gray-900 mb-5 leading-tight">
                                    {{ $registration->event->title }}
                                </h3>

                                <div class="space-y-3 mb-8">
                                    <div class="flex items-center text-sm font-medium text-gray-500">
                                        <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                            </path>
                                        </svg>
                                        {{ \Carbon\Carbon::parse($registration->event->event_date)->format('M d, Y') }}
                                        · {{ \Carbon\Carbon::parse($registration->event->start_time)->format('h:i A') }}
                                        - {{ \Carbon\Carbon::parse($registration->event->end_time)->format('h:i A') }}
                                    </div>
                                    <div class="flex items-center text-sm font-medium text-gray-500">
                                        <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z">
                                            </path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        {{ $registration->event->venue }}
                                    </div>
                                </div>

                                <div class="flex items-center gap-3">
                                    <a href=" {{ route('events.show', $registration->event->id) }} "
                                        class="inline-flex items-center px-5 py-2 border border-gray-200 rounded-full text-xs font-bold text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-300 transition-colors">
                                        View event
                                    </a>

                                    @if ($registration->attendance_status === 'Pending')
                                        <form action="{{ route('tickets.cancel', $registration->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to cancel this ticket?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center px-5 py-2 border border-red-200 rounded-full text-xs font-bold text-red-600 bg-red-50 hover:bg-red-100 transition-colors">
                                                Cancel
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>

                            <div
                                class="relative sm:w-56 bg-[#FFF9F2] border-t sm:border-t-0 sm:border-l-2 border-dashed border-orange-200 flex flex-col items-center justify-center p-6 sm:p-8">

                                <div class="hidden sm:block absolute -top-4 -left-4 w-8 h-8 bg-gray-50 rounded-full">
                                </div>
                                <div class="hidden sm:block absolute -bottom-4 -left-4 w-8 h-8 bg-gray-50 rounded-full">
                                </div>

                                <span class="text-[10px] font-bold text-gray-400 uppercase tracking-widest mb-3">Ticket
                                    Code</span>

                                <span class="text-3xl font-mono font-black text-gray-900 tracking-widest mb-4">
                                    {{ $registration->registration_code }}
                                </span>

                                @php
                                    $statusClasses = match($registration->attendance_status) {
                                        'Pending' => 'bg-amber-100 text-amber-700',
                                        'Present' => 'bg-emerald-100 text-emerald-700',
                                        'Absent' => 'bg-rose-100 text-rose-700',
                                        default => 'bg-gray-100 text-gray-700',
                                    };
                                @endphp
                                <span
                                    class="inline-flex px-3 py-1 rounded-full text-[10px] font-bold tracking-wide uppercase {{ $statusClasses }}">
                                    {{ $registration->display_status }}
                                </span>
                            </div>

                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
