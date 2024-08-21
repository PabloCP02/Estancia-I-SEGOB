
<div class="mt-3 sidebarUser fixed">
     <!-- <div class="top">
        <i class="fa-solid fa-bars" id="btn"></i>
    </div>
    <div class="user">
        <div>
           
        </div>
    </div>  -->
    <ul class="mx-0 px-0">
        <!-- Home -->
        <li >
            <a class="usuario" href="{{ url ('/users') }}">
                <i class="fa-solid fa-house iconos"></i> &nbsp; Inicio 
            </a>
        </li>
        <!-- Descargar formularios -->
        <li>
            <a class="usuario" href="{{ url('usuario/'.$usuario->id.'/descargar') }}">
                <i class="fa-solid fa-file-arrow-down"></i>
                <span class="nav-item"> &nbsp; Descarga formularios </span>
            </a>
        </li>
        <!-- Subir formularios -->
        <li>
            <a class="usuario" href="{{ url('usuario/'.$usuario->id) }}">
                <i class="fa-solid fa-file-arrow-up"></i> Subida formularios 
            </a>
        </li>
        <!-- Estatus formularios
        <li>
            <a class="usuario" href="{{ url('usuario/'.$usuario->id) }}">
                <i class="fa-solid fa-file-circle-check"></i>
                <span class="nav-item">&nbsp; Estatus  </span>
            </a>
        </li> -->
        <!-- Capacitación -->
        <li>
            <a class="usuario" href="{{ url('usuario/'.$usuario->id) }}">
            <i class="fa-solid fa-person-chalkboard"></i>
                <span class="nav-item">Capacitación</span>
            </a>
        </li>
    </ul>
</div>


<script>
    let btn = document.querySelector('#btn');
    let sidebar = document.querySelector('.sidebar');   
    btn.onclick = function() {
        sidebar.classList.toggle('active');
    };
</script>