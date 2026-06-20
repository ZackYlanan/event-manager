<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                @if ($registrations->isEmpty())
                    <p class="text-gray-500">You haven't registered for any events yet.</p>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach ($registrations as $registration)
                            <div class="border rounded-lg p-4 shadow-sm flex flex-col justify-between">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">{{ $registration->event->title }}</h3>
                                    <p class="text-sm text-gray-600 mt-1">Date:
                                        {{ $registration->event->event_date->format('M d, Y') }}</p>
                                    <p class="text-sm text-gray-600">Venue: {{ $registration->event->venue }}</p>
                                </div>
                                <div class="mt-4 pt-4 border-t flex justify-between items-center">
                                    <span class="font-mono bg-gray-100 px-2 py-1 rounded text-sm">Code:
                                        {{ $registration->registration_code }}</span>
                                    <span
                                        class="font-bold {{ $registration->attendance_status == 'Present' ? 'text-green-600' : 'text-yellow-600' }}">
                                        {{ $registration->attendance_status }}
                                    </span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
