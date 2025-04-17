@extends('layout')

@section('title', 'Alta de user')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Gestión de Usuarios</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Usuarios</li>
    </ol>
<div class="container-fluid px-4">
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <i class="fas fa-user-circle me-2"></i>
            @if($oper == 'supr')
                Eliminar Usuario
            @elseif($oper == 'cons')
                Detalles de Usuario
            @else
                {{ $user->id ? 'Editar Usuario' : 'Nuevo Usuario' }}
            @endif
        </div>
        <div class="card-body">

            @php
                if (session('formData'))
                    $user = session('formData');

                $disabled = '';
                $boton_guardar = '<button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Guardar</button>';
                if (session('formData') || $oper == 'cons' || $oper == 'supr')
                {
                    $disabled = 'disabled';

                    if ($oper == 'supr')
                        $boton_guardar = '<button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt me-2"></i>Eliminar</button>';
                    else
                        $boton_guardar = '';
                }
            @endphp

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            <form action="{{ route('users.almacenar') }}" method="POST">
                @csrf
                <input type="hidden" name="oper" value="{{ $oper }}" />
                <input type="hidden" name="id" value="{{ $user->id }}" />

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre</label>
                            <input {{ $disabled }} type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name',$user->name)}}" placeholder="Nombre">
                            @error('name') 
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="surname" class="form-label">Apellidos</label>
                            <input {{ $disabled }} type="text" name="surname" class="form-control @error('surname') is-invalid @enderror" id="surname" value="{{ old('surname',$user->surname)}}" placeholder="Apellidos">
                            @error('surname') 
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="username" class="form-label">Nombre de usuario</label>
                            <input {{ $disabled }} type="text" name="username" class="form-control @error('username') is-invalid @enderror" id="username" value="{{ old('username',$user->username)}}" placeholder="Nombre de usuario">
                            @error('username') 
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Correo electrónico</label>
                            <input {{ $disabled }} type="text" name="email" class="form-control @error('email') is-invalid @enderror" id="email" value="{{ old('email',$user->email)}}" placeholder="Correo electrónico">
                            @error('email') 
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="sex" class="form-label">Sexo</label>
                            <select {{ $disabled }} name="sex" id="sex" class="form-select @error('sex') is-invalid @enderror">
                                <option value="">Selecciona un sexo...</option>
                                @foreach ($SEX as $clave_sex => $texto_sex)
                                    @php
                                        $selected = old('sex') == $clave_sex || $user->sex == $clave_sex ? 'selected="selected"' : '';
                                    @endphp
                                    <option value="{{ $clave_sex }}" {{ $selected }}>{{ $texto_sex }}</option>
                                @endforeach
                            </select>
                            @error('sex') 
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="date_of_birth" class="form-label">Fecha de nacimiento</label>
                            <input {{ $disabled }} type="text" name="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror" id="date_of_birth" value="{{ old('date_of_birth',$user->date_of_birth)}}" placeholder="Fecha de nacimiento">
                            @error('date_of_birth') 
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Número de teléfono</label>
                            <input {{ $disabled }} type="text" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror" id="phone_number" value="{{ old('phone_number',$user->phone_number)}}" placeholder="Número de teléfono">
                            @error('phone_number') 
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input {{ $disabled }} type="text" name="password" class="form-control @error('password') is-invalid @enderror" id="password" value="{{ old('password',$user->password)}}" placeholder="Contraseña">
                            @error('password') 
                                <div class="invalid-feedback">
                                    <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('users.listado') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Volver
                    </a>
                    {!! $boton_guardar !!}
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection