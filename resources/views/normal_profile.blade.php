@extends('layout')

@section('title', 'Mi Perfil')

@section('content')
    @vite(['resources/js/profile.js'])
    <div class="container mt-4">
        <div class="row">
            <!-- User Profile Section -->
            <div class="col-md-4 text-center">
                <div class="card p-4 shadow-sm border-primary">

                    @if ($current_logged_in_user->profile_pic === null)
                        <img src="{{ asset('images/default_' . ($current_logged_in_user->sex == 'H' ? 'male' : 'female') . '_pfp.jpg') }}"
                            class="rounded-circle mb-3 border border-primary" alt="User Avatar">
                        <p>{{ $current_logged_in_user->sex == 'H' }}</p>
                    @else
                        <img src="{{ asset('storage/' . $current_logged_in_user->profile_pic) }}"
                            class="rounded-circle mb-3 border border-primary" alt="User Avatar">
                    @endif

                    <h2 class="text-primary">{{ $current_logged_in_user->username }}</h2>

                    <input type="file" id="image-input" style="display: none;">

                    <div class="d-flex flex-column gap-3">
                        <!-- Upload/Change Profile Picture Button -->
                        <button type="button" class="btn btn-primary" id="upload-btn">
                            {{ $current_logged_in_user->profile_pic === null ? 'Añadir' : 'Cambiar' }} foto de perfil
                        </button>

                        <!-- Logout Button -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-sign-out-alt mr-2"></i>Cerrar Sesión
                            </button>
                        </form>
                    </div>

                </div>
            </div>

            <!-- User Data Section -->
            <div class="col-md-8">
                <div class="card p-4 shadow-sm border-primary">
                    <h3 class="text-primary mb-3">Datos:</h3>

                    <!-- Nombre -->
                    <p><strong>Nombre:</strong> {{ $current_logged_in_user->name }} {{ $current_logged_in_user->surname }}
                    </p>

                    <!-- Email -->
                    <div id="emailDiv" class="mb-3">
                        <p><strong>Email:</strong> <span id="user-email">{{ $current_logged_in_user->email }}</span></p>
                        <div class="input-group">
                            <input type="email" id="email" class="form-control" placeholder="Nuevo Email">
                            <button type="button" class="btn btn-primary update-info" data-type="email"
                                data-user-id="{{ $current_logged_in_user->id }}">Cambiar</button>
                        </div>
                    </div>

                    <!-- Número de Teléfono -->
                    <div id="phoneDiv" class="mb-3">
                        <p><strong>Teléfono:</strong> <span
                                id="user-phone">{{ $current_logged_in_user->phone_number }}</span></p>
                        <div class="input-group">
                            <input type="text" id="phone" class="form-control" placeholder="Nuevo Teléfono">
                            <button type="button" class="btn btn-primary update-info" data-type="phone"
                                data-user-id="{{ $current_logged_in_user->id }}">Cambiar</button>
                        </div>
                    </div>

                    <!-- Fecha de nacimiento -->
                    <p><strong>Fecha nacimiento:</strong> {{ $current_logged_in_user->date_of_birth->format('d/m/Y') }}</p>

                    <!-- Sexo -->
                    <p><strong>Sexo:</strong> {{ $SEX[$current_logged_in_user->sex] }}</p>

                    <!-- Tokens -->
                    <p><strong>Tokens:</strong> {{ $current_logged_in_user->tokens }}</p>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                            data-bs-target="#tokensModal">
                            Comprar tokens
                        </button>
                        <a class="btn btn-danger btn-sm" href="/vender">Vender</a>
                        @hasrole('admin')
                            <a href="/admin" class="btn btn-success btn-sm ms-auto">
                                Panel de administración
                            </a>
                        @endrole
                    </div>
                </div>
            </div>

            <!-- Token Modal -->
            <div class="modal fade" id="tokensModal" tabindex="-1" aria-labelledby="tokensModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title text-primary" id="tokensModalLabel">Paquetes de TokenSkills</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="d-flex flex-nowrap overflow-auto">
                                @foreach ([['tokens' => 100, 'precio' => 4.99], ['tokens' => 250, 'precio' => 9.99], ['tokens' => 500, 'precio' => 24.99], ['tokens' => 1000, 'precio' => 45.99], ['tokens' => 2000, 'precio' => 99.99]] as $pack)
                                    <div class="flex-shrink-0 me-3" style="width: 250px;">
                                        <div class="token-card p-3 text-center bg-light rounded shadow-sm">
                                            <div class="mb-3" style="height: 100px;">
                                                <div class="position-relative"
                                                    style="width: 100px; height: 100px; margin: 0 auto;">
                                                    @php
                                                        $numCoins = min(5, intval($pack['tokens'] / 100));
                                                        $totalOffset = ($numCoins - 1) * 10;
                                                    @endphp
                                                    @for ($i = 0; $i < $numCoins; $i++)
                                                        <img src="{{ asset('images/coin.png') }}" alt="Coins"
                                                            class="img-fluid position-absolute"
                                                            style="
                                                            max-height: 100px;
                                                            transform: translateX({{ $i * 10 - $totalOffset / 2 }}px);
                                                            z-index: {{ $i }};
                                                        ">
                                                    @endfor
                                                </div>
                                            </div>
                                            <h5 class="text-black fs-5">{{ $pack['tokens'] }} TokenSkills</h5>
                                            <p class="fs-6 mb-2 text-black">{{ $pack['precio'] }}€</p>
                                            <a href="/comprar/{{ $pack['tokens'] }}/{{ $pack['precio'] }}"
                                                class="btn btn-primary w-100">Comprar</a>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Services Section -->
    <div class="container mt-4">
        <p>Tus servicios</p>
        <div id="servicesList"></div>
    </div>
    <br>
    <script>
        $(document).ready(function() {
            let userId = "{{ $current_logged_in_user->id }}";

            //COGER SERVICIOS DEL USUARIO
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
                                    <p class="card-text"><strong>Precio:</strong> ${service.price} tokens</p>
                                    <p class="card-text"><strong>Stock:</strong> ${service.stock} tokens</p>
                                    <p>${service.id}</p>
                                    <p>${service.user_id}</p>
                                    <a class="btn btn-warning" href="servicio/${service.id}">Edit</a>
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

                    $('#servicesList').append(
                        `<a href="/servicio/" class="btn btn-primary">Añadir servicio</a>`);
                },
                error: function(xhr) {
                    console.error("Error al cargar servicios:", xhr);
                }
            });



        });
    </script>

    <script>
        $(document).ready(function() {
            let userId = "{{ $current_logged_in_user->id }}";

            $('#upload-btn').on('click', function() {
                $('#image-input').click();
            });

            $('#image-input').on('change', function() {
                let file = this.files[0];
                if (!file) return;

                let formData = new FormData();
                formData.append('image', file);
                formData.append('_token', "{{ csrf_token() }}");

                console.log("File selected:", file.name);

                $.ajax({
                    url: "{{ route('profile.upload.image') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        console.log("Uploading file...");
                        $('#upload-btn').prop('disabled', true).text('Uploading...');
                    },
                    success: function(response) {
                        console.log("Server response:", response);

                        if (response.success) {
                            console.log("Image uploaded successfully!");
                            $('.rounded-circle.mb-3.border-primary').attr('src', response
                                .image_url + '?t=' + new Date().getTime());
                            alert("Profile picture updated successfully!");
                        } else {
                            console.error("Upload failed:", response.error);

                            if (response.details) {
                                let errorMsg = response.details.join("\n");
                                alert("Upload failed: " + errorMsg);
                                console.log("Validation error:", errorMsg);
                            } else {
                                alert(response.error);
                            }
                        }
                    },
                    error: function(xhr) {
                        console.error("AJAX error:", xhr.responseText);

                        let errorMsg = "An error occurred. Please try again.";
                        if (xhr.status === 422) {
                            let response = JSON.parse(xhr.responseText);
                            if (response.details) {
                                errorMsg = response.details.join("\n");
                            }
                        }

                        alert(errorMsg);
                    },
                    complete: function() {
                        $('#upload-btn').prop('disabled', false).text('Cambiar foto de perfil');
                    }
                });
            });
        });
    </script>



@endsection
