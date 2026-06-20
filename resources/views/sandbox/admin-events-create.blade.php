@php
    // 1. Mock the categories for the select dropdown
    $categories = [
        (object) ['id' => 1, 'display_name' => 'Academic Workshop'],
        (object) ['id' => 2, 'display_name' => 'Social Mixer'],
        (object) ['id' => 3, 'display_name' => 'Career Fair'],
        (object) ['id' => 4, 'display_name' => 'Hackathon'],
    ];

    // 2. Mock Laravel's Error Bag
// FRONTEND DEVS: Change this to 'false' to hide the error box and test the clean state!
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
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if ($errors->any())
                <div class="border-2 border-black bg-white text-black p-4 mb-6">

                    <div class="font-bold uppercase tracking-widest border-b-2 border-black pb-2 mb-3">
                        Validation Errors
                    </div>

                    <ul class="list-disc list-inside text-sm font-mono">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                </div>
            @endif

            <div class="bg-white border-2 border-black p-6">

                <form method="POST" action="#"> {{-- {{ route('events.store') }} --}}
                    @csrf

                    <div class="mb-6">
                        <label class="block font-bold uppercase text-xs tracking-widest mb-2">
                            Event Title
                        </label>

                        <input type="text" name="title"
                            class="w-full border-2 border-black p-2 bg-white text-black" required>
                    </div>

                    <div class="mb-6">
                        <label class="block font-bold uppercase text-xs tracking-widest mb-2">
                            Category
                        </label>

                        <select name="category_id" class="w-full border-2 border-black p-2 bg-white text-black"
                            required>

                            <option value="">Select a Category</option>

                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">
                                    {{ $category->display_name }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <div class="mb-6">
                        <label class="block font-bold uppercase text-xs tracking-widest mb-2">
                            Description
                        </label>

                        <textarea name="description" rows="4" class="w-full border-2 border-black p-2 bg-white text-black" required></textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <div>
                            <label class="block font-bold uppercase text-xs tracking-widest mb-2">
                                Event Date
                            </label>

                            <input type="date" name="event_date"
                                class="w-full border-2 border-black p-2 bg-white text-black" required>
                        </div>

                        <div>
                            <label class="block font-bold uppercase text-xs tracking-widest mb-2">
                                Venue
                            </label>

                            <input type="text" name="venue"
                                class="w-full border-2 border-black p-2 bg-white text-black">
                        </div>

                        <div>
                            <label class="block font-bold uppercase text-xs tracking-widest mb-2">
                                Start Time
                            </label>

                            <input type="time" name="start_time"
                                class="w-full border-2 border-black p-2 bg-white text-black" required>
                        </div>

                        <div>
                            <label class="block font-bold uppercase text-xs tracking-widest mb-2">
                                End Time
                            </label>

                            <input type="time" name="end_time"
                                class="w-full border-2 border-black p-2 bg-white text-black" required>
                        </div>

                        <div>
                            <label class="block font-bold uppercase text-xs tracking-widest mb-2">
                                Maximum Slots
                            </label>

                            <input type="number" name="maximum_slots"
                                class="w-full border-2 border-black p-2 bg-white text-black" required>
                        </div>

                        <div>
                            <label class="block font-bold uppercase text-xs tracking-widest mb-2">
                                Registration Deadline
                            </label>

                            <input type="date" name="registration_deadline"
                                class="w-full border-2 border-black p-2 bg-white text-black" required>
                        </div>

                    </div>

                    <div class="flex justify-end mt-8">

                        <button type="submit"
                            class="border-2 border-black bg-white text-black px-4 py-2 font-bold uppercase text-xs tracking-widest hover:bg-black hover:text-white transition-colors">

                            Save Event

                        </button>

                    </div>

                </form>

            </div>

        </div>
    </div>
</x-sandbox-layout>
