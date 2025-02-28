@extends('layout')


@section('title', 'Alta de user')

@section('content')


    @php

        if (session('formData'))
            $user = session('formData');

        $disabled = '';
        $boton_guardar = '<button type="submit" class="btn btn-primary">Guardar</button>';
        if (session('formData') || $oper == 'cons' || $oper == 'supr')
        {
            $disabled = 'disabled';

            if ($oper == 'supr')
                $boton_guardar = '<button type="submit" class="btn btn-danger">Eliminar</button>';
            else
                $boton_guardar = '';
        }
            



    @endphp

    <br />
    @if(session('success'))
        <p style="text-align:center;" class="alert alert-success">{{ session('success') }}</p>
    @endif
    
    <form action="{{ route('users.almacenar') }}" method="POST">
        @csrf
        <input type="hidden" name="oper" value="{{ $oper }}" />
        <input type="hidden" name="id" value="{{ $user->id }}" />
        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input {{ $disabled }} type="text" name="name" class="form-control" id="name" value="{{ old('name',$user->name)}}" placeholder="Nombre">
            @error('name') <p style="color: red;">{{ $message }}</p> @enderror
        </div>
        <div class="mb-3">
            <label for="surname" class="form-label">Apellidos</label>
            <input {{ $disabled }}  type="text" name="surname" class="form-control" id="surname" value="{{ old('surname',$user->surname)}}" placeholder="Apellidos">
            @error('surname') <p style="color: red;">{{ $message }}</p> @enderror
        </div>
        <div class="mb-3">
            <label for="username" class="form-label">Nombre de usuario</label>
            <input {{ $disabled }}  type="text" name="username" class="form-control" id="username"  value="{{ old('username',$user->username)}}" placeholder="Nombre de usuario">
            @error('username') <p style="color: red;">{{ $message }}</p> @enderror
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <input {{ $disabled }}  type="text" name="email" class="form-control" id="email"  value="{{ old('email',$user->email)}}" placeholder="Correo electrónico">
            @error('email') <p style="color: red;">{{ $message }}</p> @enderror
        </div>
        <div class="mb-3">
            <label for="sex" class="form-label">Sexo</label>
            <select {{ $disabled }}  name="sex" id="sex" class="form-select form-select-sm" aria-label=".form-select-sm example">
                <option value="">Selecciona un sexo...</option>
                @foreach ($SEX as $clave_sex => $texto_sex)

                    @php
                        $selected = old('sex') == $clave_sex || $user->sex == $clave_sex ? 'selected="selected"' : '';
                    @endphp
        
    
        
                    <option value="{{ $clave_sex }}" {{ $selected }}>{{ $texto_sex }}</option>

                @endforeach
            </select>
            @error('sex') <p style="color: red;">{{ $message }}</p> @enderror
        </div>
        <div class="mb-3">
            <label for="date_of_birth" class="form-label">Fecha de nacimiento</label>
            <input {{ $disabled }}  type="text" name="date_of_birth" class="form-control" id="date_of_birth"  value="{{ old('date_of_birth',$user->date_of_birth)}}" placeholder="Fecha de nacimiento">
            @error('date_of_birth') <p style="color: red;">{{ $message }}</p> @enderror
        </div>
        <div class="mb-3">
            <label for="phone_number" class="form-label">Número de teléfono</label>
            <input {{ $disabled }}  type="text" name="phone_number" class="form-control" id="phone_number"  value="{{ old('phone_number',$user->phone_number)}}" placeholder="Número de teléfono">
            @error('phone_number') <p style="color: red;">{{ $message }}</p> @enderror
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input {{ $disabled }}  type="text" name="password" class="form-control" id="password"  value="{{ old('password',$user->password)}}" placeholder="Contraseña">
            @error('password') <p style="color: red;">{{ $message }}</p> @enderror
        </div>
        @php

        echo $boton_guardar ;
    
        @endphp

    </form>

@endsection


