<x-guest-layout>
    <div class="container">
        <div class="row justify-content-center min-vh-100 align-items-center">
            <div class="col-md-8 col-lg-6">
                <div class="card shadow-lg rounded-lg">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <img src="{{ asset('images/truekly.png') }}" class="img-fluid w-75" />
                        </div>

                        <form method="POST" action="{{ route('registrarse') }}">
                            @csrf
                            <input type="hidden" name="oper" value="registrarse" />

                            <!-- Nombre -->
                            <div class="mb-3">
                                <x-input-label for="name" :value="__('Nombre')" class="form-label" />
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <x-text-input id="name" class="form-control @error('name') is-invalid @enderror" 
                                                  type="text" name="name" :value="old('name')" required />
                                </div>
                                <x-input-error :messages="$errors->get('name')" class="invalid-feedback" />
                            </div>

                            <!-- Apellidos -->
                            <div class="mb-3">
                                <x-input-label for="surname" :value="__('Apellidos')" class="form-label" />
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-users"></i>
                                    </span>
                                    <x-text-input id="surname" class="form-control @error('surname') is-invalid @enderror" 
                                                  type="text" name="surname" :value="old('surname')" required />
                                </div>
                                <x-input-error :messages="$errors->get('surname')" class="invalid-feedback" />
                            </div>

                            <!-- Nombre de usuario -->
                            <div class="mb-3">
                                <x-input-label for="username" :value="__('Nombre de usuario')" class="form-label" />
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-at"></i>
                                    </span>
                                    <x-text-input id="username" class="form-control @error('username') is-invalid @enderror" 
                                                  type="text" name="username" :value="old('username')" required />
                                </div>
                                <x-input-error :messages="$errors->get('username')" class="invalid-feedback" />
                            </div>

                            <!-- Sexo -->
                            <div class="mb-3">
                                <x-input-label for="sex" :value="__('Sexo')" class="form-label" />
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-venus-mars"></i>
                                    </span>
                                    <select id="sex" name="sex" class="form-select @error('sex') is-invalid @enderror" required>
                                        <option value="">Selecciona...</option>
                                        @foreach ($SEX as $clave_sex => $texto_sex)
                                            <option value="{{ $clave_sex }}" {{ old('sex') == $clave_sex ? 'selected' : '' }}>
                                                {{ $texto_sex }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <x-input-error :messages="$errors->get('sex')" class="invalid-feedback" />
                            </div>

                            <!-- Fecha de nacimiento -->
                            <div class="mb-3">
                                <x-input-label for="date_of_birth" :value="__('Fecha de nacimiento')" class="form-label" />
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-calendar-alt"></i>
                                    </span>
                                    <x-text-input id="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror" 
                                                  type="text" name="date_of_birth" :value="old('date_of_birth')" placeholder="DD/MM/YYYY" required />
                                </div>
                                <x-input-error :messages="$errors->get('date_of_birth')" class="invalid-feedback" />
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <x-input-label for="email" :value="__('Email')" class="form-label" />
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                    <x-text-input id="email" class="form-control @error('email') is-invalid @enderror" 
                                                  type="email" name="email" :value="old('email')" required />
                                </div>
                                <x-input-error :messages="$errors->get('email')" class="invalid-feedback" />
                            </div>

                            <!-- Teléfono -->
                            <div class="mb-3">
                                <x-input-label for="phone_number" :value="__('Número de teléfono')" class="form-label" />
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-phone"></i>
                                    </span>
                                    <x-text-input id="phone_number" class="form-control @error('phone_number') is-invalid @enderror" 
                                                  type="text" name="phone_number" :value="old('phone_number')" required />
                                </div>
                                <x-input-error :messages="$errors->get('phone_number')" class="invalid-feedback" />
                            </div>

                            <!-- Contraseña -->
                            <div class="mb-4">
                                <x-input-label for="password" :value="__('Contraseña')" class="form-label" />
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <x-text-input id="password" class="form-control @error('password') is-invalid @enderror" 
                                                  type="password" name="password" required />
                                </div>
                                <x-input-error :messages="$errors->get('password')" class="invalid-feedback" />
                            </div>

                            <!-- Botón de envío -->
                            <div class="d-flex justify-content-center mt-4">
                                <x-primary-button class="btn btn-primary w-100">
                                    <i class="fas fa-save me-2"></i>{{ __('Registrarse') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
