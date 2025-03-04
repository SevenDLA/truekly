<nav class="navbar navbar-expand-lg navbar-light p-4">
  <div class="container-fluid">
    <a class="navbar-brand" href="/">
      <img src="{{ asset('images/truekly.png') }}" class="img-fluid logo">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup" style="visibility:initial">
      <div class="navbar-nav">
      <ul class="nav nav-underline">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="#">Tienda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#nosotrosModal">Nosotros</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Carrito</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/services">Servicios</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/perfil">Perfil</a>
                </li>
           </ul>
           <form class="d-flex" role="search">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
      </div>
    </div>
  </div>
  <a class="nav-link" style="font-size:30px;float:right;margin-right:20px" href="/login"><i class="bi bi-box-arrow-in-right"></i></a>
</nav>

<!-- Modal -->
<div class="modal fade" id="nosotrosModal" tabindex="-1" aria-labelledby="nosotrosModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="nosotrosModalLabel">Nosotros</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <hr>
        <p align="center">
            <img src="{{ asset('images/truekly.png') }}" width="500" alt="Truekly Logo">
        </p>
        <hr>
        <p align="center">
            La plataforma de intercambio de servicios basada en trueque y créditos virtuales.
        </p>
        <hr>
        <br>
        <h1 align="center">💱 <strong>Truekly</strong></h1>
        <p>Bienvenido a <strong>Truekly</strong>, la plataforma donde el <strong>trueque</strong> de habilidades y servicios se encuentra con la innovación de los <strong>Tokenskills</strong>, una moneda digital que facilita las transacciones entre usuarios. Si no puedes intercambiar directamente tus habilidades, no te preocupes, los <strong>Tokenskills</strong> permiten realizar cualquier transacción de manera rápida, sencilla y segura.</p>
        <h2>Características Clave</h2>
        <p><strong>Truekly</strong> ofrece una experiencia única con estas funcionalidades:</p>
        <ul>
            <li>🤝 <strong>Intercambio Directo de Servicios:</strong> ¿Sabes frontend y alguien necesita aprender backend? ¡Intercámbialo! Truekly te permite negociar habilidades entre usuarios sin intermediarios ni dinero real.</li>
            <li>💰 <strong>Tokenskills:</strong> Tu moneda dentro de Truekly. Acumula Tokenskills ofreciendo tus servicios y utilízalos para adquirir otros servicios o incluso venderlos a otros usuarios.</li>
            <li>🎯 <strong>Interfaz Intuitiva:</strong> Truekly está diseñada para ser extremadamente fácil de usar, permitiendo a los usuarios gestionar tanto los servicios que ofrecen como los Tokenskills con un par de clics.</li>
            <li>🔄 <strong>Sistema de Trueque Flexible:</strong> Fomenta el intercambio directo de conocimientos. Si no es posible un trueque directo, puedes utilizar <strong>Tokenskills</strong> como alternativa, haciendo las transacciones aún más accesibles.</li>
        </ul>
        <h2>Innovaciones</h2>
        <p><strong>Truekly</strong> implementa varias características innovadoras que mejoran la experiencia del usuario:</p>
        <ul>
            <li>🏆 <strong>Trueque Directo:</strong> Truekly fomenta la economía del intercambio, sin necesidad de intermediarios ni dinero real. ¡Negocia servicios y conocimientos de forma directa!</li>
            <li>💸 <strong>Venta de Tokenskills:</strong> Si no necesitas utilizar tus Tokenskills de inmediato, puedes venderlos a otros usuarios a un precio más bajo, ayudando a aquellos que necesiten obtener créditos de forma más económica.</li>
            <li>👨‍💻 <strong>Comisión por Transacción:</strong> Truekly obtiene una pequeña comisión sobre las transacciones realizadas entre los usuarios, lo que asegura la sostenibilidad a largo plazo de la plataforma.</li>
        </ul>
        <h2>Futuras Implementaciones</h2>
        <p><strong>Truekly</strong> no se detiene aquí y tenemos grandes planes para el futuro:</p>
        <ul>
            <li>🚨 <strong>Alertas de Servicios:</strong> Los usuarios podrán configurar alertas personalizadas para recibir notificaciones sobre nuevos servicios que coincidan con sus necesidades.</li>
            <li>📱 <strong>Aplicación Móvil:</strong> Estamos desarrollando una versión móvil para que puedas gestionar tus servicios y Tokenskills desde cualquier lugar, de forma rápida y cómoda.</li>
            <li>📝 <strong>Sistema de Valoraciones:</strong> Los usuarios podrán dejar valoraciones sobre los servicios que recibieron, lo que ayudará a crear una red de confianza y a mejorar la calidad del intercambio.</li>
        </ul>
        <blockquote>
            <p>Hecho con pasión por Darren Angelo Lajara Corpuz y Seven de León Amador 🚀</p>
        </blockquote>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>