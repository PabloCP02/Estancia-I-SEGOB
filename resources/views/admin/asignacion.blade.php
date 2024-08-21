@extends('layouts/template')
@include('layouts/header')
@include('layouts/sidebarAdmin')
@section('contenido')
<div class="content-wrapper">
    <div class="row-md-12">
        <div class="col-md-12">
            <div class="card px-3 pb-3">
                <h2 class="fw-semibold text-center pt-4"><i class="fa-solid fa-list-check"></i> Asignación de formularios</h2> 
                <div class="d-flex justify-content-between">
                    <div>
                        <p><strong>Dependencia: </strong>{{ $usuario->username }}</p>
                        <p><strong>Responsable: </strong>{{ $usuario->name }}</p>
                    </div>
                    <div>
                        <button class="btn btn-primary" form="asignarForm"><i class="fa-solid fa-floppy-disk"></i> Guardar</button>
                        <!-- Contador de archivos seleccionados -->
                        <p id="contador-archivos" class="mt-5">Archivos seleccionados: 0</p>
                    </div>
                </div> 
                <div class="card">
                    <main>
                        <div class="container py-4">
                            <form id="asignarForm" action="{{ route('asignar.archivos', $usuario->id) }}" method="POST">
                                @csrf
                                @foreach($formularios as $formulario)
                                <div class="container py-2 d-flex justify-content-between align-items-center">
                                    <div class="form-check">
                                        <!-- Checkbox para seleccionar archivos -->
                                        <input class="form-check-input" type="checkbox" name="archivos[]" value="{{ $formulario->formulario }}" id="flexCheckDefault{{ $formulario->id }}">
                                        <label class="form-check-label" for="flexCheckDefault{{ $formulario->id }}">
                                            <!-- Muestra el nombre del archivo -->
                                            {{ basename($formulario->formulario) }}
                                        </label>
                                    </div>
                                </div>              
                                @endforeach
                            </form>
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

<!-- Script para contar los archivos seleccionados -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const checkboxes = document.querySelectorAll('.form-check-input');
        const contadorArchivos = document.getElementById('contador-archivos');

        function actualizarContador() {
            const seleccionados = document.querySelectorAll('.form-check-input:checked').length;
            contadorArchivos.textContent = `Archivos seleccionados: ${seleccionados}`;
        }

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', actualizarContador);
        });

        actualizarContador(); // Inicializar el contador al cargar la página
    });
</script>

@endsection