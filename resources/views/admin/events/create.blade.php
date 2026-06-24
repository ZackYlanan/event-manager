<x-app-layout>
    <div class="min-h-screen bg-[#FFFDF9] font-sans text-gray-900 pb-20">
        <div class="max-w-[1000px] mx-auto px-6 pt-10">

            <div class="mb-8 flex justify-between items-end">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Event Details</h1>
                    <p class="text-sm text-gray-500 mt-1">Fill in the details below to publish a new event.</p>
                </div>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm font-medium">
                    <div class="font-bold flex items-center gap-2 mb-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Please fix the following errors:
                    </div>
                    <ul class="list-disc list-inside space-y-1 pl-2 text-[13px]">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('events.store') }}"
                class="flex flex-col lg:flex-row gap-8 items-start" enctype="multipart/form-data">
                @csrf

                <div class="flex-1 w-full bg-white border border-gray-100 rounded-[24px] shadow-sm p-8 space-y-6">

                    <div class="space-y-1.5">
                        <label for="title" class="block text-xs font-semibold text-gray-700">Title</label>
                        <input id="title" type="text" name="title" value="{{ old('title') }}"
                            placeholder="e.g. Vento Hackathon 2026" required
                            class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all placeholder:text-gray-400" />
                    </div>

                    <div class="space-y-1.5">
                        <label for="category_id" class="block text-xs font-semibold text-gray-700">Category</label>
                        <div class="relative">
                            <select id="category_id" name="category_id" required
                                class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all appearance-none bg-white text-gray-700">
                                <option value="" disabled {{ old('category_id') ? '' : 'selected' }}>Choose a
                                    category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->display_name }}
                                    </option>
                                @endforeach
                            </select>
                            <div
                                class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="space-y-1.5">
                            <label for="event_date" class="block text-xs font-semibold text-gray-700">Event date</label>
                            <input id="event_date" type="date" name="event_date" value="{{ old('event_date') }}"
                                required
                                class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all text-gray-700" />
                        </div>
                        <div class="space-y-1.5">
                            <label for="start_time" class="block text-xs font-semibold text-gray-700">Start time</label>
                            <input id="start_time" type="time" name="start_time" value="{{ old('start_time') }}"
                                required
                                class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all text-gray-700" />
                        </div>
                        <div class="space-y-1.5">
                            <label for="end_time" class="block text-xs font-semibold text-gray-700">End time</label>
                            <input id="end_time" type="time" name="end_time" value="{{ old('end_time') }}" required
                                class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all text-gray-700" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label for="maximum_slots" class="block text-xs font-semibold text-gray-700">Total
                                slots</label>
                            <input id="maximum_slots" type="number" name="maximum_slots"
                                value="{{ old('maximum_slots') ?? 100 }}" required min="1"
                                class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all text-gray-700" />
                        </div>
                        <div class="space-y-1.5">
                            <label for="registration_deadline"
                                class="block text-xs font-semibold text-gray-700">Registration Deadline</label>
                            <input id="registration_deadline" type="date" name="registration_deadline"
                                value="{{ old('registration_deadline') }}" required
                                class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all text-gray-700" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label for="venue" class="block text-xs font-semibold text-gray-700">Location</label>
                            <input id="venue" type="text" name="venue" value="{{ old('venue') }}"
                                placeholder="Venue name or address" required
                                class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all placeholder:text-gray-400" />
                        </div>

                        <div class="space-y-1.5">
                            <label for="status" class="block text-xs font-semibold text-gray-700">Event
                                Status</label>
                            <div class="relative">
                                <select id="status" name="status"
                                    class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all appearance-none bg-white text-gray-700">
                                    <option value="Draft" {{ old('status') == 'Draft' ? 'selected' : '' }}>Draft
                                        (Hidden)</option>
                                    <option value="Published" {{ old('status') == 'Published' ? 'selected' : '' }}>
                                        Published
                                        (Public)</option>
                                    <option value="Completed" {{ old('status') == 'Completed' ? 'selected' : '' }}>
                                        Completed</option>
                                    <option value="Cancelled" {{ old('status') == 'Cancelled' ? 'selected' : '' }}>
                                        Cancelled</option>
                                </select>
                                <div
                                    class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-1.5">
                        <label for="description" class="block text-xs font-semibold text-gray-700">Description</label>
                        <textarea id="description" name="description" rows="5" placeholder="Tell attendees what to expect..." required
                            class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all placeholder:text-gray-400 resize-none">{{ old('description') }}</textarea>
                    </div>

                </div>

                <div class="w-full lg:w-[300px] flex flex-col gap-6 shrink-0 lg:sticky lg:top-[100px]">

                    <div class="mb-6">
                        <label class="block text-sm font-bold text-gray-700 mb-4">Choose a Cover Style</label>

                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">

                            @foreach ($covers as $key => $data)
                                <label class="cursor-pointer relative group">
                                    <!-- use $loop->first to automatically check the very first option -->
                                    <input type="radio" name="cover_style" value="{{ $key }}"
                                        class="peer hidden" {{ $loop->first ? 'checked' : '' }}>

                                    <!-- inject the gradient directly from the array -->
                                    <div
                                        class="w-full h-24 rounded-xl border-2 border-transparent peer-checked:border-[#FF7A00] peer-checked:ring-2 peer-checked:ring-orange-200 transition-all {{ $data['gradient'] }}">
                                    </div>

                                    <!-- checkmark -->
                                    <div
                                        class="absolute top-2 right-2 bg-[#FF7A00] text-white rounded-full p-1 hidden peer-checked:block">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>

                                    <!-- Inject the label -->
                                    <span
                                        class="block mt-2 text-xs font-bold text-gray-600 text-center">{{ $data['label'] }}</span>
                                </label>
                            @endforeach

                        </div>
                    </div>

                    <div class="bg-white border border-gray-100 rounded-[24px] shadow-sm p-6">
                        <h3 class="text-sm font-bold text-gray-900">Ready to go live?</h3>
                        <p class="text-[11px] text-gray-500 mt-1 mb-6 leading-relaxed">Your event will appear on the
                            public event page immediately.</p>

                        <div class="flex gap-3">
                            <a href="{{ route('events.index') }}"
                                class="flex-1 py-2.5 px-4 bg-white hover:bg-gray-50 text-gray-700 font-bold text-xs rounded-full border border-gray-200 transition-colors shadow-sm text-center">
                                Cancel
                            </a>
                            <button type="submit"
                                class="flex-1 py-2.5 px-4 bg-[#FF7A00] hover:bg-orange-600 text-white font-bold text-xs rounded-full shadow-md transition-all text-center">
                                Publish
                            </button>
                        </div>
                    </div>

                </div>
            </form>

        </div>
    </div>
</x-app-layout>
