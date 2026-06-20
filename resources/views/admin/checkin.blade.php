<x-app-layout>

    <div class="py-12">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">

            @if (session('error'))
                <div class="border-2 border-black bg-white text-black p-4 mb-6">
                    <div class="font-bold uppercase tracking-widest border-b-2 border-black pb-2 mb-2">
                        Error
                    </div>

                    <p class="font-mono text-sm">
                        {{ session('error') }}
                    </p>
                </div>
            @endif

            @if (session('success'))
                <div class="border-2 border-black bg-white text-black p-4 mb-6">
                    <div class="font-bold uppercase tracking-widest border-b-2 border-black pb-2 mb-2">
                        Success
                    </div>

                    <p class="font-mono text-sm">
                        {{ session('success') }}
                    </p>
                </div>
            @endif

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

                <div class="border-b-2 border-black pb-3 mb-4">
                    <h2 class="font-bold uppercase tracking-widest">
                        Attendance Check-In
                    </h2>
                </div>

                <p class="text-sm font-mono mb-6">
                    Type or scan the student's unique 8-character registration code below
                    to confirm attendance.
                </p>

                <form method="POST" action="{{ route('admin.checkin.process') }}">
                    @csrf

                    <div>
                        <label class="block font-bold uppercase text-xs tracking-widest mb-2">
                            Registration Code
                        </label>

                        <input id="registration_code" type="text" name="registration_code" placeholder="ABC123XY"
                            maxlength="8" required autofocus
                            class="w-full border-2 border-black p-3 text-center font-mono text-xl tracking-widest bg-white text-black">
                    </div>

                    <div class="mt-6">

                        <button type="submit"
                            class="w-full border-2 border-black bg-white text-black py-3 font-bold uppercase tracking-widest hover:bg-black hover:text-white transition-colors">

                            Verify & Mark Present

                        </button>

                    </div>

                </form>

            </div>

        </div>
    </div>
</x-app-layout>
