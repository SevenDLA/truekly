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

        $validacion_sex = '';
            foreach(User::SEX as $codigo_sex => $texto_sex)
            {
                $validacion_sex .= $codigo_sex .',';
            }

            $validacion_sex = substr($validacion_sex,0,-1);

        $request->validate([
            'name'            => ['required', 'string', 'max:255'],
            'surname'         => ['required', 'string', 'max:255'],
            'username'        => ['required', 'string'],
            'email'           => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'sex'             => ['required', 'in:' .$validacion_sex],
            'date_of_birth'   => ['required', 'string'],
            'phone_number'    => ['required', 'string'],
            'password'        => ['required'],
        ]);

        $user = User::create([
            'name'           => $request->name,
            'surname'        => $request->surname,
            'username'       => $request->username,
            'email'          => $request->email,
            'sex'            => $request->sex,
            'date_of_birth'  => $request->date_of_birth,
            'phone_number'   => $request->phone_number,
            'password'       => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
