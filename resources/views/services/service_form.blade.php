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

                <!-- Botón de enviar -->
                <div class="text-center">
                    <button type="submit" class="btn btn-primary px-4">Guardar</button>
                </div>
            </form>
        </div>
        <br>
    </div>
@endsection