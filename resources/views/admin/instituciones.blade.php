@extends('layouts/template')
@include('layouts/header')
@include('layouts/sidebarAdmin')
@section('contenido')
    <div class="content-wrapper">
        <div class="row-md-12">
            <div class="col-md-12">
                <div class="card px-3">
                    <h2 class="fw-semibold text-center pt-4"><i class="fa-solid fa-building-columns iconos"></i> Dependencias</h2> 
                    <hr>
                    <div class="d-flex justify-content-between">
                        <div>
                            <p style="font-size: 50px;">
                                <a href="{{ url('usuario/create') }}" class="btn btn-success btn-lg ms-1" role="button"><i class="fa-solid fa-user-plus"></i> &nbsp; Agregar dependecia</a>
                            </p>
                        </div>

                        <div>
                        <form class="d-flex align-items-center" action="{{ url('/altaInstituciones') }}" method="GET" class="d-flex" role="search">
                            <input class="form-control me-2" type="text" placeholder="Buscar dependencia" aria-label="Search" name="username">
                            <button class="me-3 btn btn-secondary h-50" type="submit" value="enviar"><h5><i class="fa-solid fa-magnifying-glass"></i></h5></button>
                        </form>
                        </div>
                    </div>

                    <!-- <p style="font-size: 50px;">
                        <a href="" class="btn btn-lg ms-2"  role="button"><i class="fa-solid fa-folder-plus"></i> &nbsp; Registrar nueva institución</a>
                    </p> -->
                <div class="card">

                <main>
                 <div class="container py-4">
                 <!-- <h2  style="text-align: center;"></h2> -->
                 <h5>Avance total correspondiente al censo actual:</h5>
                 <hr>

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

                    <div class="progress mb-3" style="height: 30px;">
                        <div id="progressBar" class="progress-bar" role="progressbar" 
                            style="width: <?php echo $progreso; ?>%; background-color: <?php echo $color; ?>;" 
                            aria-valuenow="<?php echo $progreso; ?>" aria-valuemin="0" aria-valuemax="100">
                            <?php echo $progreso; ?>%
                        </div>
                    </div>

                <table class="table table-hover">
                    <thead>
                        <tr>
                        <th scope="col">No</th>
                        <th scope="col">Dependecia</th>
                        <th scope="col">Avance</th>
                        <th scope="col">Porcentaje</th>
                        <th></th>
                        </tr>
                    </thead>
                        <tbody>
                        <?php
                        $j = 0;
                        $total = 0;
                        ?>
                        @foreach($usuarios as $usuario)
                            @if($usuario->role != 'admin')
                            <tr>
                                <td><?php echo ++$j; ?></td>
                                <td>{{ $usuario->username }}</td>
                                <td>
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
                                    ?>
                                    @if($auxiliar == 1)
                                    <p class=""><?php echo $auxiliar; ?> de <?php echo $total ?></p>
                                    @else
                                    <p class=""><?php echo $auxiliar; ?> de <?php echo $total ?></p>
                                    @endif


                                </td>
                                <td><?php echo $progreso; ?>%</td>
                                <td><button class="btn btn-primary"><a href="{{ url('/altaInstituciones/'.$usuario->id.'/archivos') }}" class="dropdown-item">Ver más</a></button>
                            </td>
                            </tr>
                            @endif
                        @endforeach

                           
                    </tbody>
                </table>
            </div>
        </main>
    </div>


                    @guest
                    <p>Para ver el contenido inicie sesión <a class="link" href="/inicioSesion">Iniciar sesión</a></p>
                    @endguest
                
                </div>
                
            </div>
        </div>
    </div>

@endsection