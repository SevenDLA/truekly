@extends('layout')

@section('title', $tipo_oper)

@section('content')
    <div class="container mt-5">
        <div class="card shadow-lg p-4 rounded">
            <h2 class="text-center mb-4">{{ $tipo_oper }}</h2>

            <form method="POST" action="{{ route('service.store') }}">
                @csrf
                <input type="hidden" name="id_servicio" value="{{ $servicio->id }}" />
                <!-- Título -->
                <div class="mb-3">
                    <label for="id" class="form-label fw-bold">ID</label>
                    <input type="text" name="id" class="form-control" id="id" placeholder="Título del servicio" value="{{ old('id', $servicio->id) }}">
                    @error('id') <p class="text-danger small">{{ $message }}</p> @enderror
                </div>
                <div class="mb-3">
                    <label for="user_id" class="form-label fw-bold">User ID</label>
                    <input type="text" name="user_id" class="form-control" id="user_id" placeholder="Título del servicio" value="{{ old('user_id', $servicio->user_id) }}">
                    @error('user_id') <p class="text-danger small">{{ $message }}</p> @enderror
                </div>
                <!-- Título -->
                <div class="mb-3">
                    <label for="title" class="form-label fw-bold">Título</label>
                    <input type="text" name="title" class="form-control" id="title" placeholder="Título del servicio" value="{{ old('title', $servicio->title) }}">
                    @error('title') <p class="text-danger small">{{ $message }}</p> @enderror
                </div>

                <!-- Descripción -->
                <div class="mb-3">
                    <label for="description" class="form-label fw-bold">Descripción</label>
                    <textarea name="description" class="form-control" id="description" placeholder="Descripción del servicio" rows="4">{{ old('description', $servicio->description) }}</textarea>
                    @error('description') <p class="text-danger small">{{ $message }}</p> @enderror
                </div>

                <!-- Precio -->
                <div class="mb-3">
                    <label for="price" class="form-label fw-bold">Precio ($)</label>
                    <input type="number" name="price" class="form-control" id="price" placeholder="Precio en $" value="{{ old('price', $servicio->price) }}">
                    @error('price') <p class="text-danger small">{{ $message }}</p> @enderror
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label fw-bold">Imagen</label>
                    <input type="text" name="image" class="form-control" id="image" placeholder="Título del servicio" value="{{ old('image', $servicio->image) }}">
                    @error('image') <p class="text-danger small">{{ $message }}</p> @enderror
                </div>
                <!-- Stock -->
                <div class="mb-3">
                    <label for="stock" class="form-label fw-bold">Stock</label>
                    <input type="number" name="stock" class="form-control" id="stock" placeholder="Stock de tu servicio" value="{{ old('stock', $servicio->stock) }}">
                    @error('stock') <p class="text-danger small">{{ $message }}</p> @enderror
                </div>
                <div class="mb-3">
                    <label for="created_at" class="form-label fw-bold">Fecha de creación</label>
                    <input type="text" name="created_at" class="form-control" id="created_at" placeholder="Título del servicio" value="{{ old('created_at', $servicio->created_at) }}">
                    @error('created_at') <p class="text-danger small">{{ $message }}</p> @enderror
                </div>
                <div class="mb-3">
                    <label for="updated_at" class="form-label fw-bold">Última actualización</label>
                    <input type="text" name="updated_at" class="form-control" id="updated_at" placeholder="Título del servicio" value="{{ old('updated_at', $servicio->updated_at) }}">
                    @error('updated_at') <p class="text-danger small">{{ $message }}</p> @enderror
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