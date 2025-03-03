<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <input type="hidden" name="oper" value="register" />
        
        <!--Nombre-->
        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" name="name" class="form-control" id="name" placeholder="Nombre" value="{{ old('name') }}">
            @error('name') <p style="color: red;">{{ $message }}</p> @enderror
        </div>

        <!--Apellidos-->
        <div class="mb-3">
            <label for="surname" class="form-label">Apellidos</label>
            <input type="text" name="surname" class="form-control" id="surname" placeholder="Apellidos" value="{{ old('surname') }}">
            @error('surname') <p style="color: red;">{{ $message }}</p> @enderror
        </div>

        <!--Nombre de usuario-->
        <div class="mb-3">
            <label for="username" class="form-label">Nombre de usuario</label>
            <input type="text" name="username" class="form-control" id="username" placeholder="Nombre de usuario" value="{{ old('username') }}">
            @error('username') <p style="color: red;">{{ $message }}</p> @enderror
        </div>

        <!--Sexo-->
        <div class="mb-3">
            <label for="sex" class="form-label">Sexo</label>
            <select name="sex" id="sex" class="form-select form-select-sm" aria-label=".form-select-sm example">
                <option value="">Selecciona un sexo...</option>
                @foreach ($SEX as $clave_sex => $texto_sex)
                    <option value="{{ $clave_sex }}" {{ old('sex') == $clave_sex ? 'selected' : '' }}>{{ $texto_sex }}</option>
                @endforeach
            </select>
            @error('sex') <p style="color: red;">{{ $message }}</p> @enderror
        </div>

        <!--Fecha de nacimiento-->
        <div class="mb-3">
            <label for="date_of_birth" class="form-label">Fecha de nacimiento</label>
            <input type="text" name="date_of_birth" class="form-control" id="date_of_birth" placeholder="DD/MM/YYYY" value="{{ old('date_of_birth') }}">
            @error('date_of_birth') <p style="color: red;">{{ $message }}</p> @enderror
        </div>

        <!--Email-->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="text" name="email" class="form-control" id="email" placeholder="Email" value="{{ old('email') }}">
            @error('email') <p style="color: red;">{{ $message }}</p> @enderror
        </div>

        <!--Número de teléfono-->
        <div class="mb-3">
            <label for="phone_number" class="form-label">Número de teléfono</label>
            <input type="text" name="phone_number" class="form-control" id="phone_number" placeholder="Número de teléfono" value="{{ old('phone_number') }}">
            @error('phone_number') <p style="color: red;">{{ $message }}</p> @enderror
        </div>

        <!--Contraseña-->
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="Contraseña">
            @error('password') <p style="color: red;">{{ $message }}</p> @enderror
        </div>
        
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</x-guest-layout>
