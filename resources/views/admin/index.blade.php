@extends('layouts/template')


@include('layouts/header')
@include('layouts/sidebarAdmin')

@section('contenido')

    <div class="content-wrapper">
        <div class="row-md-12">
            <div class="col-md-12">
                <div class="card px-2">
                    <!-- Nombre institución -->
                    @auth
                    <h1 class="username text-center mt-3 mb-2">{{auth()->user()->username}} </h1>
                    <h4 class="username text-center mt-3 mb-3">Bienvenido(a) {{auth()->user()->name}} </h4>
                    <!-- Bienvenida -->
                    <!-- <p class="mt-2 mb-4">En esta sección, como administrador, tendrás la capacidad de dar de alta a las instituciones participantes en cada censo.</p> -->
                    <!-- <p class="mb-4">Además, podrás realizar un seguimiento del progreso de cada institución y descargar los archivos que suban a la plataforma.</p> -->
                    @endauth
                    <img class="mb-3 m-auto w-50" src="{{ asset('imagenes/censo.png')}}" alt="">
                    <!-- Barra de progreso -->
                    <h5 class="ms-2 mt-2">El avance general de las dependencias participantes en este censo es de:</h5>

                    <?php
                    $total = 0;
                    $auxiliar = 0;
                    foreach($status as $statu){
                        $total++;
                        if($statu->completado == 1){
                            $auxiliar++;
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
                    <h5 class="text-end me-2 mt-2 mb-5"><?php echo $auxiliar; ?> formulario completado de <?php echo $total ?></h5>
                    @else
                    <h5 class="text-end me-2 mt-2 mb-5"><?php echo $auxiliar; ?> formularios completados de <?php echo $total ?></h5>
                    @endif
                
                </div>
                
            </div>
        </div>
    </div>

@endsection