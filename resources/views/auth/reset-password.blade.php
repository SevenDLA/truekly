<x-guest-layout>
    <div class="container h-100">
        <div class="row justify-content-center align-items-center h-100">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-lg rounded-lg">
                    <div class="card-body p-5">
                        <!-- Session Status -->
                        <x-auth-session-status class="alert alert-success mb-4" :status="session('status')" />

                        <div class="text-center mb-4">
                            <h2 class="fw-bold text-primary">Restablecer Contraseña</h2>
                        </div>

                        <form method="POST" action="{{ route('password.store') }}">
                            @csrf

                            <!-- Password Reset Token -->
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">

                            <!-- Email Address -->
                            <div class="mb-4">
                                <x-input-label for="email" :value="__('Email')" class="form-label" />
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <x-text-input id="email" 
                                                  class="form-control @error('email') is-invalid @enderror" 
                                                  type="email" 
                                                  name="email" 
                                                  :value="old('email', $request->email)" 
                                                  required 
                                                  autofocus 
                                                  autocomplete="username" />
                                </div>
                                <x-input-error :messages="$errors->get('email')" class="invalid-feedback" />
                            </div>

                            <!-- Password -->
                            <div class="mt-4 mb-4">
                                <x-input-label for="password" :value="__('Contraseña')" class="form-label" />
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <x-text-input id="password" 
                                                  class="form-control @error('password') is-invalid @enderror" 
                                                  type="password" 
                                                  name="password" 
                                                  required 
                                                  autocomplete="new-password" />
                                </div>
                                <x-input-error :messages="$errors->get('password')" class="invalid-feedback" />
                            </div>

                            <!-- Confirm Password -->
                            <div class="mt-4 mb-4">
                                <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" class="form-label" />
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <x-text-input id="password_confirmation" 
                                                  class="form-control @error('password_confirmation') is-invalid @enderror" 
                                                  type="password" 
                                                  name="password_confirmation" 
                                                  required 
                                                  autocomplete="new-password" />
                                </div>
                                <x-input-error :messages="$errors->get('password_confirmation')" class="invalid-feedback" />
                            </div>

                            <!-- Reset Button -->
                            <div class="d-flex justify-content-center mt-4">
                                <x-primary-button class="btn btn-primary w-100">
                                    {{ __('Restablecer Contraseña') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
