@extends('layout')

@section('title', 'Marketplace')
@section('content')

<h1>Listado de ofertas</h1>

<ul>
    @foreach ($ofertas as $oferta)
        <li>
            
        </li>
    @endforeach
</ul>

@endsection