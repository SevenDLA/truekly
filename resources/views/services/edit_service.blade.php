@extends('layout')


@section('title', 'Editar servicio')


@section('content')

<x-guest-layout>
    <form method="POST" action="{{ route('service.store',['id_usuario', '$id_usuario', 'id_servicio' => $id_servicio]) }}">
        @csrf
        
        <input type="hidden" name="oper" value="create_service" />
        <input type="hidden" name="id_servicio" value="{{ $id_servicio }}"/>

        <!-- Título -->
        <div class="mb-3">
            <label for="title" class="form-label">Título</label>
            <input type="text" name="title" class="form-control" id="title" placeholder="Título del servicio" value="{{ old('title', $servicio->title) }}">
            @error('title') <p style="color: red;">{{ $message }}</p> @enderror
        </div>

        <!-- Descripción -->
        <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <textarea name="description" class="form-control" id="description" placeholder="Descripción del servicio">{{ old('description', $servicio->description) }} </textarea>
            @error('description') <p style="color: red;">{{ $message }}</p> @enderror
        </div>

        <!-- Precio -->
        <div class="mb-3">
            <label for="price" class="form-label">Precio</label>
            <input type="number" name="price" class="form-control" id="price" placeholder="Precio en $" value="{{ old('price', $servicio->price) }}">
            @error('price') <p style="color: red;">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</x-guest-layout>


@endsection