<x-app-layout>

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
                                    <p class="text-sm text-gray-600">{{ $event->event_date->format('M d, Y') }} |
                                        {{ $event->venue }}</p>
                                </div>
                                <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm">
                                    {{ $event->status }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
