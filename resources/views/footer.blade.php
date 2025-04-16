<section class="footer p-4 p-md-5">
    <footer>
        <div class="container py-4">
            <!-- Newsletter subscription section -->
            <div class="row mb-5 align-items-center bg-white p-3 p-md-4 rounded-4 shadow-sm">
                <div class="col-md-6 mb-4 mb-md-0">
                    <p class="fs-5 fw-bold text-dark mb-0">¡Mantente al día! <span class="text-primary">Suscríbete</span> a nuestro boletín para obtener las mejores ofertas.</p>
                </div>
                <div class="col-md-6">
                    <form id="newsletterForm">
                        <div class="row g-2">
                            <div class="col-8 col-md-8">
                                <input type="email" id="newsletterEmail" class="form-control border-primary" placeholder="Inserta tu email aquí" required>
                            </div>
                            <div class="col-4 col-md-4">
                                <button type="submit" class="btn btn-subscribe w-100 fw-bold">Suscribirse</button>
                            </div>
                        </div>
                    </form>
                    <div id="subscriptionSuccess" class="mt-2 text-success d-none">
                        <i class="bi bi-check-circle-fill"></i> ¡Te has suscrito con éxito!
                    </div>
                    <div id="subscriptionError" class="mt-2 text-danger d-none">
                        <i class="bi bi-exclamation-circle-fill"></i> Por favor ingresa un email válido
                    </div>
                </div>
            </div>

            <!-- Logo and social media -->
            <div class="row mb-5 align-items-center">
                <div class="col-md-6 mb-4 mb-md-0 text-center text-md-start">
                    <a class="navbar-brand" href="/">
                        <img src="{{ asset('images/truekly.png') }}" class="img-fluid logo-footer" alt="Truekly">
                    </a>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <div class="d-flex gap-2 gap-md-4 justify-content-center justify-content-md-end">
                        <a href="#" class="social-icon" aria-label="Facebook">
                            <i class="bi bi-facebook fs-3"></i>
                        </a>
                        <a href="#" class="social-icon" aria-label="Instagram">
                            <i class="bi bi-instagram fs-3"></i>
                        </a>
                        <a href="#" class="social-icon" aria-label="Twitter">
                            <i class="bi bi-twitter-x fs-3"></i>
                        </a>
                        <a href="#" class="social-icon" aria-label="LinkedIn">
                            <i class="bi bi-linkedin fs-3"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Footer links -->
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    <h5 class="text-uppercase fw-bold mb-4">Sobre Truekly</h5>
                    <p class="text-light-emphasis">
                        La plataforma de intercambio de servicios basada en trueque y créditos virtuales. Conectamos personas y habilidades de una manera sencilla y directa.
                    </p>
                    <p class="mt-3 mb-0">
                        <i class="bi bi-envelope-fill me-2"></i>
                        <a href="mailto:info@truekly.com" class="text-decoration-none">info@truekly.com</a>
                    </p>
                </div>

                <div class="col-md-8">
                    <div class="row">
                        <div class="col-6 col-md-4 mb-4 mb-md-0">
                            <h5 class="text-uppercase fw-bold mb-4">Explorar</h5>
                            <ul class="list-unstyled footer-links">
                                <li class="mb-2"><a href="/servicios">Servicios</a></li>
                                <li class="mb-2"><a href="#categoriasCarousel">Categorías</a></li>
                                <li class="mb-2"><a href="#usuariosDestacados">Usuarios Destacados</a></li>
                            </ul>
                        </div>
                        <div class="col-6 col-md-4 mb-4 mb-md-0">
                            <h5 class="text-uppercase fw-bold mb-4">Ayuda</h5>
                            <ul class="list-unstyled footer-links">
                                <li class="mb-2"><a href="#">Preguntas Frecuentes</a></li>
                                <li class="mb-2"><a href="#">Servicio al Cliente</a></li>
                                <li class="mb-2"><a href="#">Cómo Funciona</a></li>
                                <li class="mb-2"><a href="#">Contacto</a></li>
                            </ul>
                        </div>
                        <div class="col-6 col-md-4">
                            <h5 class="text-uppercase fw-bold mb-4">Legal</h5>
                            <ul class="list-unstyled footer-links">
                                <li class="mb-2"><a href="#">Términos de Servicio</a></li>
                                <li class="mb-2"><a href="#">Política de Privacidad</a></li>
                                <li class="mb-2"><a href="#">Política de Cookies</a></li>
                                <li class="mb-2"><a href="#">Aviso Legal</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Copyright -->
            <div class="row mt-5 pt-4 border-top border-secondary">
                <div class="col-12 col-md-6 text-center text-md-start mb-3 mb-md-0">
                    <p class="mb-0">&copy; 2025 Truekly. Todos los derechos reservados.</p>
                </div>
                <div class="col-12 col-md-6 text-center text-md-end">
                    <p class="mb-0">Darren Angelo Lajara Corpuz y Seven de León Amador</p>
                </div>
            </div>
        </div>
    </footer>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const newsletterForm = document.getElementById('newsletterForm');
    const newsletterEmail = document.getElementById('newsletterEmail');
    const successMessage = document.getElementById('subscriptionSuccess');
    const errorMessage = document.getElementById('subscriptionError');

    newsletterForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Hide previous messages
        successMessage.classList.add('d-none');
        errorMessage.classList.add('d-none');
        
        // Simple email validation
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(newsletterEmail.value)) {
            errorMessage.classList.remove('d-none');
            return;
        }
        
        // Simulate successful subscription
        successMessage.classList.remove('d-none');
        newsletterEmail.value = ''; // Clear the input
        
        // Hide success message after 5 seconds
        setTimeout(() => {
            successMessage.classList.add('d-none');
        }, 5000);
    });
});
</script>