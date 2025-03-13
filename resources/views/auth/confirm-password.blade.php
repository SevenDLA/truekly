<x-guest-layout>
    <div class="container h-100">
        <div class="row justify-content-center align-items-center h-100">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-lg rounded-lg">
                    <div class="card-body p-5">
                        <!-- Session Status -->
                        <x-auth-session-status class="alert alert-success mb-4" :status="session('status')" />

                        <div class="text-center mb-4">
                            <h2 class="fw-bold text-primary">Confirmar Contraseña</h2>
                        </div>

                        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Esta es una área segura de la aplicación. Por favor, confirma tu contraseña antes de continuar.') }}
                        </div>

                        <form method="POST" action="{{ route('password.confirm') }}">
                            @csrf

                            <!-- Password -->
                            <div class="mb-4">
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

                            <!-- Confirm Button -->
                            <div class="d-flex justify-content-center mt-4">
                                <x-primary-button class="btn btn-primary w-100">
                                    {{ __('Confirmar') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
