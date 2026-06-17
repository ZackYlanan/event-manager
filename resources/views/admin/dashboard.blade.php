<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-8 border-b-4 border-black pb-4 flex justify-between items-end">
                <div>
                    <h1 class="text-3xl font-black text-black uppercase tracking-widest">Admin Command Center</h1>
                    <p class="text-black font-mono mt-2">System Overview & Analytics</p>
                </div>
                <a href="{{ route('events.create') }}"
                    class="px-6 py-2 border-2 border-black bg-black text-black font-bold uppercase tracking-widest hover:bg-white hover:text-gray-800 transition-colors">
                    + New Event
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">

                <div class="border-2 border-black bg-white p-6">
                    <h3 class="text-xs font-bold text-black uppercase tracking-widest border-b-2 border-black pb-2 mb-4">
                        Total Events</h3>
                    <div class="text-5xl font-mono text-black font-black">{{ $totalEvents }}</div>
                </div>

                <div class="border-2 border-black bg-white p-6">
                    <h3
                        class="text-xs font-bold text-black uppercase tracking-widest border-b-2 border-black pb-2 mb-4">
                        Upcoming</h3>
                    <div class="text-5xl font-mono text-black font-black">{{ $activeEvents }}</div>
                </div>

                <div class="border-2 border-black bg-white p-6">
                    <h3
                        class="text-xs font-bold text-black uppercase tracking-widest border-b-2 border-black pb-2 mb-4">
                        Students</h3>
                    <div class="text-5xl font-mono text-black font-black">{{ $totalStudents }}</div>
                </div>

                <div class="border-2 border-black bg-white p-6">
                    <h3
                        class="text-xs font-bold text-black uppercase tracking-widest border-b-2 border-black pb-2 mb-4">
                        Tickets Issued</h3>
                    <div class="text-5xl font-mono text-black font-black">{{ $totalTickets }}</div>
                </div>

            </div>

            <div class="border-2 border-black bg-white p-6">
                <div class="flex justify-between items-center border-b-2 border-black pb-4 mb-4">
                    <h2 class="text-xl font-bold text-black uppercase tracking-widest">Next 3 Events</h2>
                    <a href="{{ route('events.index') }}"
                        class="text-sm font-bold text-black uppercase underline hover:bg-black hover:text-white px-2 py-1 transition-colors">View
                        All</a>
                </div>

                @if ($recentEvents->isEmpty())
                    <p class="text-black italic font-mono">No upcoming events scheduled.</p>
                @else
                    <ul class="divide-y-2 divide-black">
                        @foreach ($recentEvents as $event)
                            <li class="py-3 flex justify-between items-center">
                                <div>
                                    <h4 class="font-bold text-black text-lg uppercase tracking-wider">
                                        {{ $event->title }}</h4>
                                    <span
                                        class="font-mono text-sm text-black block">{{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y @ h:i A') }}</span>
                                </div>
                                <div class="text-right">
                                    <span
                                        class="block font-bold text-black uppercase tracking-widest text-xs">Capacity</span>
                                    <span class="font-mono text-black">{{ $event->maximum_slots }} slots</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
