@extends('layout')

@section('title', 'Listado de usuarios')

@section('content')
<div class="container mt-4">
    <div class="row">
        <!-- Barra de búsqueda -->
        <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Buscar usuarios..." title="Escribe un nombre de usuario">
    </div>

    <div class="row" id="user-list">
        @foreach ($users as $user)
        <div id="USER{{ $user->id }}" class="col boxes" style="position: relative; left: 0px; top: 0px;">
            <div class="card mb-4 rounded-3 shadow-sm">
                <div class="card-header text-center bg-primary text-white">
                    <h5 class="my-0">{{ $user->name }} {{ $user->surname }}</h5>
                </div>
                <div style="display:none">{{ $user->username }} {{ $user->email }} {{ $user->sex }}</div>
                <div class="card-body text-center">
                    <h2 class="card-title pricing-card-title">Categoría: {{ $user->email }}</h2>
                    <blockquote class="blockquote mb-0">
                        <p class="badge bg-light text-dark">Usuario: <b>{{ $user->username }}</b></p>
                        <p class="blockquote-footer">Fecha de nacimiento: {{ $user->date_of_birth }}</p>
                        <p class="blockquote-footer">Teléfono: {{ $user->phone_number }}</p>
                        <p class="blockquote-footer">Tokens: {{ $user->tokens }}</p>
                    </blockquote>
                    <a href="/user/{{ $user->id }}" class="w-100 btn btn-lg btn-primary">Ver</a>
                </div>
                <div class="card-footer bg-light text-center">
                    <a href="/user/actualizar/{{ $user->id }}" class="btn btn-outline-warning btn-sm"><i class="bi bi-pencil-square"></i> Editar</a>
                    <a href="/user/eliminar/{{ $user->id }}" class="btn btn-outline-danger btn-sm"><i class="bi bi-trash"></i> Eliminar</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{ $users->links() }}

    <div class="text-center mt-3">
        <a href="/users/nuevo" class="btn btn-success btn-lg"><i class="bi bi-plus"></i> Nuevo usuario</a>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function myFunction() {
        var input, filter, ul, li, a, i, txtValue;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        ul = document.getElementById("user-list");
        li = ul.getElementsByClassName("boxes");
        
        // Recorremos todos los elementos de la lista y los mostramos u ocultamos según la búsqueda
        for (i = 0; i < li.length; i++) {
            a = li[i].getElementsByClassName("card-header")[0]; // Obtener el nombre del usuario
            txtValue = a.textContent || a.innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
                li[i].style.display = ""; // Mostrar el item
            } else {
                li[i].style.display = "none"; // Ocultar el item
            }
        }
    }
</script>
@endsection
