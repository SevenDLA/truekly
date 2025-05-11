@extends('layout')

@section('title', $tipo_oper)

@section('content')
    <div class="container mt-5">
        <div class="card shadow-lg p-4 rounded">
            <h2 class="text-center mb-4">{{ $tipo_oper }}</h2>

            <form method="POST" action="{{ route('service.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id_servicio" value="{{ $servicio->id }}" />

                <!-- Título -->
                <div class="mb-3">
                    <label for="title" class="form-label fw-bold">Título</label>
                    <input type="text" name="title" class="form-control" id="title" placeholder="Título del servicio" value="{{ old('title', $servicio->title) }}">
                    @error('title') <p class="text-danger small">{{ $message }}</p> @enderror
                </div>

                <!-- Imagen -->
                <div class="mb-3">
                    <label for="image" class="form-label fw-bold">Imagen</label>
                    <input type="file" name="image" class="form-control" id="image">
                    @error('image') <p class="text-danger small">{{ $message }}</p> @enderror
                </div>

                <!-- Descripción -->
                <div class="mb-3">
                    <label for="description" class="form-label fw-bold">Descripción</label>
                    <textarea name="description" class="form-control" id="description" placeholder="Descripción del servicio" rows="4">{{ old('description', $servicio->description) }}</textarea>
                    @error('description') <p class="text-danger small">{{ $message }}</p> @enderror
                </div>

                <!-- Precio -->
                <div class="mb-3">
                    <label for="price" class="form-label fw-bold">Precio (TokenSkills)</label>
                    <input type="number" name="price" class="form-control" id="price" placeholder="TokenSkills" value="{{ old('price', $servicio->price) }}">
                    @error('price') <p class="text-danger small">{{ $message }}</p> @enderror
                </div>

                <!-- Stock -->
                <div class="mb-3">
                    <label for="stock" class="form-label fw-bold">Stock</label>
                    <input type="number" name="stock" class="form-control" id="stock" placeholder="Stock de tu servicio" value="{{ old('stock', $servicio->stock) }}">
                    @error('stock') <p class="text-danger small">{{ $message }}</p> @enderror
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
                                        ($servicio->contact && $servicio->contact == $clave_contact) 
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
                                    old('category') == $clave_category || $servicio->category == $clave_category
                                        ? 'selected="selected"'
                                        : '';
                            @endphp
                            <option value="{{ $clave_category }}" {{ $selected }}>{{ $texto_category }}</option>
                        @endforeach
                    </select>
                    @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <!-- Botón de enviar -->
                <div class="text-center">
                    <button type="submit" class="btn btn-primary px-4">Guardar</button>
                </div>
            </form>
        </div>
        <br>
    </div>
@endsection
