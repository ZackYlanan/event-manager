@php
    // FRONTEND DEVS: Mock the event object to test the edit form
    $event = (object) [
        'id' => 1,
        'title' => 'Tech Innovators Summit 2026',
        'description' =>
            'A gathering of the brightest minds in technology. Join us for keynote speeches, workshops, and networking opportunities.',
        'venue' => 'Grand Convention Center',
        'event_date' => '2026-11-20 09:00:00',
        'maximum_slots' => 500,
    ];

    // FRONTEND DEVS: Change this to 'true' to test the validation errors!
    $showErrors = false;

    if ($showErrors) {
        $errors = new \Illuminate\Support\MessageBag([
            'title' => 'The event title must be at least 5 characters.',
            'maximum_slots' => 'The maximum slots must be a number greater than 0.',
        ]);
    } else {
        $errors = new \Illuminate\Support\MessageBag();
    }
@endphp

<x-sandbox-layout>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form method="POST" action="#"> {{-- {{ route('events.update', $event->id) }} --}}
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <x-input-label for="title" :value="__('Event Title')" />
                        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title"
                            :value="old('title', $event->title)" required autofocus />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="description" :value="__('Description')" />
                        <textarea id="description" name="description"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                            required>{{ old('description', $event->description) }}</textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="venue" :value="__('Venue')" />
                        <x-text-input id="venue" class="block mt-1 w-full" type="text" name="venue"
                            :value="old('venue', $event->venue)" required />
                        <x-input-error :messages="$errors->get('venue')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="event_date" :value="__('Event Date & Time')" />
                        <x-text-input id="event_date" class="block mt-1 w-full" type="datetime-local" name="event_date"
                            :value="old('event_date', date('Y-m-d\TH:i', strtotime($event->event_date)))" required />
                        <x-input-error :messages="$errors->get('event_date')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="maximum_slots" :value="__('Maximum Capacity')" />
                        <x-text-input id="maximum_slots" class="block mt-1 w-full" type="number" name="maximum_slots"
                            :value="old('maximum_slots', $event->maximum_slots)" required min="1" />
                        <x-input-error :messages="$errors->get('maximum_slots')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <a href="#" {{-- {{ route('events.index') }} --}} class="text-gray-600 hover:underline mr-4">Cancel</a>
                        <x-primary-button>
                            {{ __('Save Changes') }}
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-sandbox-layout>
