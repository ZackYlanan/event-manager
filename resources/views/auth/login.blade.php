<x-guest-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-bold tracking-tight text-gray-900">Welcome back</h1>
        <p class="text-xs text-gray-500 mt-1">Sign in to manage your tickets and events.</p>
    </x-slot>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <!-- Email Input -->
        <div class="space-y-1.5">
            <label for="email" class="block text-xs font-semibold text-gray-700">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required autofocus autocomplete="username" 
                class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all placeholder:text-gray-400" />
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <!-- Password Input -->
        <div class="space-y-1.5">
            <div class="flex items-center justify-between">
                <label for="password" class="block text-xs font-semibold text-gray-700">Password</label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-xs font-medium text-orange-500 hover:text-orange-600">Forgot?</a>
                @endif
            </div>
            <input id="password" type="password" name="password" required autocomplete="current-password" 
                class="w-full px-3.5 py-2.5 text-sm rounded-xl border border-gray-200 focus:border-orange-500 focus:ring-1 focus:ring-orange-500 outline-none transition-all" />
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <!-- Remember Me -->
        <div class="block pt-2">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-orange-500 shadow-sm focus:ring-orange-500" name="remember">
                <span class="ms-2 text-sm text-gray-600 select-none">{{ __('Remember me') }}</span>
            </label>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full mt-4 py-3 px-4 bg-[#FF7A00] hover:bg-orange-600 text-white font-medium text-sm rounded-full shadow-md transition-all flex items-center justify-center gap-2 cursor-pointer">
            Log in
        </button>
    </form>

    <!-- Footer Link -->
    <p class="text-center text-xs text-gray-500 mt-6">
        Don't have an account? 
        <a href="{{ route('register') }}" class="font-semibold text-orange-500 hover:text-orange-600">Sign up</a>
    </p>
</x-guest-layout>
