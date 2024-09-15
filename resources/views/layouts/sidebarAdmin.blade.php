<div class="sidebar fixed">
    <div class="top">
        <i class="sandwich fa-solid fa-bars" id="btn"></i>
    </div>
    <div class="user mx-0 px-0">
       
    </div>
    <ul class="mx-0 px-0">
        <li>
            <a href="{{ url('/admin') }}">
            <i class="fa-solid fa-house iconos"></i>
                <span class="nav-item">Inicio</span>
            </a>
        </li>

        <li>
            <a href="{{ url('/altaInstituciones') }}">
            <i class="fa-solid fa-building-columns iconos"></i>
                <span class="nav-item">Dependencias</span>
            </a>
        </li>

        
        <li>
            <a href="{{ url('/formularios') }}">
                <i class="fa-regular fa-file-lines"></i>
                <span class="nav-item">Formularios</span>
            </a>
        </li>

        <li>
            <a href="{{ url('/historico') }}">
                <i class="fa-solid fa-clock-rotate-left"></i>
                <span class="nav-item">Historico</span>
            </a>
        </li>
        <div class="user mb-5 px-0"></div>
        <div class="user mb-5 px-0"></div>
        <div class="user mb-5 px-0"></div>
        <!-- <div class="user mb-5 px-0"></div> -->
         <li class="logo">
            <!-- <a href="#" class="logo">  -->
                <i><img class="me-2"  src="{{ asset('imagenes/upbLogoNegro.png')}}" alt=""></i>
                <span class="nav-item"><img class=""  src="{{ asset('imagenes/upbLogoNegroCompleto.png')}}" alt=""><p class="ms-5 mt-3 text-white" style="font-size: 10px;">XC,HR,JO,PC</p></span>
            <!-- </a> -->
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