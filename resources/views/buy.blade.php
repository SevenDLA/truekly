@extends('layout')

@section('title', 'Completar Compra')

@section('content')
<section class="py-5" style="min-height: calc(100vh - 200px);">
    <div class="container h-100">
        <!-- Mensaje de estado (inicialmente oculto) -->
        <div id="messageBox" class="d-none mb-4 rounded shadow-sm text-center p-3 animate-fadeInUp" role="alert">
        </div>
        
        <div class="row">
            <!-- Título principal -->
            <div class="col-12 mb-4 text-center">
                <h2 class="mb-0">Finalizar tu compra</h2>
                <p class="text-muted">Solo estás a un paso de obtener tus tokens</p>
            </div>
            
            <!-- Contenido principal -->
            <div class="col-12">
                <div class="card shadow-lg rounded border-0 overflow-hidden">
                    <div class="card-body p-0">
                        <div class="row g-0">
                            <!-- Left side: Order Review -->
                            <div class="col-md-6 border-end">
                                <div class="p-4 p-lg-5">
                                    <a href="/" class="btn btn-outline-primary mb-4">
                                        <i class="bi bi-arrow-left me-2"></i>Regresar
                                    </a>
                                    
                                    <h3 class="mb-4">Resumen de compra</h3>
                                    <p class="text-muted mb-4">Revisa los detalles antes de proceder con el pago.</p>
                                    
                                    <div class="card hover-shadow border-0 shadow-sm mb-4">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div class="token-coin-container me-4">
                                                    <img src="{{ asset('images/coin.png') }}" alt="Tokens" class="token-coin pulse">
                                                </div>
                                                <div>
                                                    <h4 class="mb-2">{{ $cantidad_tokens }} tokens</h4>
                                                    <p class="mb-1"><i class="bi bi-currency-euro me-2 text-primary"></i><strong>Precio:</strong> {{ $precio_tokens }}€</p>
                                                    <p class="mb-0"><i class="bi bi-person-circle me-2 text-primary"></i><strong>Vendedor:</strong> {{ $seller ? $seller->username : 'Truekly' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="alert alert-info border-0 shadow-sm">
                                        <i class="bi bi-info-circle-fill me-2"></i>
                                        Una vez completado el pago, los tokens se añadirán automáticamente a tu cuenta.
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Right side: Payment Details -->
                            <div class="col-md-6 bg-light">
                                <div class="p-4 p-lg-5 h-100 d-flex flex-column justify-content-center">
                                    <h3 class="mb-4">Método de pago</h3>
                                    <p class="text-muted mb-4">Selecciona tu método de pago preferido para completar la transacción.</p>
                                    
                                    <div id="paymentDiv" class="mb-4">
                                        <div id="paypal-button-container" class="shadow-sm rounded overflow-hidden"></div>
                                    </div>
                                    
                                    <div class="mt-auto">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-shield-check text-primary me-2" style="font-size: 1.5rem;"></i>
                                                <span class="small text-muted">Pago seguro garantizado</span>
                                            </div>
                                            <div>
                                                <img src="{{ asset('images/truekly.png') }}" alt="truekly" style="height: 24px;" class="img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script src="https://www.paypal.com/sdk/js?client-id=AVqE7HfPwxBTL0QUys1Lr43kd1RqJgJGDQL_yemYan2WLcJHy5kJ9P_3EX-FY8Ia-yQBQMeb0SXIRN23&currency=EUR" data-sdk-integration-source="button-factory"></script>

<script>
    paypal.Buttons({
        style: {
            size: 'large',
            color: 'gold',
            shape: 'rect',
            label: 'checkout'
        },
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: { value: '{{ $precio_tokens }}' },
                    description: 'TokenSkills'
                }]
            });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                
                if (details.purchase_units && details.purchase_units.length > 0) 
                {
                    // Safely access the amount from the first purchase unit
                    const cantidad = details.purchase_units[0].amount.value;
                    console.log("Amount: ", cantidad);

                    let seller = @json($seller);
                    
                    if (seller && seller.email) 
                    {
                        console.log("Seller email:", seller.email);
                        buyFromSeller(details, cantidad);
                    } 
                    else 
                    {
                        console.log("No seller");
                        buyFromCompany(details)
                    }
                } 
                else 
                {
                    console.error("purchase_units is empty or missing.");
                }
            });
        }
    }).render('#paypal-button-container');

    function buyFromSeller(details, cantidad) {
        $.ajax({
            url: "{{ route('send.paypal.payout') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                receiverEmail: "{{ $seller ? $seller->email : 'default@example.com' }}",
                amount: cantidad,
                note: 'Gracias por tus tokens!',
                comision: 'Hay'
            },
            success: function(response) {
                // Check if the payout was successful
                if (response.batch_header && response.batch_header.batch_status === 'PENDING') {
                    showMessage("Tu pago está pendiente de procesarse.", "warning");
                    
                    updateUserTokens();
                    updateOfferStatus();

                    // Redirect after a delay
                    setTimeout(function() {
                        window.location.href="{{ route('profile.normal') }}";
                    }, 3000);
                } else {
                    showMessage("Hubo un error con el pago.", "danger");
                    console.log(response);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error processing payout:", error);
                showMessage("Error al procesar el pago. Intenta nuevamente.", "danger");
            }
        });
    }

    function buyFromCompany(details) {
        console.log(details);
        showMessage("¡Tu compra ha sido realizada con éxito!", "success");
        updateUserTokens();
    }

    function updateOfferStatus() {
        console.log("Actualizando estado de la oferta.")
        $.ajax({
            url: "/actualizar/oferta/status",
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                offerId: "{{ $offer->id }}"
            },
            success: function(response) {
                console.log('Estado de la oferta actualizada con éxito');
            },
            error: function(error) {
                console.error('Error actualizando: ', error);
            }
        });
    }

    function updateUserTokens() {
        // Update the user's tokens after successful payment
        const newTokens = {{ auth()->user()->tokens }} + {{ $cantidad_tokens }};
        console.log('New Tokens:', newTokens);

        // Send an AJAX request to update the user's tokens in the database
        $.ajax({
            url: '/actualizar-tokens',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                tokens: newTokens
            },
            success: function(response) {
                console.log('Tokens updated successfully')
            },
            error: function(error) {
                console.error('Error updating tokens:', error);
            }
        });
    }

    function showMessage(message, type) {
        const messageBox = $('#messageBox');
        const iconMap = {
            'success': 'bi-check-circle-fill',
            'danger': 'bi-x-circle-fill',
            'warning': 'bi-exclamation-triangle-fill',
            'info': 'bi-info-circle-fill'
        };
        
        const icon = iconMap[type] || iconMap.info;
        
        messageBox
            .html(`<i class="bi ${icon} me-2"></i>${message}`)
            .removeClass('d-none bg-success bg-danger bg-warning bg-info text-white')
            .addClass(`bg-${type} text-white d-flex align-items-center justify-content-center`)
            .hide()
            .fadeIn(500)
            .delay(2000);
            
        if (type === 'success') {
            messageBox.fadeOut(500, function() {
                $(this).removeClass().addClass('d-none').html('');
            });
        }
    }

    function purchaseCompleted() {
        $('#paymentDiv').html('<div class="alert alert-success"><i class="bi bi-check-circle-fill me-2"></i>Pago completado</div>');
        $('#messageBox').html('');
    }
</script>
@endsection