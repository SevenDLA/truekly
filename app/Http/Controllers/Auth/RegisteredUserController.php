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

    $rules = [
        'name'            => ['required', 'string', 'max:255'],
        'surname'         => ['required', 'string', 'max:255'],
        'username'        => ['required', 'string', 'max:255', 'unique:users,username'],
        'email'           => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
        'sex'             => ['required', 'in:' . $validacion_sex],
        'date_of_birth'   => ['required', 'date_format:Y-m-d'],
        'phone_number'    => ['required', 'numeric', 'digits:10'],
        'password'        => ['required', 'confirmed', Rules\Password::defaults()],
    ];

    $messages = [
        'name.required'             => 'El nombre es obligatorio.',
        'surname.required'          => 'Los apellidos son obligatorios.',
        'username.required'         => 'El nombre de usuario es obligatorio.',
        'username.unique'           => 'Este nombre de usuario ya está en uso.',
        'email.required'            => 'El correo electrónico es obligatorio.',
        'email.email'               => 'Introduce un correo electrónico válido.',
        'email.unique'              => 'Este correo ya está registrado.',
        'sex.required'              => 'El sexo es obligatorio.',
        'sex.in'                    => 'Selecciona una opción válida para el sexo.',
        'date_of_birth.required'    => 'La fecha de nacimiento es obligatoria.',
        'date_of_birth.date_format' => 'La fecha de nacimiento debe tener el formato YYYY-MM-DD.',
        'phone_number.required'     => 'El número de teléfono es obligatorio.',
        'phone_number.numeric'      => 'El número de teléfono debe contener solo números.',
        'phone_number.digits'       => 'El número de teléfono debe tener exactamente 10 dígitos.',
        'password.required'         => 'La contraseña es obligatoria.',
        'password.confirmed'        => 'La confirmación de la contraseña no coincide.',
        'password.min'              => 'La contraseña debe tener al menos 8 caracteres.'
    ];

    $validated = $request->validate($rules, $messages);

    $user = User::create([
        'name'           => $validated['name'],
        'surname'        => $validated['surname'],
        'username'       => $validated['username'],
        'email'          => $validated['email'],
        'sex'            => $validated['sex'],
        'date_of_birth'  => $validated['date_of_birth'],
        'phone_number'   => $validated['phone_number'],
        'password'       => Hash::make($validated['password']),
        'tokens'         => 0,
    ]);

    event(new Registered($user));

    Auth::guard('web')->login($user);

    return redirect(route('profile.normal', absolute: false));
}
}
