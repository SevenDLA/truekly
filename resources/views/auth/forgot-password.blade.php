<x-guest-layout>
    <div class="container ">
        <div class="row justify-content-center min-vh-100 align-items-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow rounded border-0">
                    <div class="card-body p-4">
                        <!-- Logo -->
                        <div class="text-center mb-4">
                            <img src="{{ asset('images/truekly.png') }}" class="img-fluid w-75" />
                        </div>

                        <!-- Mensaje informativo -->
                        <p class="text-center text-muted">
                            {{ __('¿Olvidaste tu contraseña? Ingresa tu correo y te enviaremos un enlace para restablecerla.') }}
                        </p>

                        <!-- Session Status -->
                        <x-auth-session-status class="alert alert-success mb-3" :status="session('status')" />

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <!-- Email Address -->
                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-2"></i>{{ __('Correo electrónico') }}
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-at"></i>
                                    </span>
                                    <x-text-input id="email" 
                                                  class="form-control @error('email') is-invalid @enderror" 
                                                  type="email" 
                                                  name="email" 
                                                  :value="old('email')" 
                                                  required 
                                                  autofocus />
                                </div>
                                <x-input-error :messages="$errors->get('email')" class="invalid-feedback" />
                            </div>

                            <!-- Botón de envío -->
                            <div class="d-grid mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane me-2"></i>{{ __('Enviar enlace de recuperación') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
