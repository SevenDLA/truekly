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
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $SEX = User::SEX;

        return view('auth.register', compact('SEX'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validacion_sex = implode(',', array_keys(User::SEX));

        $validated = $request->validate([
            'name'            => ['required', 'string', 'max:255'],
            'surname'         => ['required', 'string', 'max:255'],
            'username'        => ['required', 'string', 'max:255', 'unique:'.User::class],
            'email'           => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'sex'             => ['required', 'in:'.$validacion_sex],
            'date_of_birth'   => ['required', 'date_format:Y-m-d'],
            'phone_number'    => ['required', 'numeric', 'digits:10'],
            'password'        => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name'          => $validated['name'],
            'surname'       => $validated['surname'],
            'username'      => $validated['username'],
            'email'         => $validated['email'],
            'sex'          => $validated['sex'],
            'date_of_birth' => $validated['date_of_birth'],
            'phone_number'  => $validated['phone_number'],
            'password'      => Hash::make($validated['password']),
            'tokens'        => 0,
        ]);

        event(new Registered($user));

        Auth::guard('web')->login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
