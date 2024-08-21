@extends('layouts/template')
@include('layouts/header')
@include('layouts/sidebarAdmin')
@section('contenido')

<div class="content-wrapper">
    <div class="row-md-12">
        <div class="col-md-12">
            <div class="card ms-2 me-2 mb-5">
                <!-- Titulo -->
                <title>Lista de Archivos</title>
                <!-- información de la dependencia -->
                <h1 class="username text-center mt-4">{{$usuario->username}}</h1>
                <div class="py-3 mt-2 mb-3 bg-light d-flex justify-content-around">
                    <p class="mx-2"><strong>Responsable:</strong> {{$usuario->name}}</p>
                    <p class="mx-2"><strong>Correo electrónico:</strong> {{$usuario->email}}</p>
                    <!-- Asignar formularios -->
                    <div class="text-end">
                        <a href="{{ url('/status/'.$usuario->id.'/create') }}" class="btn btn-primary " role="button" aria-disabled="true"><i class="fa-solid fa-list-check"></i> Asignar formularios</a>
                    </div>
                    <!-- Mensajes -->
                    <div class="text-center mb-4">
                        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#mensajeModal"><i class="fa-solid fa-message"></i> Mensajes</button>
                    </div>

                    <!-- Modal de mensajes-->
                    <div class="modal fade" id="mensajeModal" tabindex="-1" aria-labelledby="mensajeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="mensajeModalLabel"><h4 class="me-2"><i class="fa-solid fa-user"></i> </h4>{{ $usuario->username }}
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    @php
                                        // Aquí obtienes los mensajes entre el usuario actual y el administrador
                                        $mensajes = \App\Models\Mensaje::where(function($query) {
                                            $query->where('user_id', auth()->id())
                                                ->orWhere('receiver_id', auth()->id());
                                        })->orderBy('created_at', 'asc')->get();
                                    @endphp

                                    <!-- Mostrar los mensajes -->
                                    <div class="mb-3">
                                        @foreach($mensajes as $mensaje)
                                            <div class="mb-3 rounded">
                                                <!-- <strong>{{ $mensaje->user_id == auth()->id() ? 'Tú' : 'Administrador' }}:</strong> -->
                                                
                                                @if($mensaje->user_id == 1 && $mensaje->receiver_id == $usuario->id)
                                                <div class="d-flex justify-content-end">
                                                <h4 class="me-2"><i class="fa-solid fa-user-tie"></i></h4>
                                                <p class="rounded text-white px-3 py-1 bg-success">{{ $mensaje->mensaje }}</p>
                                                </div>
                                                <p class="text-end">{{ $mensaje->created_at }}</p>
                                                @elseif($mensaje->user_id == $usuario->id && $mensaje->receiver_id == 1)
                                                <div class="">
                                                <div class="d-flex align-items-center">
                                                    <h4 class="me-2"><i class="fa-solid fa-circle-user"></i></h4>
                                                    <div class="d-flex justify-content-start">
                                                        <p class="rounded text-white px-3 py-1 bg-secondary">{{ $mensaje->mensaje }}</p>
                                                    </div>
                                                </div>
                                                <p class="text-start">{{ $mensaje->created_at }}</p>
                                                </div>
                                                @endif
                                            </div>
                                        @endforeach
                                        </div>

                                    <!-- Formulario para enviar un nuevo mensaje -->
                                    <form action="{{ route('mensajes.enviar') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="receiver_id" value="{{ $usuario->id }}"> <!-- ID del usuario -->
                                        <div class="mb-3">
                                            <label for="mensaje" class="form-label">Escribir mensaje</label>
                                            <textarea class="form-control" id="mensaje" name="mensaje" rows="3" required></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-paper-plane"></i> Enviar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="text-end">
                        <a href="#" class="btn btn-warning " role="button" aria-disabled="true"><i class="bi bi-pencil-square"></i> Editar información de la dependencia</a>
                    </div>
                    <div class="">
                        <form action="#" method="POST">
                            @method("DELETE")
                            @csrf
                            <button type="submit" class="btn btn-danger "><i class="bi bi-trash"></i> Eliminar dependencia</button>
                        </form>
                    </div> -->
                </div>
                <!-- Barra de progreso -->
                <p class="mx-2">El avance de {{$usuario->username}} es del:</p>
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
                    <h5 class="text-end me-2 mt-2 mb-2 me-2"><?php echo $auxiliar; ?> de <?php echo $total ?></h5>
                    @else
                    <h5 class="text-end me-2 mt-2 mb-2 me-2"><?php echo $auxiliar; ?> de <?php echo $total ?></h5>
                    @endif
          

                <!-- Archivos a revisar -->
                <hr>
                <h5 class="ps-2 username">Archivos para revisar</h5>
                <table class="table table-hover">
                    <thead>
                        <th></th>
                        <th></th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach($status as $statu)
                            @if($usuario->id == $statu->dependencia_id && $statu->completado!=1)
                        <tr>
                            @if($statu->revision != "")
                            <td>{{ basename($statu->revision) }}</td>
                            <td>
                                <a class="descarga" download="{{ $statu->revision }}" href="{{ asset($statu->revision) }}">
                                      <i class="fa-solid fa-download"></i> Descargar
                                  </a>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button 
                                        class="btn dropdown-toggle 
                                            @if($statu->completado === 1) btn-success 
                                            @elseif($statu->completado === 2) btn-danger 
                                            @else btn-warning 
                                            @endif" 
                                        type="button" 
                                        id="dropdownMenuButton{{ $loop->index }}" 
                                        data-bs-toggle="dropdown" 
                                        aria-expanded="false">
                                        @if($statu->completado === 1)
                                            <i class="fa-solid fa-check"></i> Aceptado
                                        @elseif($statu->completado === 2)
                                            <i class="fa-solid fa-xmark"></i> Rechazado
                                        @else
                                            <i class="fa-solid fa-eye"></i> En Revisión
                                        @endif
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $loop->index }}">
                                        <li>
                                            <form action="{{ route('status.aceptar-archivo') }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="statuId" value="{{ $statu->id }}">
                                                <input type="hidden" name="userId" value="{{ $usuario->id }}">
                                                <button type="submit" class="dropdown-item">
                                                    <i class="fa-solid fa-check"></i> Aceptar
                                                </button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="{{ route('status.rechazar-archivo') }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="statuId" value="{{ $statu->id }}">
                                                <input type="hidden" name="userId" value="{{ $usuario->id }}">
                                                <button type="submit" class="dropdown-item">
                                                    <i class="fa-solid fa-times"></i> Rechazar
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                            @endif
                        </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>





                <!-- Archivos completados -->
                <hr>
                <h5 class="ps-2 username">Archivos completados</h5>
                <table class="table table-hover">
                <thead>
                    <th></th>
                    <th></th>
                    <th></th>
                </thead>
                @foreach($status as $statu)
                    @if($usuario->id == $statu->dependencia_id && $statu->completado==1)
                    <tbody>
                        <tr>
                            @if($statu->revision != "")
                            <td>{{ basename($statu->revision) }}</td>
                            <td>
                                <a class="descarga" download="{{ $statu->revision }}" href="{{ asset($statu->revision) }}">
                                      <i class="fa-solid fa-download"></i> Descargar
                                  </a>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button 
                                        class="btn dropdown-toggle 
                                            @if($statu->completado === 1) btn-success 
                                            @elseif($statu->completado === 2) btn-danger 
                                            @else btn-warning 
                                            @endif" 
                                        type="button" 
                                        id="dropdownMenuButton{{ $loop->index }}" 
                                        data-bs-toggle="dropdown" 
                                        aria-expanded="false">
                                        @if($statu->completado === 1)
                                            <i class="fa-solid fa-check"></i> Aceptado
                                        @elseif($statu->completado === 2)
                                            <i class="fa-solid fa-xmark"></i> Rechazado
                                        @else
                                            <i class="fa-solid fa-eye"></i> En Revisión
                                        @endif
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $loop->index }}">
                                        <li>
                                            <form action="{{ route('status.aceptar-archivo') }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="statuId" value="{{ $statu->id }}">
                                                <input type="hidden" name="userId" value="{{ $usuario->id }}">
                                                <button type="submit" class="dropdown-item">
                                                    <i class="fa-solid fa-check"></i> Aceptar
                                                </button>
                                            </form>
                                        </li>
                                        <li>
                                            <form action="{{ route('status.rechazar-archivo') }}" method="POST" class="d-inline">
                                                @csrf
                                                <input type="hidden" name="statuId" value="{{ $statu->id }}">
                                                <input type="hidden" name="userId" value="{{ $usuario->id }}">
                                                <button type="submit" class="dropdown-item">
                                                    <i class="fa-solid fa-times"></i> Rechazar
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                            @endif
                        </tr>
                    </tbody>
                    @endif
                @endforeach
                </table>






                <!-- Visualizar archivos asignados -->
                 <hr>
                <h5 class="ps-2 username">Archivos asignados</h5>
                <table class="table table-hover">
                <thead>
                    <th></th>
                    <th></th>
                </thead>
                @foreach($status as $statu)
                    @if($usuario->id == $statu->dependencia_id)
                    <tbody>
                        <tr>
                            <td>{{ basename($statu->formulario) }}</td>
                            <td class="">
                                <form action="{{ url('status/'.$statu->id) }}" method="POST">
                                    @method("DELETE")
                                    @csrf
                                    <input type="hidden" value="{{ $usuario->id }}" name="idUser">
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                    @endif
                @endforeach
                </table>









                
                

            </div>

            @guest
            <p>Para ver el contenido inicie sesión <a class="link" href="/inicioSesion">Iniciar sesión</a></p>
            @endguest

        </div>
    </div>
  </div>
</div>

