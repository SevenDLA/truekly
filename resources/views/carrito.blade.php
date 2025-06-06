@extends('layout')

@section('title', 'Carrito')

@section('content')
@php
    use App\Models\Service;
    use App\Models\User;

    $carrito = session('carrito', []);
@endphp
<div id="messageBox"></div>
<div class="container py-5">
    <h2 class="mb-4"><i class="bi bi-cart me-1"></i> Mi Carrito</h2>
    <div class="row">
        <!-- Product List -->
        <div class="col-md-8" id="listadoCarro">
            <script>
                var listado_servicios = [];
            </script>
            @php
                $precio_total = 0;
                
            @endphp

            @forelse ($carrito as $id => $data)
                @php
                    $servicio = Service::find($id);
                    $quantity = $data['quantity'];
                    $servicio->quantity = $quantity;
                @endphp

                <script>
                    listado_servicios.push(@json($servicio))
                </script>

                @if($servicio)

                    @php
                        $precio_total += $servicio->price * $quantity
                    @endphp
                    <div class="card mb-4 position-relative servicioEnCarro" style="border-radius: var(--border-radius-lg); box-shadow: var(--box-shadow-sm); border: 1px solid rgba(0, 0, 0, 0.05); transition: var(--transition-normal);">
                        <!-- Delete Button -->
                        <button class="btn btn-outline-danger btn-sm rounded-circle d-flex align-items-center justify-content-center position-absolute top-0 end-0 m-2 delete-button" style="width: 30px; height: 30px; transition: var(--transition-fast);" data-id="{{ $servicio->id }}">
                            <i class="bi bi-x-lg"></i>
                        </button>

                        <div class="row g-0 align-items-center">
                            <div class="col-md-2 text-center p-2">
                                <img src="{{ asset('storage/' . ($servicio->image ?? 'images/default.jpg')) }}" class="img-fluid" alt="Service Image" style="border-radius: var(--border-radius-md); object-fit: cover; height: 80px; width: 100%;">
                            </div>
                            <div class="col-md-7">
                                <div class="card-body">
                                    <h5 class="card-title mb-1" style="color: var(--text-dark);">{{ $servicio->title }} <span class="tag">×{{$quantity}}</span></h5>
                                    <p class="text-muted mb-2">{{ $servicio->description }}</p>
                                    <small class="text-secondary">Usuario: {{ $servicio->user->username }}</small>
                                </div>
                            </div>
                            <div class="col-md-3 text-end pe-3">
                                <p class="mb-1 fw-bold highlight-text">{{ $servicio->price * $quantity}} TokenSkills</p>
                                <div class="quantity-control d-inline-flex align-items-center">
                                    <button class="btn btn-sm btn-outline-secondary quantity-btn minus" data-id="{{ $servicio->id }}" data-price="{{ $servicio->price }}" data-stock="{{ $servicio->stock }}">-</button>
                                    <input type="number" class="form-control form-control-sm mx-2 quantity-input" 
                                        style="width: 50px; 
                                        text-align: center; 
                                        background-color: #fff;
                                        color: #333;
                                        font-weight: 600;
                                        padding: 2px;
                                        border: 1px solid #ced4da;" 
                                        value="{{ $quantity }}" 
                                        min="1" 
                                        max="{{ min(3, $servicio->stock) }}" 
                                        readonly>
                                    <button class="btn btn-sm btn-outline-secondary quantity-btn plus" data-id="{{ $servicio->id }}" data-price="{{ $servicio->price }}" data-stock="{{ $servicio->stock }}">+</button>
                                </div>
                            </div>
                        </div>
                    </div>
                
                
                @else
                    <p class="text-danger">Servicio con ID {{ $id }} no encontrado.</p>
                @endif
            @empty
                <div class="card p-4 text-center" style="border-radius: var(--border-radius-lg); box-shadow: var(--box-shadow-sm);">
                    <p class="text-muted mb-0"><i class="bi bi-cart-x me-2" style="font-size: 1.5rem;"></i>Tu carrito está vacío.</p>
                </div>
            @endforelse
        </div>

        <!-- Order Summary -->
        <div class="col-md-4">
            <div class="card p-4 shadow-sm" style="border-radius: var(--border-radius-lg); box-shadow: var(--box-shadow-md); border: 1px solid rgba(0, 0, 0, 0.05);">
                <h5 class="mb-3" style="color: var(--text-dark);">Resumen del Pedido</h5>
                <div class="mb-2 d-flex justify-content-between">
                    <span>Subtotal (TokenSkills)</span>
                    <span id="precioTotal" class="highlight-text">{{ $precio_total }}</span>
                </div>
                <div class="mb-2 d-flex justify-content-between">
                    <span>Descuento</span>
                    <span>- 0</span>
                </div>
                
                <hr>

                <button class="btn btn-primary w-100 mt-2 pay-button">Proceder al Pago</button>
                <button class="btn btn-secondary w-100 mt-2 empty-button">Vaciar carrito</button>
            </div>
        </div>
    </div>
</div>

<script>
    const carrito = @json(session('carrito', []));
    console.log(carrito)

    var currentUser = @json(auth()->user());
    console.log(currentUser.tokens)

    
    $(document).ready(function()
    {
        // Agregar el nuevo handler para los botones de cantidad
        $('.quantity-btn').on('click', function() {
            const button = $(this);
            const input = button.parent().find('.quantity-input');
            const currentValue = parseInt(input.val()) || 1;
            const price = parseFloat(button.data('price'));
            const serviceId = button.data('id');
            const stock = parseInt(button.data('stock'));
            const maxQuantity = Math.min(3, stock);
            
            let newValue = currentValue;
            if (button.hasClass('plus') && currentValue < maxQuantity) {
                newValue = currentValue + 1;
            } else if (button.hasClass('minus') && currentValue > 1) {
                newValue = currentValue - 1;
            }

            if (newValue !== currentValue) {
                $.ajax({
                    url: '/actualizar_cantidad_carrito',
                    type: 'POST',
                    contentType: 'application/json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: JSON.stringify({ 
                        id: serviceId,
                        quantity: newValue
                    }),
                    success: function(response) {
                        if (response.success) {
                            input.val(newValue);
                            
                            // Actualizar precio del item y span de cantidad
                            const priceElement = button.closest('.col-md-3').find('.highlight-text');
                            const quantitySpan = button.closest('.card').find('.tag');
                            const newPrice = price * newValue;
                            
                            priceElement.text(`${newPrice} tokens`);
                            quantitySpan.text(`×${newValue}`);

                            // Actualizar listado_servicios
                            const servicio = listado_servicios.find(s => s.id === serviceId);
                            if (servicio) {
                                servicio.quantity = newValue;
                            }

                            updateTotalPrice();
                        }
                    }
                });
            }
        });

        function updateTotalPrice() {
            let total = 0;
            listado_servicios.forEach(servicio => {
                const quantity = Math.min(Math.max(parseInt(servicio.quantity) || 1, 1), 3);
                total += servicio.price * quantity;
            });
            $('#precioTotal').text(Math.round(total));
        }

        function deleteServiceCart(e)
        {

            const button = e.currentTarget;
            let card = $(this).closest('.card');
            console.log("clicked")
            $.ajax(
            {
                url:'/quitar_servicio_carrito',
                type:'POST',
                contentType: 'application/json',
                headers:
                {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                
                data: JSON.stringify({ id: parseInt(button.dataset.id)}),


                success: function (response)
                {
                    console.log(response)
                    listado_servicios.forEach(p => console.log('ID:', p.id, typeof p.id));
                    let precioActual = parseFloat($('#precioTotal').html());

                    let servicio = listado_servicios.find(p => p.id === response.id_servicio);
                    let index = listado_servicios.findIndex(p => p.id === response.id_servicio);
                    listado_servicios.splice(index, 1);
                    console.log('servicio:', servicio);

                    $('#precioTotal').html(precioActual - (servicio.price * response.quantity))
                    card.remove();

                    if ($('.servicioEnCarro').length === 0) 
                    {
                        console.log('No elements found');
                        $('#listadoCarro').html('<div class="card p-4 text-center" style="border-radius: var(--border-radius-lg); box-shadow: var(--box-shadow-sm);"><p class="text-muted mb-0"><i class="bi bi-cart-x me-2" style="font-size: 1.5rem;"></i>Tu carrito está vacío.</p></div>');
                    }
                },

                error: function (xhr) {
                    console.error('Error borrando carrito:', xhr.responseText);
                }

            });

        }
        
        function payForCart()
        {
            if(listado_servicios.length <= 0)
            {
                showMessage("Tu carrito está vacío", "error")
            }else if(currentUser.tokens < parseFloat($('#precioTotal').html()))
            {
                showMessage("Tokens insuficientes", "error")
            }
            else
            {
                $.ajax(
                {
                    url: '/carrito/nuevo',     
                    type: 'POST',              
                    data: JSON.stringify(
                    {   
                        servicios: listado_servicios
                    }),
                    headers:
                    {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    contentType: 'application/json',  
                    success: function(response) {  
                        console.log('Success:', response);  
                        showMessage("Pago realizado", "success");
                        $('#precioTotal').html(0);
                        emptyCart();
                        window.location.href = 'perfil';
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);  
                    }
                });
            }
            

        }

        function emptyCart()
        {
            if(listado_servicios.length <= 0)
            {
                showMessage("Tu carrito ya está vacío", "error")
            }else
            {
                $.ajax
            ({
                url:'/vaciar/carrito',
                type:'POST',
                headers:
                {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success:function(response)
                {
                    $('.servicioEnCarro').remove()
                    listado_servicios.length = 0;
                    $('#listadoCarro').empty();
                    $('#listadoCarro').html('<div class="card p-4 text-center" style="border-radius: var(--border-radius-lg); box-shadow: var(--box-shadow-sm);"><p class="text-muted mb-0"><i class="bi bi-cart-x me-2" style="font-size: 1.5rem;"></i>Tu carrito está vacío.</p></div>');
                    $('#precioTotal').html(0)

                    
                    console.log('Cart has been emptied')
                },
                error: function(xhr, status, error) 
                {
                    // Handle error
                    console.error('Error:', error);
                }
            
            })
            }
            

            
        }

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
                            .fadeOut(500);
        }

        $('.pay-button').on('click', function()
        {
            payForCart()
        }) 

        $('.empty-button').on('click', function()
        {
            emptyCart()
        })

        $('.delete-button').on('click', deleteServiceCart);

        // Añadir efectos de hover a las tarjetas
        $('.servicioEnCarro').hover(
            function() {
                $(this).css('box-shadow', 'var(--box-shadow-md)');
            },
            function() {
                $(this).css('box-shadow', 'var(--box-shadow-sm)');
            }
        );
        
    })
</script>
@endsection