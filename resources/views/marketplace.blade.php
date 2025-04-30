@extends('layout')

@section('title', 'Marketplace')
@section('content')

<h1>Listado de ofertas</h1>

<ul>
    @foreach ($ofertas as $oferta)
        <li>
            <strong>ID oferta: {{ $oferta->id }} </strong>
            <p>Cantidad de tokens: {{ $oferta->tokens }} </p>
            <p>Precio a vender: {{ $oferta->price }} </p>
            <p>Nombre del seller: {{ $oferta->seller->username }}</p>
            <a class ="btn btn-success">Comprar tokens</a>
        </li>
    @endforeach
</ul>

@endsection