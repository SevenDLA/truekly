@extends('layouts.admin')

@section('title', $oper == 'new' ? 'Nuevo Servicio' : ($oper == 'modi' ? 'Editar Servicio' : 'Eliminar Servicio'))

@section('content')
    <div class="container-fluid px-4">
        <h1 class="mt-4">Gestión de Servicios</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="{{ route('services.admin.listado') }}">Servicios</a></li>
            <li class="breadcrumb-item active">
                @if ($oper == 'supr')
                    Eliminar Servicio
                @elseif ($oper == 'cons')
                    Detalles de Servicio
                @else
                    {{ $service->id ? 'Editar Servicio' : 'Nuevo Servicio' }}
                @endif
            </li>
        </ol>

        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <i class="fas fa-cogs me-2"></i>
                @if ($oper == 'supr')
                    Eliminar Servicio
                @elseif ($oper == 'cons')
                    Detalles de Servicio
                @else
                    {{ $service->id ? 'Editar Servicio' : 'Nuevo Servicio' }}
                @endif
            </div>
            <div class="card-body">

                    @php
                        if (session('formData')) {
                            $user = session('formData');
                        }

                        $disabled = '';
                        $boton_guardar = '<button type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>Guardar</button>';
                        
                        // Campos se deshabilitan en estos casos:
                        if (session('formData') || $oper == 'cons' || $oper == 'supr') {
                            $disabled = 'disabled';

                            if ($oper == 'supr') {
                                $boton_guardar = '<button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt me-2"></i>Eliminar</button>';
                            } else {
                                $boton_guardar = '';
                            }
                        }
                    @endphp

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('admin.services.almacenar') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="oper" value="{{ $oper }}">
                    <input type="hidden" name="id" value="{{ $service->id }}">

                    <div class="row g-3">
                        <!-- Sección izquierda -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="title" class="form-label">Título</label>
                                <input {{ $disabled }} type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                    id="title" value="{{ old('title', $service->title) }}">
                                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Descripción</label>
                                <textarea {{ $disabled }} name="description" class="form-control @error('description') is-invalid @enderror"
                                    id="description" rows="4">{{ old('description', $service->description) }}</textarea>
                                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label for="price" class="form-label">TokenSkills</label>
                                <input {{ $disabled }} type="number" name="price" class="form-control @error('price') is-invalid @enderror"
                                    id="price" value="{{ old('price', $service->price) }}">
                                @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label for="stock" class="form-label">Stock</label>
                                <input {{ $disabled }} type="number" name="stock" class="form-control @error('stock') is-invalid @enderror"
                                    id="stock" value="{{ old('stock', $service->stock) }}">
                                @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <!-- Sección derecha -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="image" class="form-label">Imagen</label>
                                <input {{ $disabled }} type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                                    id="image">
                                @if ($service->image)
                                    <img src="{{ asset('storage/' . $service->image) }}" alt="Imagen del servicio" class="mt-2" width="200">
                                @endif
                                @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                                <!-- Contacto -->
                        <div class="mb-3">
                            <label for="contact" class="form-label fw-bold">Tipo de Contacto</label>
                            <select name="contact" id="contact" class="form-select @error('contact') is-invalid @enderror">
                                <option value="">Selecciona un tipo de contacto...</option>
                                @foreach ($CONTACT as $clave_contact => $texto_contact)
                                    @if ($clave_contact != 'P')
                                        @php
                                            $selected = 
                                                (old('contact') && old('contact') == $clave_contact) || 
                                                ($service->contact && $service->contact == $clave_contact) 
                                                    ? 'selected="selected"'
                                                    : '';
                                        @endphp
                                        <option value="{{ $clave_contact }}" {{ $selected }}>{{ $texto_contact }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('contact')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <!--Categoría-->
                        <div class="mb-3">
                            <label for="category" class="form-label fw-bold">Categoría</label>
                            <select name="category" id="category" class="form-select @error('category') is-invalid @enderror">
                                <option value="">Selecciona una categoría...</option>
                                @foreach ($CATEGORY as $clave_category => $texto_category)
                                    @php
                                        $selected =
                                            old('category') == $clave_category || $service->category == $clave_category
                                                ? 'selected="selected"'
                                                : '';
                                    @endphp
                                    <option value="{{ $clave_category }}" {{ $selected }}>{{ $texto_category }}</option>
                                @endforeach
                            </select>
                            @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('services.admin.listado') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i> Volver
                        </a>
                        {!! $boton_guardar !!}
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
