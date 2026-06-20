<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],

            // this is unique to ensure that no two student has same student id
            'student_id' => ['required', 'string', 'max:50', 'unique:users,student_id'],

            // added this course_id so we can group the students based on their course someday
            'course' => ['required', 'string', 'max:100'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),

            // the custom form fields
            'student_id' => $request->student_id,
            'course' => $request->course,

            'role' => 'student', //set student as default role so it will stop public from accessing admin page
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('events.directory');
    }
}
