<x-guest-layout>
    <div class="container h-100">
        <div class="row justify-content-center align-items-center h-100">
            <div class="col-md-6 col-lg-4">
                <div class="card shadow-lg rounded-lg">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <h2 class="fw-bold text-primary">Verificación de Email</h2>
                        </div>

                        <!-- Informative message -->
                        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('¡Gracias por registrarte! Antes de comenzar, ¿podrías verificar tu dirección de correo electrónico haciendo clic en el enlace que te acabamos de enviar? Si no recibiste el correo, con gusto te enviaremos otro.') }}
                        </div>

                        <!-- Status message if email link is sent -->
                        @if (session('status') == 'verification-link-sent')
                            <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                                {{ __('Se ha enviado un nuevo enlace de verificación al correo electrónico que proporcionaste durante el registro.') }}
                            </div>
                        @endif

                        <div class="mt-4">
                            <div class="d-flex justify-content-between">
                                <!-- Resend Verification Email -->
                                <form method="POST" action="{{ route('verification.send') }}">
                                    @csrf
                                    <x-primary-button class="btn btn-primary w-100">
                                        <i class="fas fa-envelope me-2"></i>{{ __('Reenviar correo de verificación') }}
                                    </x-primary-button>
                                </form>

                                <!-- Log out button -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-link text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                                        <i class="fas fa-sign-out-alt me-2"></i>{{ __('Cerrar sesión') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
