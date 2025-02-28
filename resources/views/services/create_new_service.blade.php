@extends('layout')


@section('title', 'Nuevo servicio')


@section('content')

<x-guest-layout>
    <form method="POST" action="{{ route('service.create',['id' => $id]) }}">
        @csrf
        <input type="hidden" name="oper" value="create_service" />

        <!-- Título -->
        <div class="mb-3">
            <label for="title" class="form-label">Título</label>
            <input type="text" name="title" class="form-control" id="title" placeholder="Título del servicio" value="{{ old('title') }}">
            @error('title') <p style="color: red;">{{ $message }}</p> @enderror
        </div>

        <!-- Descripción -->
        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea name="description" class="form-control" id="description" placeholder="Descripción del servicio">{{ old('description') }}</textarea>
            @error('description') <p style="color: red;">{{ $message }}</p> @enderror
        </div>

        <!-- Precio -->
        <div class="mb-3">
            <label for="price" class="form-label">Precio</label>
            <input type="number" name="price" class="form-control" id="price" placeholder="Precio en $" value="{{ old('price') }}">
            @error('price') <p style="color: red;">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</x-guest-layout>


@endsection