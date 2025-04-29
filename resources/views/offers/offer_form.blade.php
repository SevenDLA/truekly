@extends('layout')

@section('title', $tipo_oper)

@section('content')

<div class="container mt-5">
        <form method="POST" action="{{ route('offer.store') }}">
                @csrf
                <input type="hidden" name="id_oferta" value="{{ $oferta->id }}" />

                <div class="card shadow-lg p-4 rounded">
                        <h2 class="text-center mb-4">{{ $tipo_oper }}</h2>

                        <div class="mb-3">
                                <label for="tokens" class="form-label fw-bold">Cantidad de tokens</label>
                                <input type="number" name="tokens" class="form-control" id="tokens" placeholder="Cantidad de tokens" value="{{ old('tokens', $oferta->tokens) }}">
                                @error('tokens') <p class="text-danger small">{{ $message }}</p> @enderror
                        </div>

                        <div class="mb-3">
                                <label for="price" class="form-label fw-bold">Precio (€)</label>
                                <input type="number" name="price" class="form-control" id="price" placeholder="Precio (€)" value="{{ old('price', $oferta->price) }}">
                                @error('price') <p class="text-danger small">{{ $message }}</p> @enderror
                        </div>

                        <!-- Botón de enviar -->
                        <div class="text-center">
                                <button type="submit" class="btn btn-primary px-4">Guardar</button>
                        </div>
                </div>
        </form>
</div>

@endsection