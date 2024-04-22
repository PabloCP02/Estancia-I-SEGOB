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
                    <p class="mt-2 mb-4">En esta sección, como administrador, tendrás la capacidad de dar de alta a las instituciones participantes en cada censo.</p>
                    <p class="mb-4">Además, podrás realizar un seguimiento del progreso de cada institución y descargar los archivos que suban a la plataforma.</p>
                    @endauth
                    <!-- Barra de progreso -->
                    <p>El avance general de las instituciones participantes en este censo es de:</p>

                 <?php
                    $totalIteraciones = 0; // Inicializa el contador total de iteraciones
                    $rutasNoNulas = 0; // Inicializa el contador de iteraciones donde rutaF no es nula

                    foreach ($usuarios as $usuario) {
                        if ($usuario->role != 'admin') {
                            // Itera sobre todas las columnas de rutaF
                            for ($i = 1; $i <= 10; $i++) {
                                $ruta = "rutaF" . $i;
                                // Incrementa el contador total de iteraciones
                                $totalIteraciones++;
                                // Verifica si la rutaF no es nula
                                if (!empty($usuario->$ruta)) {
                                    // Si no es nula, incrementa el contador de rutas no nulas
                                    $rutasNoNulas++;
                                }
                            }
                        }
                    }
                    if($totalIteraciones == 0){
                        $progresoTotal = 0;
                    }else{
                        $progresoTotal = ($rutasNoNulas * 100) / $totalIteraciones;
                        $progresoTotal = number_format($progresoTotal, 2, '.', '');
                    }
                    
                    ?>

                    <!-- Barra de progreso general -->
                    <div class="progress mb-3" style="height: 30px;">
                        <div class="progress-bar bg-success fw-bold" role="progressbar" style="width: {{ $progresoTotal }}%;" aria-valuenow="{{ $progresoTotal }}" aria-valuemin="0" aria-valuemax="100">{{ $progresoTotal }}%</div>
                    </div>

                
                </div>
                
            </div>
        </div>
    </div>

@endsection