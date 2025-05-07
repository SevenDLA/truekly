@extends('layout')

@section('title', 'Marketplace')
@section('content')

<h1>Listado de ofertas</h1>

<ul>
    @foreach ($ofertas as $oferta)
        @if($oferta->status == 'E')
            <li>
                <strong>ID oferta: {{ $oferta->id }} </strong>
                <p>Cantidad de tokens: {{ $oferta->tokens }} </p>
                <p>Precio a vender: {{ $oferta->price }} €</p>
                <p>Nombre del seller: {{ $oferta->seller->username }}</p>

                <p>Estado de la oferta: {{ $ESTADO[$oferta->status] }}</p>
                
                <a class ="btn btn-success" href="/comprar/{{ $oferta->tokens }}/{{ $oferta->price }}/{{ $oferta->seller->id }}/{{ $oferta->id }}">Comprar tokens</a>
            </li>
        @endif
    @endforeach
</ul>

@endsection