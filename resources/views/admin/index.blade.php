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
                    <!-- <img class="mb-3 m-auto w-50" src="{{ asset('imagenes/censo.png')}}" alt=""> -->
                    <!-- Inicio Cards -->
                    <div class="row g-4 mt-2 mb-5">
                        <!-- Columna para las cards -->
                        <div class="col-md-8 d-flex flex-wrap">
                            <div class="col-md-6 mb-3">
                                <div class="card me-2">
                                    <h4 class="mt-3 text-center"><i class="fa-solid fa-user"></i> Dependencias</h4>
                                    <hr>
                                    <?php
                                        // Contar dependencias
                                        $cont = 0;
                                        foreach($usuarios as $usuario){
                                            if($usuario->role != "admin"){
                                                $cont++;
                                            }
                                        }
                                    ?>
                                    <div class="card-body">
                                        <h1 class="card-title text-center"><?php echo $cont; ?></h1>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <h4 class="mt-3 text-center"><i class="fa-solid fa-file"></i> Formularios</h4>
                                    <hr>
                                    <?php
                                        // Contar formularios
                                        $aux = 0;
                                        foreach($formularios as $formulario){
                                            $aux++;
                                        }
                                    ?>
                                    <div class="card-body">
                                        <h1 class="card-title text-center"><?php echo $aux; ?></h1>
                                    </div>
                                </div>
                            </div>
                            <!-- Total de los archivos -->
                            <?php
                            // Variables para el conteo de archivos
                            $total = 0;
                            $completado = 0;
                            $rechazado = 0;
                            $revision = 0;
                            $sinSubir = 0;

                            // Contar los diferentes estados
                            foreach($status as $statu){
                                $total++;
                                if ($statu->completado == 1) {
                                    $completado++;
                                } elseif ($statu->completado == 2) {
                                    $rechazado++;
                                } elseif($statu->completado == 3) {
                                    $revision++;
                                }else{
                                    $sinSubir++; 
                                }
                            }
                            ?>
                            <div class="col-md-6 mb-3">
                                <div class="card me-2">
                                    <h4 class="mt-3 text-center"><i class="fa-solid fa-check"></i> Archivos aceptados</h4>
                                    <hr>
                                    <div class="card-body">
                                        <h1 class="card-title text-center"><?php echo $completado; ?></h1>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <h4 class="mt-3 text-center"><i class="fa-solid fa-xmark"></i> Archivos rechazados</h4>
                                    <hr>
                                    <div class="card-body">
                                        <h1 class="card-title text-center"><?php echo $rechazado; ?></h1>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card me-2">
                                    <h4 class="mt-3 text-center"><i class="fa-solid fa-eye"></i> Archivos en revisión</h4>
                                    <hr>
                                    <div class="card-body">
                                        <h1 class="card-title text-center"><?php echo $revision; ?></h1>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="card">
                                    <h4 class="mt-3 text-center"><i class="fa-regular fa-clock"></i> Archivos sin subir</h4>
                                    <hr>
                                    <div class="card-body">
                                        <h1 class="card-title text-center"><?php echo $sinSubir; ?></h1>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!-- Columna para el gráfico -->
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <!-- Contenedor específico para el gráfico -->
                                    <div id="container" style="width:100%; height:400px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Fin Cards -->
                </div>
            </div>
        </div>
    </div>
    <!-- JS grafica pastel -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <!-- Script para realizar la gráfica de pastel -->
    <script>
        Highcharts.chart('container', {
            chart: {
                type: 'pie'
            },title: {
                text: '% Porcentaje de avance'
            },
            tooltip: {
                valueSuffix: '%'
            },
            plotOptions: {
                series: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: [{
                        enabled: true,
                        distance: 20
                    }, {
                        enabled: true,
                        distance: -40,
                        format: '{point.percentage:.1f}%',
                        style: {
                            fontSize: '1.2em',
                            textOutline: 'none',
                            opacity: 0.7
                        },
                        filter: {
                            operator: '>',
                            property: 'percentage',
                            value: 10
                        }
                    }]
                }
            },
            series: [
            {
                name: 'Percentage',
                colorByPoint: true,
                data: [
                    {
                        <?php
                        // Cálculo de porcentajes
                        if ($total == 0) {
                            $progresoCompletado = $progresoRechazado = $progresoRevision = 0;
                        } else {
                            $progresoCompletado = round(($completado * 100) / $total, 2);
                            $progresoRechazado = round(($rechazado * 100) / $total, 2);
                            $progresoRevision = round(($revision * 100) / $total, 2);
                            $progresoSinSubir = round(($sinSubir * 100) / $total, 2);
                        }
                        ?>
                        name: 'Completado',
                        y: <?php echo $progresoCompletado; ?>,
                        color: '#0000FF' // Azul
                    },
                    {
                        name: 'Rechazado',
                        y: <?php echo $progresoRechazado; ?>,
                        color: '#FF0000' // Rojo
                    },
                    {
                        name: 'En revisión',
                        y: <?php echo $progresoRevision; ?>,
                        color: '#FFFF00' // Amarillo
                    },
                    {
                        name: 'Faltantes',
                        y: <?php echo $progresoSinSubir; ?>,
                        color: '#008000' // Verde
                    }
                ]
            }
        ]
        });
    </script>

@endsection