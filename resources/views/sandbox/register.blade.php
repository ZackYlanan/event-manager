<x-sandbox-layout>
    <div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-[#FFFDF9] via-[#FFF5EB] to-[#FFE8D6] p-4 py-8 font-sans text-gray-900">
        
        <div class="w-full max-w-[420px] bg-white rounded-[28px] p-8 shadow-[0_10px_40px_rgba(0,0,0,0.05)] border border-orange-50/60">
            
            <div class="flex flex-col items-center mb-6">
                <div class="flex items-center gap-2.5 mb-3">
                    <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-amber-500 to-orange-500 flex items-center justify-center text-white shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <span class="text-2xl font-bold tracking-tight text-orange-500">vento</span>
                </div>
                <h1 class="text-lg font-extrabold tracking-tight text-gray-900 uppercase">Register Account</h1>
                <p class="text-[11px] text-gray-500 mt-1">Please enter your fill up to create account.</p>
            </div>

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

                <button type="submit" class="w-full mt-2 py-2.5 px-4 bg-gradient-to-r from-[#F5A623] to-[#FF5722] hover:from-[#e0961f] hover:to-[#e64e1e] text-white font-bold text-xs rounded-full shadow-lg shadow-orange-500/25 transition-all uppercase tracking-wide cursor-pointer">
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

        </div>
    </div>
</x-sandbox-layout>