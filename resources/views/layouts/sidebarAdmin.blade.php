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

        <!-- <li>
            <a href="#">
            <i class="fa-regular fa-file"></i>
                <span class="nav-item">CNGE_2023_M1_S3</span>
            </a>
            <span class="tooltip">01_3_CNGE_2023_M1_S3_VF_01jun23</span>
        </li>

        <li>
            <a href="#">
            <i class="fa-regular fa-file"></i>
                <span class="nav-item">CNGE_2023_M1_S4</span>
            </a>
            <span class="tooltip">01_4_CNGE_2023_M1_S4_VF_28mar23</span>
        </li> -->
    </ul>
</div>


<script>
    let btn = document.querySelector('#btn');
    let sidebar = document.querySelector('.sidebar');   
    btn.onclick = function() {
        sidebar.classList.toggle('active');
    };
    
</script>