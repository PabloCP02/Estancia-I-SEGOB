<!-- Encabezado -->
<header class="py-3 d-flex align-items-center px-3 fixed-top mb-5">
    <nav class="py-2 contenedor-nav">
        <div class="back">
            <div class="py-2 container menu containerHeader">
                <!-- Logos  -->
                <div>
                    <a href="#" class="logo me-3"> <img class=""  src="{{ asset('imagenes/escudo.png')}}" alt=""></a>
                    <a href="#" class="logo me-3"> <img class=""  src="{{ asset('imagenes/qroo.png')}}" alt=""></a>
                    <!-- <a href="#" class="logo"> <img class=""  src="{{ asset('imagenes/upbLogoNegro.png')}}" alt=""></a> -->
                    <a href="#" class="me-3"> <img class="imgCenso"  src="{{ asset('imagenes/censo.png')}}" alt=""></a>
                </div>
                <input type="checkbox" id="menu" />
                <label for="menu">
                    <i class="fa-solid fa-bars" class="menu-icono"></i>
                </label>
                <!-- Opciones de editar y cerrar sesión cuando el usuario este autenticado -->
                <nav class="navbar">
                    <ul>
                        <!-- <li><a href="#"><i class="fa-regular fa-user"></i></a></li> -->
                        @auth
                        <li class="dropdown">
                            <a class="link dropdown-toggle" href="#" id="navbarDropdown" role="button" aria-haspopup="true" aria-expanded="false">
                                {{auth()->user()->email}}
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                
                                <li><a class="dropdown-item" href="/logout"><i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión</a></li>
                            </ul>
                        </li>
                        @endauth
                    </ul>
                </nav>
            </div>
        </div>
    </nav>
</header>
<!-- Margen para que el contenido baje de posición inicial -->
<div class="my-5">
    &nbsp;
</div>

