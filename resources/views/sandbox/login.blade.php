<x-sandbox-layout>
        <!-- Background Gradient matching Figma -->
    <div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-[#FFFDF9] via-[#FFF5EB] to-[#FFE8D6] p-4 font-sans text-gray-900">
        
        <!-- Main Card -->
        <div class="w-full max-w-[420px] bg-white rounded-[28px] p-8 sm:p-10 shadow-[0_10px_40px_rgba(0,0,0,0.05)] border border-orange-50/60">
            
            <!-- Logo Section -->
            <div class="flex flex-col items-center mb-6">
                <div class="flex items-center gap-2.5 mb-3">
                    <!-- Calendar Vento Icon -->
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-amber-500 to-orange-500 flex items-center justify-center text-white shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <span class="text-2xl font-bold tracking-tight text-orange-500">vento</span>
                </div>
                <h1 class="text-2xl font-bold tracking-tight text-gray-900">Welcome back</h1>
                <p class="text-xs text-gray-500 mt-1">Sign in to manage your tickets and events.</p>
            </div>

            <!-- Session Status Hook -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Laravel Form -->
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

                <!-- Submit Button -->
                <button type="submit" class="w-full mt-2 py-3 px-4 bg-gradient-to-r from-[#F5A623] to-[#FF5722] hover:from-[#e0961f] hover:to-[#e64e1e] text-white font-medium text-sm rounded-full shadow-lg shadow-orange-500/25 transition-all flex items-center justify-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    Continue with email
                </button>
            </form>

            <!-- Divider -->
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-gray-100"></div></div>
                <div class="relative flex justify-center text-[10px] tracking-wider uppercase">
                    <span class="bg-white px-3 text-gray-400 font-medium">or</span>
                </div>
            </div>

            <!-- Social / Secondary Logins -->
            <div class="space-y-2.5">
                <button type="button" class="w-full py-2.5 px-4 bg-white hover:bg-gray-50 text-gray-700 font-medium text-xs rounded-full border border-gray-200 transition-colors flex items-center justify-center gap-2.5 shadow-sm">
                    <svg class="w-4 h-4" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/></svg>
                    Continue with Google
                </button>

                <button type="button" class="w-full py-2.5 px-4 bg-white hover:bg-gray-50 text-gray-700 font-medium text-xs rounded-full border border-gray-200 transition-colors flex items-center justify-center gap-2 shadow-sm">
                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4"></path></svg>
                    Sign in with passkey
                </button>
            </div>

            <!-- Footer Link -->
            <p class="text-center text-xs text-gray-500 mt-6">
                Don't have an account? 
                <a href="{{ route('register') }}" class="font-semibold text-orange-500 hover:text-orange-600">Sign up</a>
            </p>

        </div>
    </div>
</x-sandbox-layout>