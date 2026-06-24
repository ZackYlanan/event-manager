<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-8">
            <label for="event_select" class="block text-xs font-semibold text-gray-700 uppercase tracking-wider mb-2">
                Step 1: Select Active Event
            </label>
            <select id="event_select" onchange="window.location.href='?event_id=' + this.value"
                class="block w-full text-sm py-3 pl-4 pr-10 border-gray-200 focus:outline-none focus:ring-1 focus:ring-[#FF7A00] focus:border-[#FF7A00] rounded-xl shadow-sm transition-all appearance-none">
                <option value="" disabled {{ !$selectedEvent ? 'selected' : '' }}>-- Select an event to unlock
                    kiosk --</option>
                @foreach ($activeEvents as $event)
                    <option value="{{ $event->id }}" {{ ($selectedEvent->id ?? 0) == $event->id ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::parse($event->event_date)->format('M d') }} - {{ $event->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 relative">

            @if (!$selectedEvent)
                <div
                    class="absolute inset-0 bg-white/60 backdrop-blur-sm z-10 flex items-center justify-center rounded-[24px] border border-dashed border-gray-300">
                    <div class="text-center bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                            </path>
                        </svg>
                        <h2 class="text-lg font-bold text-gray-900">Kiosk Locked</h2>
                        <p class="text-sm text-gray-500 mt-1">Select an event above to initialize scanner.</p>
                    </div>
                </div>
            @endif

            <div
                class="bg-white rounded-[24px] shadow-sm border border-gray-100 p-8 flex flex-col justify-center min-h-[400px]">
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Scan Ticket</h2>
                    <p class="text-xs text-gray-500 mt-1.5">Awaiting scanner input for <strong
                            class="text-[#FF7A00]">{{ $selectedEvent->title ?? '...' }}</strong></p>
                </div>

                @if (session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-xl mb-6 shadow-sm">
                        <p class="text-sm font-semibold flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7"></path>
                            </svg>
                            {{ session('success') }}
                        </p>
                    </div>
                @endif

                @if (session('error'))
                    <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-xl mb-6 shadow-sm">
                        <p class="text-sm font-semibold flex items-center">
                            <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            {{ session('error') }}
                        </p>
                    </div>
                @endif

                <form action="{{ route('admin.checkin.process') }}" method="POST">
                    @csrf
                    <input type="hidden" name="event_id" value="{{ $selectedEvent->id ?? '' }}">

                    <div class="relative">
                        <input type="text" name="registration_code" maxlength="8" autofocus autocomplete="off"
                            placeholder="Enter 8-digit code"
                            class="block w-full text-center text-2xl tracking-[0.25em] font-mono py-5 bg-gray-50 border border-gray-200 focus:bg-white focus:border-[#FF7A00] focus:ring-1 focus:ring-[#FF7A00] rounded-xl uppercase transition-all"
                            {{ !$selectedEvent ? 'disabled' : '' }}>

                        <button type="submit"
                            class="mt-4 w-full bg-[#FF7A00] hover:bg-orange-600 text-white text-xs font-bold py-3.5 px-4 rounded-full shadow-md transition-all uppercase tracking-wide cursor-pointer"
                            {{ !$selectedEvent ? 'disabled' : '' }}>
                            Process Check-In
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-[24px] shadow-sm border border-gray-100 flex flex-col h-[400px]"
                x-data="{ search: '' }">

                <div class="p-6 border-b border-gray-100 bg-gray-50 rounded-t-2xl">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Manual Fallback</h3>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input x-model="search" type="text" placeholder="Search student name..."
                            class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:border-[#FF7A00] focus:ring-1 focus:ring-[#FF7A00] sm:text-sm transition-colors"
                            {{ !$selectedEvent ? 'disabled' : '' }}>
                    </div>
                </div>

                <div class="flex-1 overflow-y-auto p-2">
                    <ul class="divide-y divide-gray-100">
                        @if ($selectedEvent)
                            @forelse($registrations as $registration)
                                <li class="p-4 hover:bg-gray-50 rounded-xl transition-colors flex items-center justify-between group"
                                    x-show="search === '' || '{{ strtolower($registration->user->name) }}'.includes(search.toLowerCase())">

                                    <div>
                                        <p class="text-sm font-bold text-gray-900">{{ $registration->user->name }}</p>
                                        <p class="text-xs font-mono text-gray-500 mt-0.5">Code:
                                            {{ $registration->registration_code }}</p>
                                    </div>

                                    @if ($registration->is_checked_in)
                                        <span
                                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Checked In
                                        </span>
                                    @else
                                        <form action="{{ route('admin.checkin.manual', $registration->id) }}"
                                            method="POST">
                                            @csrf
                                            <input type="hidden" name="event_id" value="{{ $selectedEvent->id }}">
                                            <button type="submit"
                                                class="opacity-0 group-hover:opacity-100 transition-opacity bg-white border border-[#FF7A00] text-[#FF7A00] hover:bg-[#FF7A00] hover:text-white text-xs font-bold py-1.5 px-3 rounded-lg">
                                                Mark Present
                                            </button>
                                        </form>
                                    @endif
                                </li>
                            @empty
                                <li class="p-8 text-center text-gray-500 text-sm">No registrations found for this event.
                                </li>
                            @endforelse
                        @endif
                    </ul>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
