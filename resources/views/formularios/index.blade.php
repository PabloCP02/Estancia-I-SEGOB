@extends('layouts/template')
@include('layouts/headerUser')
@include('layouts/sidebarUser')
@section('contenido')

<div class="content-wrapper">
    <div class="row-md-12">
        <div class="col-md-12">
            <div class="card px-2 mb-5">
                <!-- Título -->
                <title>Subir archivos</title>
                <!-- Nombre institución -->
                @auth
                  <h1 class="username text-center mt-2"> {{ auth()->user()->username }} </h1>
                @endauth
                <!-- Instrucciones de subida -->
                <p class="text-justify mt-2"><strong>{{ auth()->user()->name }}</strong> en esta sección, podrás subir los formularios que ya hayas completado. En caso de que el archivo haya sido llenado incorrectamente en el área de mensajes se te mencionaran las correcciones que debes realizar para poder subirlo de nuevo.</p>

                <!-- Mensajes -->
                <div class="text-center mb-4">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#mensajeModal"><i class="fa-solid fa-message"></i> Mensajes</button>
                </div>

                <!-- Modal de mensajes-->
                <div class="modal fade" id="mensajeModal" tabindex="-1" aria-labelledby="mensajeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="mensajeModalLabel"><h4 class="me-2"><i class="fa-solid fa-user-tie"></i> </h4>Administrador
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                @php
                                    // Aquí obtienes los mensajes entre el usuario actual y el administrador
                                    $mensajes = \App\Models\Mensaje::where(function($query) {
                                        $query->where('user_id', auth()->user()->id)
                                              ->orWhere('receiver_id', auth()->user()->id);
                                    })->orderBy('created_at', 'asc')->get();
                                @endphp

                                <!-- Mostrar los mensajes -->
                                <div class="mb-3">
                                    @foreach($mensajes as $mensaje)
                                        <div class="mb-3 rounded">
                                            <!-- <strong>{{ $mensaje->user_id == auth()->id() ? 'Tú' : 'Administrador' }}:</strong> -->
                                            @if($mensaje->user_id == auth()->user()->id && $mensaje->receiver_id == 1)
                                              <div class="d-flex justify-content-end">
                                                  <p class="me-2 rounded text-white px-3 py-1 bg-success">{{ $mensaje->mensaje }}</p>
                                                  <h4 class=""><i class="fa-solid fa-circle-user"></i></h4>
                                              </div>
                                              <p class="text-end">{{ $mensaje->created_at }}</p>
                                            @elseif($mensaje->user_id == 1 && $mensaje->receiver_id == auth()->user()->id)
                                            <div class="">
                                              <div class="d-flex align-items-center">
                                                <h4 class="me-2"><i class="fa-solid fa-user-tie"></i></h4>
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
                                    <input type="hidden" name="receiver_id" value="1"> <!-- ID del administrador -->
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
                
                <!-- Mostrar mensajes flash -->
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error')) 
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                
                <div class="table-responsive">
                    <table class="table table-striped mt-3">
                        <thead>
                            <tr>
                                <th scope="col">Archivos asignados</th>
                                <th scope="col">Cargar archivo</th>
                                <th scope="col">Estatus</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($status as $statu)
                                @if(auth()->user()->id == $statu->dependencia_id)
                                    <tr>
                                        <td class="col-4">{{ basename($statu->formulario) }}</td>
                                        <td>
                                            @if($statu->revision == "" || $statu->completado == 2)
                                            <form class="formularioArchivo d-flex align-items-center" action="{{ url('usuario/'.$usuario->id.'/upload') }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="userId" class="userId" value="{{ auth()->user()->id }}">
                                                <input type="hidden" name="statuId" class="statuId" value="{{$statu->id}}">
                                                <input type="file" name="archivo" class="archivo form-control me-2" required>
                                                <button type="submit" class="btn btn-primary botonArchivo"><i class="fa-solid fa-upload"></i> Subir archivo</button>
                                            </form>
                                            @else
                                                {{ basename($statu->revision) }}
                                            @endif
                                        </td>
                                        <td class="d-flex">
                                            @if($statu->completado == 1)
                                                <button class="btn btn-primary"><i class="fa-solid fa-check"></i> Aceptado</button>
                                            @endif
                                            @if($statu->completado == 2)
                                                <button class="btn btn-danger"><i class="fa-solid fa-xmark"></i> Rechazado</button>
                                            @endif
                                            @if($statu->completado == 3)
                                                <button class="btn btn-warning"><i class="fa-solid fa-eye"></i> En revisión</button>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @guest
            <p>Para ver el contenido inicie sesión <a class="link" href="/inicioSesion">Iniciar sesión</a></p>
            @endguest

        </div>
    </div>
</div>

@endsection
