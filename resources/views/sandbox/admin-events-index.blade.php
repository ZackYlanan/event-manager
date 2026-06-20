@php
    $events = collect([
        (object) [
            'id' => 1,
            'title' => 'Freshman Orientation',
            'event_date' => '2026-08-15',
            'venue' => 'Main Hall',
            'status' => 'Active',
        ],
        (object) [
            'id' => 2,
            'title' => 'Career Fair',
            'event_date' => '2026-10-10',
            'venue' => 'Gymnasium',
            'status' => 'Active',
        ],
        (object) [
            'id' => 3,
            'title' => 'Hackathon',
            'event_date' => '2026-03-22',
            'venue' => 'Tech Building',
            'status' => 'Past',
        ],
    ]);
@endphp

<x-sandbox-layout>

    <body class="bg-gray-100">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                @if (session('success'))
                    <div class="border-2 border-black bg-white text-black font-bold uppercase p-4 mb-6">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="bg-white border-2 border-black p-6">

                    @if ($events->isEmpty())
                        <p class="text-black italic">You haven't created any events yet.</p>
                    @else
                        <ul class="divide-y-2 divide-black">
                            @foreach ($events as $event)
                                <li class="py-4 flex justify-between items-center">

                                    <div>
                                        <h3 class="text-xl font-bold text-black">{{ $event->title }}</h3>
                                        <p class="text-sm text-black font-mono mt-1">
                                            {{ $event->event_date }} | {{ $event->venue }} {{-- {{ $event->event_date->format('M d, Y') }} | {{ $event->venue }} --}}
                                        </p>
                                    </div>

                                    <div class="flex items-center space-x-4">

                                        <span
                                            class="px-3 py-1 border-2 border-black text-black text-xs font-bold uppercase tracking-widest">
                                            {{ $event->status }}
                                        </span>

                                        <a href="#" {{-- {{ route('events.edit', $event->id) }} --}}
                                            class="px-4 py-2 border-2 border-black bg-white text-black font-bold text-xs uppercase tracking-widest hover:bg-black hover:text-white transition-colors">
                                            Edit
                                        </a>

                                        <form action="#" method="POST"
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
</x-sandbox-layout>
