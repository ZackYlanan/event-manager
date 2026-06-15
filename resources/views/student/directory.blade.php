<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Upcoming Events') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Show error message if event is full or already registered -->
            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if ($events->isEmpty())
                    <p class="text-gray-500">There are no upcoming events at this time.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach ($events as $event)
                            <div class="border rounded-lg p-4 shadow-sm">
                                <h3 class="text-lg font-bold">{{ $event->title }}</h3>
                                <p class="text-sm text-gray-600 mb-2">{{ $event->event_date->format('F d, Y') }} |
                                    {{ $event->venue }}</p>
                                <p class="text-gray-700 mb-4">{{ $event->description }}</p>

                                <div class="flex justify-between items-center border-t pt-4">
                                    <span class="text-sm text-gray-500">Capacity: {{ $event->maximum_slots }}</span>

                                    <!-- The magical 1-click registration button -->
                                    <form method="POST" action="{{ route('events.register', $event->id) }}">
                                        @csrf
                                        <button type="submit"
                                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                            Register Now
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
