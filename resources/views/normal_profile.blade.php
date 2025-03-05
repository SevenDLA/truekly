@extends('layout')


@section('content')
@vite(['resources/js/script.js'])
<div class="container mt-4">
    <div class="row">
        <!-- User Profile Section -->
        <div class="col-md-4 text-center">
            <div class="card p-4 shadow-sm border-primary">
                <img src="https://via.placeholder.com/150" class="rounded-circle mb-3 border border-primary" alt="User Avatar">
                <h2 class="text-primary">{{$current_logged_in_user->username}}</h2>
            </div>
        </div>
        
        <!-- User Data Section -->
        <div class="col-md-8">
            <div class="card p-4 shadow-sm border-primary">
                <h3 class="text-primary">Datos:</h3>

                <!-- Nombre -->
                <p><strong>Nombre:</strong> {{$current_logged_in_user->name}} {{$current_logged_in_user->surname}}</p>


                <!-- Email -->
                <div id="emailDiv">
                    <p><strong>Email:</strong> <span id="user-email">{{$current_logged_in_user->email}}</span>
                        <input type="email" id="email" class="form-control d-inline w-auto mt-2" placeholder="Nuevo Email">
                        <button type="button" class="btn btn-primary btn-sm update-info mt-2" data-type="email" data-user-id="{{ $current_logged_in_user->id }}">Cambiar</button>
                    </p>
                </div>


                <!-- Número de Teléfono -->                
                <div id="phoneDiv">
                    <p><strong>Teléfono:</strong> <span id="user-phone">{{$current_logged_in_user->phone_number}}</span>
                        <input type="text" id="phone" class="form-control d-inline w-auto mt-2" placeholder="Nuevo Teléfono">
                        <button type="button" class="btn btn-primary btn-sm update-info mt-2" data-type="phone" data-user-id="{{ $current_logged_in_user->id }}">Cambiar</button>
                    </p>
                </div>

                <!-- Fecha de nacimiento -->
                <p><strong>Fecha nacimiento:</strong> {{$current_logged_in_user->date_of_birth}}</p>


                <!-- Sexo -->
                <p><strong>Sexo:</strong> {{$SEX[$current_logged_in_user->sex]}}</p>


                <!-- Tokens -->
                <p><strong>Tokens:</strong> {{$current_logged_in_user->tokens}}</p>
                <div class="d-flex gap-2">
                    <button class="btn btn-success btn-sm">Comprar</button>
                    <button class="btn btn-danger btn-sm">Vender</button>
                </div>
            </div>

        </div>
    </div>
</div>


<div class="container mt-4">
    <p>Tus servicios</p>
    
    <div id="servicesList">
    </div>
    
    
</div>

<script>
        $(document).ready(function() {
        let userId = "{{ $current_logged_in_user->id }}";

        $.ajax({
            url: `/user/${userId}/services/ajax`,
            type: "GET",
            dataType: "json",
            success: function(services) {
                $("#servicesList").empty();
                if (services.length === 0) {
                    $("#servicesList").append("<li>No hay servicios disponibles.</li>");
                } else {
                    services.forEach(service => {
                    $("#servicesList").append(`
                        <div class="card mb-3 shadow-sm border-primary">
                            <div class="card-body">
                                <h5 class="card-title text-primary">${service.title}</h5>
                                <p class="card-text">${service.description}</p>
                                <p class="card-text"><strong>Precio:</strong> $${service.price}</p>
                                <p>${service.id}</p>
                                <p>${service.user_id}</p>
                                <a class="btn btn-warning" href="editar_servicio/${service.user_id}/${service.id}">Edit</a>
                                <form action="/eliminar_servicio/${service.id}" method="POST" style="display:inline;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                            </div>
                        </div>
                    `);
                });
                }

                $('#servicesList').append(`<a href="/nuevo_servicio/{{ $current_logged_in_user->id }}" class="btn btn-primary">Añadir servicio</a>`)
            },
            error: function(xhr) {
                console.error("Error al cargar servicios:", xhr);
            }
        });
    });
    </script>

@endsection
