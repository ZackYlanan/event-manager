@php
    // 1. Mock the categories for the select dropdown
    $categories = [
        (object) ['id' => 1, 'display_name' => 'Academic Workshop'],
        (object) ['id' => 2, 'display_name' => 'Social Mixer'],
        (object) ['id' => 3, 'display_name' => 'Career Fair'],
        (object) ['id' => 4, 'display_name' => 'Hackathon'],
    ];

    // 2. Mock Laravel's Error Bag
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
    <div class="min-h-screen bg-[#FFFDF9] font-sans text-gray-900 pb-20">
        
        <nav class="bg-white border-b border-orange-50/60 px-8 py-4 flex items-center justify-between sticky top-0 z-10 shadow-sm">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-amber-500 to-orange-500 flex items-center justify-center text-white shadow-sm">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <span class="text-2xl font-bold tracking-tight text-orange-500">vento</span>
            </div>

            <div class="hidden md:flex items-center gap-2 text-sm font-medium text-gray-500">
                <a href="#" class="px-5 py-2 rounded-full hover:bg-gray-50 transition-colors">Home</a>
                <a href="#" class="px-5 py-2 rounded-full bg-[#FFE8D6] text-orange-700 transition-colors">Events</a>
                <a href="#" class="px-5 py-2 rounded-full hover:bg-gray-50 transition-colors">Attendees</a>
                <a href="#" class="px-5 py-2 rounded-full hover:bg-gray-50 transition-colors">Reports</a>
            </div>

            <div class="flex items-center gap-3 pl-4 py-1 pr-1 border border-gray-200 rounded-full bg-white hover:shadow-sm transition-all cursor-pointer">
                <span class="text-sm font-semibold text-gray-700 pl-2">Admin</span>
                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-orange-400 to-orange-500 flex items-center justify-center text-white text-xs font-bold">
                    AD
                </div>
            </div>
        </nav>

        <main class="max-w-[1000px] mx-auto px-6 mt-10">
            
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Event Details</h1>
                <p class="text-sm text-gray-500 mt-1">Fill in the details below to publish a new event.</p>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm font-medium">
                    <div class="font-bold flex items-center gap-2 mb-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Please fix the following errors:
                    </div>
                    <ul class="list-disc list-inside space-y-1 pl-2 text-[13px]">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="#" class="flex flex-col lg:flex-row gap-8 items-start">
                @csrf

                <div class="flex-1 w-full bg-white border border-gray-100 rounded-[24px] shadow-sm p-8 space-y-6">
                    
                    <div class="space-y-1.5">
                        <label for="title" class="block text-xs font-semibold text-gray-700">Title</label>
                        <input id="title" type="text" name="title" value="{{ old('title') }}" placeholder="e.g. Vento Hackathon 2026" required 
                            class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all placeholder:text-gray-400" />
                    </div>

                    <div class="space-y-1.5">
                        <label for="category_id" class="block text-xs font-semibold text-gray-700">Category</label>
                        <div class="relative">
                            <select id="category_id" name="category_id" required class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all appearance-none bg-white text-gray-700">
                                <option value="" disabled selected>Choose a category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->display_name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="space-y-1.5">
                            <label for="event_date" class="block text-xs font-semibold text-gray-700">Start date</label>
                            <input id="event_date" type="date" name="event_date" value="{{ old('event_date') }}" required 
                                class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all text-gray-700" />
                        </div>
                        <div class="space-y-1.5">
                            <label for="end_date" class="block text-xs font-semibold text-gray-700">End date</label>
                            <input id="end_date" type="date" name="end_date" value="{{ old('end_date') }}" required 
                                class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all text-gray-700" />
                        </div>
                        <div class="space-y-1.5">
                            <label for="start_time" class="block text-xs font-semibold text-gray-700">Time</label>
                            <input id="start_time" type="time" name="start_time" value="{{ old('start_time') }}" required 
                                class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all text-gray-700" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label for="maximum_slots" class="block text-xs font-semibold text-gray-700">Total slots</label>
                            <input id="maximum_slots" type="number" name="maximum_slots" value="{{ old('maximum_slots') ?? 100 }}" required min="1"
                                class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all text-gray-700" />
                        </div>
                        <div class="space-y-1.5">
                            <label for="registration_deadline" class="block text-xs font-semibold text-gray-700">Registration Deadline</label>
                            <input id="registration_deadline" type="date" name="registration_deadline" value="{{ old('registration_deadline') }}" required 
                                class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all text-gray-700" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-1.5">
                            <label for="venue" class="block text-xs font-semibold text-gray-700">Location</label>
                            <input id="venue" type="text" name="venue" value="{{ old('venue') }}" placeholder="Venue name or address" required 
                                class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all placeholder:text-gray-400" />
                        </div>
                        
                        <div class="space-y-1.5">
                            <label for="status" class="block text-xs font-semibold text-gray-700">Event Status</label>
                            <div class="relative">
                                <select id="status" name="status" required class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all appearance-none bg-white text-gray-700">
                                    <option value="Draft" {{ old('status') == 'Draft' ? 'selected' : '' }}>Draft (Hidden)</option>
                                    <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active (Public)</option>
                                    <option value="Cancelled" {{ old('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-gray-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
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

                <div class="w-full lg:w-[300px] flex flex-col gap-6 shrink-0 sticky top-[100px]">
                    
                    <div class="bg-white border border-gray-100 rounded-[24px] shadow-sm p-6">
                        <h3 class="text-sm font-bold text-gray-900 mb-4">Cover image</h3>
                        
                        <input type="file" name="cover_image" id="cover_image" class="hidden" accept="image/png, image/jpeg" />
                        
                        <label for="cover_image" class="border-2 border-dashed border-gray-200 rounded-2xl p-6 flex flex-col items-center justify-center text-center cursor-pointer hover:border-orange-400 hover:bg-orange-50/30 transition-all group">
                            <div class="w-10 h-10 bg-orange-100 rounded-full flex items-center justify-center text-orange-500 mb-3 group-hover:scale-110 transition-transform">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                            </div>
                            <span class="text-sm font-bold text-gray-700">Click to upload</span>
                            <span class="text-[11px] font-medium text-gray-400 mt-1">PNG, JPG up to 5MB</span>
                        </label>
                    </div>

                    <div class="bg-white border border-gray-100 rounded-[24px] shadow-sm p-6">
                        <h3 class="text-sm font-bold text-gray-900">Ready to go live?</h3>
                        <p class="text-[11px] text-gray-500 mt-1 mb-6 leading-relaxed">Your event will appear on the public event page immediately.</p>
                        
                        <div class="flex gap-3">
                            <button type="button" onclick="window.history.back()" class="flex-1 py-2.5 px-4 bg-white hover:bg-gray-50 text-gray-700 font-bold text-xs rounded-full border border-gray-200 transition-colors shadow-sm text-center">
                                Cancel
                            </button>
                            <button type="submit" class="flex-1 py-2.5 px-4 bg-gradient-to-r from-[#F5A623] to-[#FF5722] hover:from-[#e0961f] hover:to-[#e64e1e] text-white font-bold text-xs rounded-full shadow-lg shadow-orange-500/25 transition-all text-center">
                                Publish
                            </button>
                        </div>
                    </div>

                </div>
            </form>

        </main>
    </div>
</x-sandbox-layout>