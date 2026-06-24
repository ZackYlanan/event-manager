<x-guest-layout>
    <x-slot name="header">
        <h1 class="text-lg font-extrabold tracking-tight text-gray-900 uppercase">Register Account</h1>
        <p class="text-[11px] text-gray-500 mt-1">Please fill up the details to create an account.</p>
    </x-slot>

    <form method="POST" action="{{ route('register') }}" class="space-y-3.5">
        @csrf

        <div class="space-y-1">
            <label for="name" class="block text-[11px] font-semibold text-gray-700">Name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Juan Dela Cruz" required autofocus autocomplete="name" 
                class="w-full px-3 py-2 text-sm rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all placeholder:text-gray-400" />
            <x-input-error :messages="$errors->get('name')" class="mt-1" />
        </div>

        <div class="space-y-1">
            <label for="email" class="block text-[11px] font-semibold text-gray-700">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="admin@vento.com" required autocomplete="username" 
                class="w-full px-3 py-2 text-sm rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all placeholder:text-gray-400" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <div class="space-y-1">
            <label for="student_id" class="block text-[11px] font-semibold text-gray-700">Student ID</label>
            <input id="student_id" type="text" name="student_id" value="{{ old('student_id') }}" required 
                class="w-full px-3 py-2 text-sm rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all" />
            <x-input-error :messages="$errors->get('student_id')" class="mt-1" />
        </div>

        <div class="space-y-1">
            <label for="course" class="block text-[11px] font-semibold text-gray-700">Course</label>
            <input id="course" type="text" name="course" value="{{ old('course') }}" required 
                class="w-full px-3 py-2 text-sm rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all" />
            <x-input-error :messages="$errors->get('course')" class="mt-1" />
        </div>

        <div class="space-y-1">
            <label for="password" class="block text-[11px] font-semibold text-gray-700">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password" 
                class="w-full px-3 py-2 text-sm rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <div class="space-y-1">
            <label for="password_confirmation" class="block text-[11px] font-semibold text-gray-700">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" 
                class="w-full px-3 py-2 text-sm rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
        </div>

        <button type="submit" class="w-full mt-2 py-2.5 px-4 bg-[#FF7A00] hover:bg-orange-600 text-white font-bold text-xs rounded-full shadow-md transition-all uppercase tracking-wide cursor-pointer">
            Submit
        </button>
    </form>

    <div class="flex items-center justify-between mt-6 px-1">
        <a href="{{ route('login') }}" class="text-[11px] font-semibold text-orange-500 hover:text-orange-600 transition-colors">
            Already Registered?
        </a>
        
        <a href="{{ url()->previous() }}" class="text-[11px] font-medium text-gray-500 hover:text-gray-700 transition-colors flex items-center gap-1">
            &larr; Back
        </a>
    </div>
</x-guest-layout>
