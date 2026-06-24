<x-app-layout>

    <div x-data="reportDashboard({{ $event->id }})" x-init="fetchData()" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-cloak>

        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Reports Dashboard</h1>
            <p class="text-sm text-gray-500 mt-1">Insights to help you run better events.</p>
        </div>

        <div x-show="loading" class="py-12 text-center text-gray-500 font-medium animate-pulse">
            Loading analytics...
        </div>

        <div x-show="!loading" style="display: none;">

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 mb-6">
                <div class="mb-4">
                    <h3 class="text-lg font-bold text-gray-900">Ticket Distribution</h3>
                    <div class="flex items-center gap-4 mt-2 text-xs text-gray-500 font-medium">
                        <div class="flex items-center gap-1.5"><span class="w-3 h-3 bg-gray-400 rounded-sm"></span> Sold
                        </div>
                        <div class="flex items-center gap-1.5"><span class="w-3 h-3 bg-[#FF7A00] rounded-sm"></span>
                            Available</div>
                    </div>
                </div>
                <div class="relative h-48 w-full">
                    <canvas id="ticketChart"></canvas>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8 mb-8">
                <div class="mb-4">
                    <h3 class="text-lg font-bold text-gray-900">Event Attendance</h3>
                    <div class="flex items-center gap-4 mt-2 text-xs text-gray-500 font-medium">
                        <div class="flex items-center gap-1.5"><span class="w-3 h-3 bg-[#FF7A00] rounded-sm"></span>
                            Check-in</div>
                        <div class="flex items-center gap-1.5"><span class="w-3 h-3 bg-gray-400 rounded-sm"></span>
                            No-show</div>
                    </div>
                </div>
                <div class="relative h-48 w-full">
                    <canvas id="attendanceChart"></canvas>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-8 overflow-hidden">
                <div class="p-6 border-b border-gray-50 flex items-center gap-2">
                    <h3 class="text-lg font-bold text-gray-900">Attendee Roster</h3>
                    <span class="text-sm text-gray-400">(<span x-text="analytics.total_registrations"></span>
                        registered)</span>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr
                                class="bg-gray-50 border-b border-gray-100 text-xs font-semibold text-gray-500 tracking-wider">
                                <th class="px-6 py-4">Name</th>
                                <th class="px-6 py-4">Student ID</th>
                                <th class="px-6 py-4">Course</th>
                                <th class="px-6 py-4">Ticket</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Check-In</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                            <template x-for="student in roster" :key="student.registration_code">
                                <tr class="hover:bg-gray-50/50 transition-colors">
                                    <td class="px-6 py-4 font-medium text-gray-900" x-text="student.student_name"></td>
                                    <td class="px-6 py-4" x-text="student.student_id"></td>
                                    <td class="px-6 py-4" x-text="student.course"></td>
                                    <td class="px-6 py-4 font-mono text-xs text-gray-500"
                                        x-text="student.registration_code"></td>
                                    <td class="px-6 py-4">
                                        <span
                                            class="inline-flex px-2.5 py-1 rounded-full text-[10px] font-bold tracking-wide uppercase"
                                            :class="student.attendance_status === 'Present' ? 'bg-green-100 text-green-700' :
                                                'bg-orange-100 text-[#FF7A00]'"
                                            x-text="student.attendance_status === 'Present' ? 'Checked In' : 'Registered'">
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-gray-500"
                                        x-text="student.checked_in_at ? formatTime(student.checked_in_at) : '-'"></td>
                                </tr>
                            </template>
                            <tr x-show="roster.length === 0">
                                <td colspan="6" class="px-6 py-8 text-center text-gray-400">No attendees registered
                                    yet.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <p class="text-sm font-medium text-gray-500 mb-1">Total Registration</p>
                    <p class="text-4xl font-black text-gray-900" x-text="analytics.total_registrations"></p>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <p class="text-sm font-medium text-gray-500 mb-1">Capacity Utilization</p>
                    <p class="text-4xl font-black text-gray-900" x-text="analytics.capacity_utilization"></p>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <p class="text-sm font-medium text-gray-500 mb-1">Attendance Rate</p>
                    <p class="text-4xl font-black text-gray-900" x-text="analytics.turnout_rate"></p>
                </div>
            </div>

            <div>
                <a href="{{ route('events.report.export', $event->id) }}"
                    class="inline-flex items-center justify-center bg-[#FF7A00] hover:bg-orange-600 text-white font-bold py-3 px-8 rounded-xl transition-all shadow-md transform hover:-translate-y-0.5">
                    Export CSV
                </a>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('reportDashboard', (eventId) => ({
                loading: true,
                analytics: {},
                roster: [],
                eventData: {},

                async fetchData() {
                    try {
                        // Hits the JSON endpoint you already built
                        const response = await fetch(`/admin/events/${eventId}/report/data`);
                        const data = await response.json();

                        this.analytics = data.analytics;
                        this.roster = data.roster;
                        this.eventData = data.event;

                        this.loading = false;

                        // We must wait for the DOM to un-hide the canvas elements before drawing
                        this.$nextTick(() => {
                            this.renderCharts();
                        });
                    } catch (error) {
                        console.error("Failed to load report data:", error);
                        alert("Error loading report data.");
                    }
                },

                renderCharts() {
                    // Common styling for horizontal bar charts
                    const commonOptions = {
                        indexAxis: 'y',
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: '#111827',
                                padding: 12,
                                titleFont: {
                                    size: 14
                                },
                                bodyFont: {
                                    size: 14
                                }
                            }
                        },
                        scales: {
                            x: {
                                beginAtZero: true,
                                grid: {
                                    color: '#f3f4f6',
                                    drawBorder: false
                                },
                                ticks: {
                                    font: {
                                        family: 'Inter, sans-serif'
                                    }
                                }
                            },
                            y: {
                                grid: {
                                    display: false,
                                    drawBorder: false
                                },
                                ticks: {
                                    font: {
                                        family: 'Inter, sans-serif',
                                        weight: 'bold'
                                    }
                                }
                            }
                        }
                    };

                    // 1. Ticket Distribution Chart
                    const availableSlots = Math.max(0, this.eventData.maximum_slots - this.analytics
                        .total_registrations);
                    new Chart(document.getElementById('ticketChart').getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: ['Available', 'Sold'],
                            datasets: [{
                                data: [availableSlots, this.analytics
                                    .total_registrations
                                ],
                                backgroundColor: ['#FF7A00',
                                    '#9CA3AF'
                                ], // Orange for Available, Grey for Sold
                                borderRadius: 4,
                                barThickness: 48
                            }]
                        },
                        options: commonOptions
                    });

                    // 2. Attendance Chart
                    new Chart(document.getElementById('attendanceChart').getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: ['Check-in', 'No-show'],
                            datasets: [{
                                data: [this.analytics.actual_attendance, this.analytics
                                    .no_shows
                                ],
                                backgroundColor: ['#FF7A00',
                                    '#9CA3AF'
                                ], // Orange for Check-in, Grey for No-show
                                borderRadius: 4,
                                barThickness: 48
                            }]
                        },
                        options: commonOptions
                    });
                },

                // Helper to format the timestamp into "10:09 am"
                formatTime(datetimeString) {
                    if (!datetimeString) return '-';
                    const date = new Date(datetimeString);
                    return date.toLocaleTimeString([], {
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: true
                    }).toLowerCase();
                }
            }));
        });
    </script>
</x-app-layout>
