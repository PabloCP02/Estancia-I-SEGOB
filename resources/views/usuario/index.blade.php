@extends('layouts/template')
@include('layouts/headerUser')
@include('layouts/sidebarUser')
@section('contenido')
    <div class="content-wrapper">
        <div class="row-md-12">
            <div class="col-md-12 pt-3">
                <div class="card px-2">
                    <!-- Nombre institución -->
                    @auth
                    <h1 class="username text-center mt-3 mb-2">{{auth()->user()->username}} </h1>
                    <h4 class="username text-center mt-3 mb-3">Bienvenido(a) {{auth()->user()->name}} </h4>
                    <!-- Bienvenida -->
                    <!-- <p class="mb-3"><strong>Instrucciones:</strong></p>
                    <p class="mb-5">Bienvenido al inicio del proceso de censo correspondiente a este año. <br><br>En el menú lateral izquierdo, encontrarás las opciones para descargar los formularios necesarios para este censo, así como la opción para subirlos. <br><br>Como primer paso, te recomendamos descargar los formularios a rellenar. <br><br>Una vez completados, podrás subirlos en la sección correspondiente. ¡Gracias por tu participación!</p> -->
                    <img class="m-auto w-50" src="{{ asset('imagenes/censo.png')}}" alt="">
                    @endauth

                    <!-- Barra de progreso -->
                    <!-- <p class="mb-3">@auth {{auth()->user()->name}} @endauth tu avance en el llenado de los formularios es de:</p> -->
                    <?php
                    $total = 0;
                    $auxiliar = 0;
                    foreach($status as $statu){
                        if($usuario->id == $statu->dependencia_id){
                            $total++;
                            if($statu->completado == 1){
                                $auxiliar++;
                            }
                        }
                        
                    }
                    if($total == 0){
                        $progreso = 0;
                    }else{
                    // Calculamos el progreso
                    $progreso = ($auxiliar * 100)/$total;
                     // Redondear los decimales
                     $progreso = round($progreso, 2);
                    }
                    // El color cambia conforme al porcentaje de la barra 
                    if ($progreso <= 33.3) {
                        $color = 'red';
                    } elseif ($progreso > 33.3 && $progreso <= 66.6) {
                        $color = 'green';
                    }else{
                        $color = 'blue';
                    }
                    ?>

                    <div class="mx-2 progress mb-3" style="height: 30px;">
                        <div id="progressBar" class="progress-bar" role="progressbar" 
                            style="width: <?php echo $progreso; ?>%; background-color: <?php echo $color; ?>;" 
                            aria-valuenow="<?php echo $progreso; ?>" aria-valuemin="0" aria-valuemax="100">
                            <?php echo $progreso; ?>%
                        </div>
                    </div>
                    @if($auxiliar == 1)
                    <h5 class="text-end me-2 mt-2 mb-5">Tu avance es: <?php echo $auxiliar; ?> formulario completado de <?php echo $total ?></h5>
                    @else
                    <h5 class="text-end me-2 mt-2 mb-5">Tu avance es: <?php echo $auxiliar; ?> formularios completados de <?php echo $total ?></h5>
                    @endif
                    

                    @guest
                    <p>Para ver el contenido inicie sesión <a class="link" href="/inicioSesion">Iniciar sesión</a></p>
                    @endguest
                </div>
            </div>
        </div>
    </div>
@endsection
