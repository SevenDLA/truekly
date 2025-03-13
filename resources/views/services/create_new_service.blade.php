@extends('layout')

@section('title', 'Nuevo servicio')

@section('content')
    <div class="container mt-5">
        <div class="card shadow-lg p-4 rounded">
            <h2 class="text-center mb-4">Crear Nuevo Servicio</h2>

            <form method="POST" action="">
                @csrf
                <input type="hidden" name="oper" value="create_service" />
                <input type="hidden" name="id_usuario" value="{{auth()->user()->id}}"/>

                <!-- Título -->
                <div class="mb-3">
                    <label for="title" class="form-label fw-bold">Título</label>
                    <input type="text" name="title" class="form-control" id="title" placeholder="Título del servicio" value="{{ old('title') }}">
                    @error('title') <p class="text-danger small">{{ $message }}</p> @enderror
                </div>

                <!-- Descripción -->
                <div class="mb-3">
                    <label for="description" class="form-label fw-bold">Descripción</label>
                    <textarea name="description" class="form-control" id="description" placeholder="Descripción del servicio" rows="4">{{ old('description') }}</textarea>
                    @error('description') <p class="text-danger small">{{ $message }}</p> @enderror
                </div>

                <!-- Precio -->
                <div class="mb-3">
                    <label for="price" class="form-label fw-bold">Precio ($)</label>
                    <input type="number" name="price" class="form-control" id="price" placeholder="Precio en $" value="{{ old('price') }}">
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
