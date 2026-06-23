{{-- FRONTEND TEAM MOCK DATA --}}
@php
    $events = collect([
        (object) [
            'id' => 1,
            'title' => 'Vento Hackathon 2026',
            'category' => 'Tech',
            'event_date' => '2026-10-12',
            'slots_filled' => 45,
            'maximum_slots' => 100,
            'status' => 'Active',
            'image' => 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80'
        ],
        (object) [
            'id' => 2,
            'title' => 'Indie Music Festival',
            'category' => 'Music',
            'event_date' => '2026-11-05',
            'slots_filled' => 312,
            'maximum_slots' => 500,
            'status' => 'Active',
            'image' => 'https://images.unsplash.com/photo-1459749411175-04bf5292ceea?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80'
        ],
        (object) [
            'id' => 3,
            'title' => 'Startup Founders Summit',
            'category' => 'Business',
            'event_date' => '2026-12-01',
            'slots_filled' => 198,
            'maximum_slots' => 250,
            'status' => 'Active',
            'image' => 'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?ixlib=rb-4.0.3&auto=format&fit=crop&w=100&q=80'
        ],
    ]);
@endphp

<x-sandbox-layout>
    <div class="min-h-screen bg-[#FFFDF9] font-sans text-gray-900 pb-12">
        
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

        <main class="max-w-[1100px] mx-auto px-6 mt-10">
            
            @if (session('success'))
                <div class="mb-6 p-4 rounded-xl bg-green-50 border border-green-200 text-green-700 text-sm font-medium flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end gap-4 mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Events</h1>
                    <p class="text-sm text-gray-500 mt-1">Manage all your events in one place.</p>
                </div>
                <a href="#" class="py-2.5 px-5 bg-gradient-to-r from-[#F5A623] to-[#FF5722] hover:from-[#e0961f] hover:to-[#e64e1e] text-white font-semibold text-sm rounded-full shadow-lg shadow-orange-500/25 transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Create New Event
                </a>
            </div>

            <div class="bg-white border border-gray-100 rounded-2xl shadow-sm overflow-hidden">
                
                @if ($events->isEmpty())
                    <div class="p-10 text-center text-gray-500 text-sm font-medium">
                        You haven't created any events yet.
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-600 whitespace-nowrap">
                            
                            <thead class="bg-white border-b border-gray-100 text-[11px] uppercase tracking-wider font-semibold text-gray-400">
                                <tr>
                                    <th class="px-6 py-4 font-semibold">Event</th>
                                    <th class="px-6 py-4 font-semibold">Category</th>
                                    <th class="px-6 py-4 font-semibold">Date</th>
                                    <th class="px-6 py-4 font-semibold">Slots</th>
                                    <th class="px-6 py-4 font-semibold">Status</th>
                                    <th class="px-6 py-4 font-semibold text-right">Action</th>
                                </tr>
                            </thead>
                            
                            <tbody class="divide-y divide-gray-50">
                                @foreach ($events as $event)
                                    <tr class="hover:bg-gray-50/50 transition-colors">
                                        
                                        <td class="px-6 py-3 flex items-center gap-3">
                                            <img src="{{ $event->image }}" alt="{{ $event->title }}" class="w-9 h-9 rounded-xl object-cover shadow-sm shrink-0" />
                                            <span class="font-bold text-gray-900 text-xs">{{ $event->title }}</span>
                                        </td>
                                        
                                        <td class="px-6 py-3">
                                            <span class="border border-gray-200 text-gray-600 text-[10px] px-3 py-1 rounded-full font-bold">
                                                {{ $event->category }}
                                            </span>
                                        </td>
                                        
                                        <td class="px-6 py-3 text-xs font-medium">
                                            {{ \Carbon\Carbon::parse($event->event_date)->format('M d, Y') }}
                                        </td>
                                        
                                        <td class="px-6 py-3 text-xs font-medium">
                                            {{ $event->slots_filled }}/{{ $event->maximum_slots }}
                                        </td>
                                        
                                        <td class="px-6 py-3">
                                            <span class="bg-[#FFE8D6] text-orange-700 text-[10px] px-3 py-1 rounded-full font-bold">
                                                {{ $event->status }}
                                            </span>
                                        </td>
                                        
                                        <td class="px-6 py-3">
                                            <div class="flex items-center justify-end gap-4 text-[11px] font-semibold">
                                                <a href="#" class="text-gray-400 hover:text-gray-900 transition-colors">Delete</a>
                                                <a href="#" class="text-gray-400 hover:text-gray-900 transition-colors">Edit</a>
                                                <a href="#" class="text-gray-400 hover:text-gray-900 transition-colors">View</a>
                                                
                                                <form action="#" method="POST" onsubmit="return confirm('Are you sure you want to delete this event?');" class="inline m-0 p-0 absolute -z-10 opacity-0 w-0 h-0">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" id="delete-btn-{{ $event->id }}"></button>
                                                </form>
                                            </div>
                                        </td>
                                        
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                
            </div>
        </main>
    </div>
    
    <script>
        document.querySelectorAll('a:contains("Delete")').forEach((link, index) => {
            link.addEventListener('click', (e) => {
                e.preventDefault();
                // Finds the hidden form button in the same row and clicks it
                e.target.parentElement.querySelector('form button').click();
            });
        });
        
        // Helper to mimic jQuery :contains selector
        // Note: Included for simplicity since native JS doesn't have :contains
        HTMLElement.prototype.getNodesByText = function (text) {
            const expr = `.//a[text()='${text}']`;
            const nodeSet = document.evaluate(expr, this, null, XPathResult.ANY_TYPE, null);
            let node = nodeSet.iterateNext();
            let nodes = [];
            while (node) {
                nodes.push(node);
                node = nodeSet.iterateNext();
            }
            return nodes;
        }
    </script>
</x-sandbox-layout>