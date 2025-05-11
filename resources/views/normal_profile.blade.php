@extends('layout')

@section('title', 'Mi Perfil')

@section('content')
    @vite(['resources/js/profile.js'])
    <div id="messageBox"></div>
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
                        <p></p>

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
                    <p><strong>TokenSkills:</strong> {{ $current_logged_in_user->tokens }}</p>
                    
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#tokensModal">
                            Comprar TokenSkills
                        </button>
                        <a class="btn btn-secondary" href="/vender">
                            Vender TokenSkills
                        </a>
                        <a href="/servicio/" class="btn btn-secondary">
                            Añadir servicio
                        </a>

                    </div>
                </div>
            </div>

            <!-- Token Modal -->
            <div class="modal fade" id="tokensModal" tabindex="-1" aria-labelledby="tokensModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content bg-white text-white">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="tokensModalLabel">
                        <i class="bi bi-currency-exchange me-2"></i> Elige tu paquete de TokenSkills
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="scroll-container d-flex gap-4 overflow-auto px-2 py-3">
                        @foreach ([['tokens' => 100, 'precio' => 4.99], ['tokens' => 250, 'precio' => 9.99], ['tokens' => 500, 'precio' => 24.99], ['tokens' => 1000, 'precio' => 45.99], ['tokens' => 2000, 'precio' => 89.99]] as $index => $pack)
                            <div class="token-card bg-light text-dark p-4 rounded-4 shadow-sm"
                                style="min-width: 260px; max-width: 260px;">
                                <div class="text-center">
                                    <div class="mb-3" style="height: 60px; position: relative;">
                                        <div style="display: grid; grid-template-columns: repeat(auto-fit, 45px); gap: 8px; justify-content: center;">
                                            @for ($i = 0; $i < ceil($pack['tokens'] / 500); $i++)
                                                <img src="{{ asset('images/coin.png') }}" alt="Token" 
                                                    style="width: 45px; height: 45px; object-fit: contain; filter: drop-shadow(0 0 {{ 2 + ($pack['tokens'] / 500) }}px gold);">
                                            @endfor
                                        </div>
                                    </div>
                                    <h5 class="fw-bold mb-1">{{ $pack['tokens'] }} TokenSkills</h5>
                                    <p class="fs-5 fw-semibold mb-1">{{ $pack['precio'] }}€</p>
                                    <p class="text-muted mb-3">{{ round(($pack['precio'] / $pack['tokens']) * 100, 2) }}€
                                        por cada 100 tokens</p>
                                    <a href="/comprar/{{ $pack['tokens'] }}/{{ $pack['precio'] }}"
                                        class="btn btn-primary w-100">
                                        <i class="bi bi-bag-check me-1"></i> Comprar
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        <div class="alert alert-primary" role="alert">
                            <div class="d-flex">
                                <div class="me-3">
                                    <i class="bi bi-info-circle-fill fs-3"></i>
                                </div>
                                <div>
                                    <h6 class="alert-heading mb-1">¿Cómo funcionan los TokenSkills?</h6>
                                    <p class="mb-0">Los TokenSkills son nuestra moneda virtual para intercambiar
                                        servicios en la plataforma. Puedes usarlos para adquirir habilidades o recibirlos al
                                        ofrecer las tuyas.</p>
                                </div>
                            </div>
                        </div>
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
        let currentView = 'services'; // Track current view

        $(document).ready(function() 
        {
            // Obtener parámetro de la URL
            const urlParams = new URLSearchParams(window.location.search);
            const vistaParam = urlParams.get('vista');

            // Si viene de una compra, mostrar las compras
            if (vistaParam === 'comprados') {
                currentView = 'bought';
                updateActiveButton('#boughtTest');
                loadUserCompras('bought');
            } else {
                loadUserServices('every');
            }


             $(document).on('submit', '.pagar-form', function(e) 
             {
                e.preventDefault(); // Stop regular form submission

                const form = $(this);
                const actionUrl = form.attr('action');
                const formData = form.serialize();

                $.post(actionUrl, formData)
                    .done(function(response) {
                        showMessage('Servicio aceptado correctamente.', 'success');
                    })
                    .fail(function(xhr) {
                        let msg = 'Error al realizar el pago.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        showMessage(msg, 'error');
                    });
            });

            function showMessage(message='', type)
            {
                console.log(message, type)
                let bgColor = type == "error" ? "#ef4444" : "#10b981";
                $('#messageBox')
                                .stop(true, true)
                                .text(message) 
                                .css({
                                    'background-color': bgColor,
                                    'color': 'white',
                                    'font-weight': 'bold',
                                    'text-align': 'center',
                                    'padding': '10px',
                                    'width': '100%',
                                    'border-radius': 'var(--border-radius-md)',
                                    'box-shadow': 'var(--box-shadow-sm)',
                                    'position': 'fixed',
                                    'top': '20px',
                                    'left': '50%',
                                    'transform': 'translateX(-50%)',
                                    'z-index': '1050',
                                    'max-width': '500px'
                                })
                                .fadeIn(500) 
                                .delay(1000)
                                .fadeOut(500, function () 
                                {
                                    location.reload(); 
                                });
            }

            function updateActiveButton(clickedButton) {
                $('.btn').removeClass('active');
                $(clickedButton).addClass('active');
            }

            $('#everyService').click(function () {
                if (currentView === 'services') return;
                currentView = 'services';
                updateActiveButton(this);
                loadUserServices('all');
            })

            $('#boughtTest').click(function () {
                if (currentView === 'bought') return;
                currentView = 'bought';
                updateActiveButton(this);
                loadUserCompras("bought");
            })

            $('#soldTest').click(function () {
                if (currentView === 'sold') return;
                currentView = 'sold';
                updateActiveButton(this);
                loadUserCompras('sold');
            })

            $('#userOffers').click(function() {
                if (currentView === 'offers') return;
                currentView = 'offers';
                updateActiveButton(this);
                getUserOffers();
            })
            

            function eliminarOferta(offerId) 
            {
                if (!confirm('¿Estás seguro de que quieres eliminar esta oferta?')) return;

                $.ajax(
                    {
                    url: '/oferta/eliminar',
                    type: 'DELETE',
                    data: {
                        offerId: offerId,
                        _token: '{{ csrf_token() }}' // CSRF token for security
                    },
                    success: function(response) {
                        if (response.success) {
                            showMessage(response.message, "success")
                            // Optionally remove the card from the DOM
                            $('#oferta-' + offerId).remove();
                        } else {
                            showMessage(response.message, "error")
                        }
                    },
                    error: function(xhr) {
                        alert('Error inesperado. Intenta de nuevo.');
                    }
                });
            }

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

                        if (response.length === 0) {
                            $("#ajaxList").html(
                                '<div class="col"><div class="alert alert-info">No hay ofertas disponibles.</div></div>'
                            );
                            return;
                        }

                        response.forEach(function(oferta)
                        {
                            $("#ajaxList").append
                            (
                                `<div class="col-md-6 col-lg-4 mb-4" id="oferta-${oferta.id}">
                                    <div class="card shadow rounded h-100 border-0">
                                        <div class="card-body d-flex flex-column justify-content-between">
                                            <div class="mb-3">
                                                <h5 class="card-title fw-bold">Tokens: ${oferta.tokens}</h5>
                                                <h5 class="card-subtitle fw-bold text-muted">Precio: ${oferta.price} €</h5>
                                            </div>
                                            <div class="d-flex gap-2 mt-auto">
                                                <a href="/oferta/${oferta.id}" class="btn btn-primary w-50">
                                                    <i class="fas fa-edit me-2"></i>Editar
                                                </a>
                                                <button id="btn-eliminar-${oferta.id}" class="btn btn-danger w-50">
                                                    <i class="fas fa-trash-alt me-2"></i>Eliminar
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                `
                            )
                        })
                    }
                    
                })
                
            }

            $(document).ready(function () 
            {
                $('[id^=btn-eliminar-]').each(function () {
                    const offerId = $(this).attr('id').split('-')[2];
                    $(this).on('click', function () {
                        eliminarOferta(offerId);
                    });
                });
            });

            function addServices(services, option) 
            {
                $("#ajaxList").empty();
                if (services.length === 0) {
                    $("#ajaxList").html(
                        '<div class="col"><div class="alert alert-info">No hay servicios disponibles.</div></div>'
                    );
                } else {
                    services.forEach(service => {
                        let buttons='';
                        let info='';
                        const CONTACT = @json($CONTACT);
                        const CATEGORY = @json($CATEGORY);
                        // Switch to determine the info and buttons based on the option
                        switch (option) {
                            case 'bought':
                                let contact = 
                                info = `<span class="tag">Vendedor: ${service.seller_name}</span>
                                        <span class="tag">Comprado el: ${service.compra_created_at} por ${service.price} TokenSkills</span>
                                        <span class="tag">${CONTACT[service.contact]}:
                                        `;


                                if(service.contact == 'E')
                                {
                                    info += `${service.seller_email}`
                                }
                                else
                                {
                                    info += `${service.seller_phone}`
                                }
                                info += "</span>"


                                buttons = `<form action="/pagar/vendedor/${service.compra_id}" method="POST" class="flex-fill pagar-form" data-id="${service.compra_id}">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <button type="submit" class="btn btn-success w-100">Aceptar</button>
                                            </form>

                                        `;
                                if(service.estado == "TERMINADO")
                                {
                                    info += `<span class ="tag">Terminado el: ${service.compra_updated_at}</span>`
                                    buttons = buttons.replace('<button ', '<button disabled ');
                                    buttons = buttons.replace('Aceptar', 'Servicio ya terminado');
                                }
                                else
                                {
                                    info += `<span class ="tag">Pendiente por terminar</span>`
                                }
                                break;
                            case 'sold':
                                info = `<span class="tag"><i class="fas fa-coins me-1"></i>Comprado por: ${service.buyer_name}</span>
                                        <span class="tag"><i class="fas fa-coins me-1"></i>Estado: ${service.estado}</span>`;
                                buttons = '';
                                break;
                            default:
                                info = `<span class="tag"> ${service.price} TokenSkills</span>
                                        <span class="tag">Stock: ${service.stock}</span>
                                        <span class="tag">Categoría: ${CATEGORY[service.category]}</span>
                                        <span class = "tag">Tipo de contacto: ${CONTACT[service.contact]}</span>`;
                                        
                                buttons = `<a class="btn btn-primary flex-fill" href="servicio/${service.id}">
                                                <i class="fas fa-edit me-2"></i>Editar
                                            </a>
                                            <form action="/eliminar_servicio/${service.id}" method="POST" class="flex-fill">
                                                <input type="hidden" name="_method" value="DELETE">
                                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                <button type="submit" class="btn btn-secondary w-100" onclick="return confirm('¿Estás seguro?')">
                                                    <i class="fas fa-trash-alt me-2"></i>Eliminar
                                                </button>
                                                
                                            </form>`;
                                break;
                        }

                        // Now append the HTML content for the service
                        $("#ajaxList").append(`
                            <div class="col">
                                <div class="profile-card h-100">
                                    <div class="d-flex flex-column h-100">
                                        <h5 class="highlight-text">${service.title}</h5>
                                        <img src="{{ asset('storage') }}/${service.image}" alt="Service Image" style="width: 500px; height: 250px; object-fit: cover; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);">
                                        <br>
                                        <p class="flex-grow-1">${service.description}</p>
                                        <div class="mt-auto">
                                            <div class="mb-3">
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
                        console.log(services)
                        addServices(services, "all")
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
                    url:'/usuario/servicio/compras',
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
                        addServices(services, type)
                    },
                    error: function(xhr, status, error) 
                    {
                        console.error('Error occurred:', status, error);
                    }

                })
            }

            //Coger todos los servicios creados por el usuario
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
                            showMessage('¡Foto de perfil actualizada con éxito!', 'success');
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
                        } else {
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

    <style>
        .btn.active {
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
            transform: translateY(1px);
        }
    </style>
@endsection
