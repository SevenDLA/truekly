@extends('layout')

@section('title', 'Mi Perfil')

@section('content')
    @vite(['resources/js/profile.js'])
    <div class="container mt-4">
        <div class="row">
            <!-- User Profile Section -->
            <div class="col-md-4 text-center mb-4">
                <div class="profile-card p-4">
                    <!-- Profile Picture Container with Fixed Dimensions -->
                    <div class="profile-image mx-auto mb-3"
                        style="width: 200px; height: 200px; overflow: hidden; border-radius: 50%; border: 3px solid var(--primary);">
                        @if ($current_logged_in_user->profile_pic === null)
                            <img src="{{ asset('images/default_' . ($current_logged_in_user->sex == 'H' ? 'male' : 'female') . '_pfp.jpg') }}"
                                class="h-100 w-100 object-fit-cover" alt="User Avatar">
                        @else
                            <img src="{{ asset('storage/' . $current_logged_in_user->profile_pic) }}"
                                class="h-100 w-100 object-fit-cover" alt="User Avatar">
                        @endif
                    </div>

                    <h2 class="highlight-text">{{ $current_logged_in_user->username }}</h2>

                    <input type="file" id="image-input" accept="image/*" style="display: none;">

                    <div class="d-flex flex-column gap-3 mt-4">
                        <!-- Upload/Change Profile Picture Button -->
                        <button type="button" class="btn btn-primary" id="upload-btn">
                            {{ $current_logged_in_user->profile_pic === null ? 'Añadir' : 'Cambiar' }}
                            foto de perfil
                        </button>
                        @hasrole('admin')
                            <a href="/admin" class="btn btn-outline-primary">
                                Panel de administración
                            </a>
                        @endrole

                    </div>
                </div>
            </div>

            <!-- User Data Section -->
            <div class="col-md-8">
                <div class="profile-card">
                    <h3 class="highlight-text mb-4">Datos Personales</h3>

                    <!-- Nombre -->
                    <p><strong>Nombre:</strong> {{ $current_logged_in_user->name }} {{ $current_logged_in_user->surname }}
                    </p>

                    <!-- Email -->
                    <div id="emailDiv" class="mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <strong>Email:</strong>
                            <span id="user-email" class="ms-2">{{ $current_logged_in_user->email }}</span>
                        </div>
                        <div class="input-group">
                            <input type="email" id="email" class="form-control" placeholder="Nuevo Email">
                            <button type="button" class="btn btn-primary update-info" data-type="email"
                                data-user-id="{{ $current_logged_in_user->id }}">Cambiar</button>
                        </div>
                    </div>

                    <!-- Número de Teléfono -->
                    <div id="phoneDiv" class="mb-4">
                        <div class="d-flex align-items-center mb-2">
                            <strong>Teléfono:</strong>
                            <span id="user-phone" class="ms-2">{{ $current_logged_in_user->phone_number }}</span>
                        </div>
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
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tokensModal">
                            Comprar tokens
                        </button>
                        <a class="btn btn-secondary" href="/vender">
                            Vender tokens
                        </a>
                        <a href="/servicio/" class="btn btn-secondary">
                            Añadir servicio
                        </a>

                    </div>
                </div>
            </div>

            <!-- Token Modal -->
            <div class="modal fade" id="tokensModal" tabindex="-1" aria-labelledby="tokensModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title highlight-text" id="tokensModalLabel">Paquetes de TokenSkills</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="d-flex flex-nowrap overflow-auto pb-3">
                                @foreach ([['tokens' => 100, 'precio' => 4.99], ['tokens' => 250, 'precio' => 9.99], ['tokens' => 500, 'precio' => 24.99], ['tokens' => 1000, 'precio' => 45.99], ['tokens' => 2000, 'precio' => 99.99]] as $pack)
                                    <div class="flex-shrink-0 me-3" style="width: 250px;">
                                        <div class="token-card p-3 text-center h-100">
                                            <div class="token-coin-container mb-3">
                                                <div class="position-relative"
                                                    style="width: 100px; height: 100px; margin: 0 auto;">
                                                    @php
                                                        $numCoins = min(5, intval($pack['tokens'] / 100));
                                                        $totalOffset = ($numCoins - 1) * 10;
                                                    @endphp
                                                    @for ($i = 0; $i < $numCoins; $i++)
                                                        <img src="{{ asset('images/coin.png') }}" alt="Coins"
                                                            class="token-coin position-absolute"
                                                            style="
                                                            max-height: 100px;
                                                            transform: translateX({{ $i * 10 - $totalOffset / 2 }}px);
                                                            z-index: {{ $i }};
                                                        ">
                                                    @endfor
                                                </div>
                                            </div>
                                            <h5 class="text-black fs-5">{{ $pack['tokens'] }} TokenSkills</h5>
                                            <p class="fs-6 mb-3 text-black">{{ $pack['precio'] }}€</p>
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
    <div class="container mt-5 mb-5">
        <button id="everyService" class="btn btn-info text-white">Tus servicios</button>
        <button id="boughtTest" class="btn btn-secondary">Servicios comprados</button>
        <button id="soldTest" class="btn btn-primary">Servicios vendidos</button>
        <button id="userOffers" class="btn btn-warning text-white">Tus ofertas</button>
        <div id="ajaxList" class="row row-cols-1 row-cols-md-2 g-4 mt-2"></div>
    </div>

  

    <script>
        const ESTADO = @json(App\Models\Compra::ESTADO);
        let userId = "{{ $current_logged_in_user->id }}";

        console.log(ESTADO)

        $(document).ready(function() {
            $('#everyService').click(function ()
            {
                loadUserServices('all')
            })

            $('#boughtTest').click(function ()
            {
                console.log("clicked bought")
                loadUserCompras("bought")
            })

            $('#soldTest').click(function ()
            {
                loadUserCompras('sold')
            })

            $('#userOffers').click(function()
            {
                getUserOffers();
            })

            function getUserOffers()
            {
                $("#ajaxList").empty();

                $.ajax
                ({
                    url: '/usuario/ofertas',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response)
                    {
                        console.log(response)

                        response.forEach(function(oferta)
                        {
                            $("#ajaxList").append
                            (
                                `<div class="col">
                                        <div class="profile-card h-75 w-50">
                                            <div class="d-flex flex-column h-100">
                                                <h2> Tokens: ${oferta.tokens} </h2>
                                                <h2> Precio: ${oferta.price} €  </h2>
                                                <a class="btn btn-primary flex-fill" href="/oferta/${oferta.id}">
                                                    <i class="fas fa-edit me-2"></i>Editar
                                                </a>
                                            </div>
                                        </div>
                                </div>`
                            )
                        })
                    }
                    
                })
                
            }

            function addServices(services, option)
            {
                $("#ajaxList").empty();
                        if (services.length === 0) 
                        {
                            $("#ajaxList").html(
                                '<div class="col"><div class="alert alert-info">No hay servicios disponibles.</div></div>'
                            );
                        } else {
                            services.forEach(service => {
                                let buttons;
                                switch (option)
                                {
                                    case 'bought':
                                        info = `<span class="tag"><i class="fas fa-coins me-1"></i>Vendedor: ${service.seller_name}</span>`
                                        buttons = `<form action="/pagar/vendedor/${service.compra_id}" method="POST" class="flex-fill">
                                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                            <button type="submit" class="btn btn-success w-100">
                                                                Acceptar
                                                            </button>
                                                    </form>
                                                   <a class="btn btn-danger flex-fill">Rechazar</a>`
                                    break;
                                    case 'sold':
                                        info = ``
                                        buttons = ''
                                    default:
                                        info = `<span class="tag"><i class="fas fa-coins me-1"></i>${service.price} tokens</span>
                                                <span class="tag"><i class="fas fa-box me-1"></i>Stock: ${service.stock}</span>
                                                `
                                        buttons = `<a class="btn btn-primary flex-fill" href="servicio/${service.id}">
                                                            <i class="fas fa-edit me-2"></i>Editar
                                                        </a>
                                                        <form action="/eliminar_servicio/${service.id}" method="POST" class="flex-fill">
                                                            <input type="hidden" name="_method" value="DELETE">
                                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                            <button type="submit" class="btn btn-secondary w-100">
                                                                <i class="fas fa-trash-alt me-2"></i>Eliminar
                                                            </button>
                                                        </form>`
                                }
                                $("#ajaxList").append(`
                                    <div class="col">
                                        <div class="profile-card h-100">
                                            <div class="d-flex flex-column h-100">
                                                <h5 class="highlight-text">${service.title}</h5>
                                                <p class="flex-grow-1">${service.description}</p>
                                                <div class="mt-auto">
                                                    <div class="d-flex justify-content-between mb-3">
                                                        ${info}
                                                    </div>
                                                    <div class="d-flex gap-2 mt-3">
                                                        ${buttons}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                `);
                            });
                        }
            }

            // Load user services
            function loadUserServices(option) {
                $.ajax({
                    url: `/user/${userId}/services/ajax`,
                    type: "GET",
                    dataType: "json",
                    data:
                    {
                        option: option
                    },
                    success: function(services) {
                        addServices(services)
                    },
                    error: function(xhr, status, error) 
                    {
                        console.error("Error loading services:", status, error);
                        console.log("Response text:", xhr.responseText); // Log the response body
                        $("#ajaxList").html('<div class="col"><div class="alert alert-danger">Error al cargar los servicios.</div></div>');
                    }
                });
            }

            function loadUserCompras(type)
            {
                $.ajax
                ({
                    url:'/usario/servicio/comprados',
                    type:'POST',
                    dataType:'json',
                    data:
                    {
                        type:type
                    },
                    headers: 
                    {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(services)
                    {
                        console.log(services)
                        addServices(services, 'bought')
                    },
                    error: function(xhr, status, error) 
                    {
                        console.error('Error occurred:', status, error);
                    }

                })
            }

            loadUserServices('every');

            // Profile picture upload
            $('#upload-btn').on('click', function() {
                $('#image-input').click();
            });

            $('#image-input').on('change', function() {
                let file = this.files[0];
                if (!file) return;

                // Validate file type
                if (!file.type.match('image.*')) {
                    alert('Por favor, selecciona un archivo de imagen válido.');
                    return;
                }

                // Validate file size (max 2MB)
                if (file.size > 2 * 1024 * 1024) {
                    alert('La imagen no puede superar los 2MB.');
                    return;
                }

                let formData = new FormData();
                formData.append('image', file);
                formData.append('_token', "{{ csrf_token() }}");

                $.ajax({
                    url: "{{ route('profile.upload.image') }}",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#upload-btn').prop('disabled', true).html(
                            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Subiendo...'
                        );
                    },
                    success: function(response) {
                        if (response.success) {
                            // Update image with cache busting
                            $('.profile-image img').attr('src', response.image_url + '?t=' +
                                new Date().getTime());
                            // Show success toast or alert
                            alert("¡Foto de perfil actualizada con éxito!");
                        } else {
                            alert(response.error || "Error al subir la imagen");
                        }
                    },
                    error: function(xhr) {
                        let errorMsg = "Ocurrió un error. Por favor, inténtalo de nuevo.";
                        if (xhr.status === 422) {
                            let response = JSON.parse(xhr.responseText);
                            if (response.errors && response.errors.image) {
                                errorMsg = response.errors.image.join("\n");
                            }
                        }
                        alert(errorMsg);
                    },
                    complete: function() {
                        $('#upload-btn').prop('disabled', false).html(
                            '<i class="fas fa-camera me-2"></i>{{ $current_logged_in_user->profile_pic === null ? 'Añadir' : 'Cambiar' }} foto de perfil'
                        );
                        $('#image-input').val('');
                    }
                });
            });

            // Update user info
            $('.update-info').on('click', function() {
                let type = $(this).data('type');
                let value = $(`#${type}`).val();
                let userId = $(this).data('user-id');

                if (!value) {
                    alert('Por favor, introduce un valor válido.');
                    return;
                }

                $.ajax({
                    url: '/update-user-info',
                    type: 'POST',
                    data: {
                        _token: "{{ csrf_token() }}",
                        field: type,
                        value: value,
                        user_id: userId
                    },
                    success: function(response) {
                        if (response.success) {
                            $(`#user-${type}`).text(value);
                            $(`#${type}`).val('');
                            alert('¡Información actualizada con éxito!');
                        } else {
                            alert(response.error || 'Error al actualizar la información');
                        }
                    },
                    error: function(xhr) {
                        let response = JSON.parse(xhr.responseText);
                        if (response.errors) {
                            alert(response.errors[Object.keys(response.errors)[0]][0]);
                        } else {
                            alert('Error al actualizar la información');
                        }
                    }
                });
            });
        });
    </script>
@endsection
