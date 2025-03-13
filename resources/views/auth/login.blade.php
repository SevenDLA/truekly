<x-guest-layout>
    <div class="container">
        <div class="row justify-content-center min-vh-100 align-items-center">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-lg rounded-lg">
                    <div class="card-body p-5">
                        <!-- Session Status -->
                        <x-auth-session-status class="alert alert-success mb-4" :status="session('status')" />

                        <div class="text-center mb-5">
                            <img src="{{ asset('images/truekly.png') }}" class="img-fluid" />
                        </div>

                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <!-- Email or Username -->
                            <div class="mb-4">
                                <x-input-label for="login" :value="__('Email o Usuario')" class="form-label" />
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <x-text-input id="login" 
                                                  class="form-control @error('login') is-invalid @enderror" 
                                                  type="text" 
                                                  name="login" 
                                                  :value="old('login')" 
                                                  required 
                                                  autofocus 
                                                  autocomplete="username" />
                                </div>
                                <x-input-error :messages="$errors->get('login')" class="invalid-feedback" />
                            </div>

                            <!-- Password -->
                            <div class="mb-5">
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
                                                  autocomplete="current-password" />
                                </div>
                                <x-input-error :messages="$errors->get('password')" class="invalid-feedback" />
                            </div>

                            <!-- Links and Button -->
                            <div class="d-flex justify-content-between align-items-center mt-4">
                                @if (Route::has('password.request'))
                                    <a class="text-decoration-none text-primary" href="{{ route('password.request') }}">
                                        {{ __('¿Olvidaste tu contraseña?') }}
                                    </a>
                                @endif

                                @if (Route::has('registrarse'))
                                    <a class="text-decoration-none text-primary ms-3" href="{{ route('registrarse') }}">
                                        {{ __('Registrarse') }}
                                    </a>
                                @endif
                            </div>

                            <div class="d-flex justify-content-center mt-4">
                                <x-primary-button class="btn btn-primary w-100">
                                    <i class="fas fa-sign-in-alt me-2"></i>{{ __('Iniciar sesión') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
