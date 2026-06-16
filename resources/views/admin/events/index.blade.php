<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class=" ">
                {{ __('My Managed Events') }}
            </h2>
            <a href="{{ route('events.create') }}" class="">
                + Create New Event
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if ($events->isEmpty())
                    <p class="text-gray-500">You haven't created any events yet.</p>
                @else
                    <ul class="divide-y divide-gray-200">
                        @foreach ($events as $event)
                            <li class="py-4 flex justify-between items-center">
                                <div>
                                    <h3 class="text-lg font-bold">{{ $event->title }}</h3>
                                    <p class="text-sm text-gray-600">
                                        {{ $event->event_date->format('M d, Y') }} | {{ $event->venue }}
                                    </p>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm">
                                        {{ $event->status }}
                                    </span>

                                    <!-- Delete button -->
                                    <form action="{{ route('events.destroy', $event->id) }}" method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this event?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded">
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
