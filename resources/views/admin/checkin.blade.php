<x-app-layout>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">

            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                    {{ session('error') }}
                </div>
            @endif

            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <p class="text-sm text-gray-600 mb-4">
                    Type or scan the student's unique 8-character registration code below to confirm their attendance.
                </p>

                <form method="POST" action="{{ route('admin.checkin.process') }}">
                    @csrf

                    <div>
                        <x-input-label for="registration_code" :value="__('Ticket Registration Code')" />

                        <x-text-input id="registration_code"
                            class="block mt-1 w-full text-center font-mono text-xl tracking-widest" type="text"
                            name="registration_code" placeholder="ABC123XY" maxlength="8" required autofocus />

                        <x-input-error :messages="$errors->get('registration_code')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="w-full justify-center">
                            Verify & Mark Present
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
