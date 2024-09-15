@extends('layouts/template')
@include('layouts/header')
@include('layouts/sidebarAdmin')
@section('contenido')
<div class="content-wrapper">
    <div class="row-md-12">
        <div class="col-md-12">
            <div class="card px-2">
                <h2 class="fw-semibold text-center pt-4"><i class="fa-solid fa-clock-rotate-left"></i> Historico</h2> 
                <hr>
                <!-- Mostrar mensaje de error sino hay archivos completados para descargar -->
                @if(isset($no_archivos) && $no_archivos)
                    <div class="alert alert-warning">
                        No hay archivos para descargar ya que no se ha confirmado el correcto llenado de alguno.
                    </div>
                @endif
                <div class="py-3 mt-2 mb-3 bg-light d-flex justify-content-around">
                    <form action="{{ route('historico.store') }}" method="POST">
                        @csrf
                        {{-- Verifica si hay un censo en progreso --}}
                        @php
                            $censoEnProgreso = $historicos->where('fin', '')->isNotEmpty();
                        @endphp
                        {{-- Si hay un censo en progreso, deshabilita el botón --}}
                        <button type="submit" class="btn btn-primary" {{ $censoEnProgreso ? 'disabled' : '' }}>Iniciar censo</button>
                    </form>
                </div>
                @foreach($historicos as $historico)
                    <div class="card text-center mb-3">
                        @if($historico->fin == "")
                        <div class="card-header">
                            <strong><i class="fa-solid fa-hourglass-end"></i> Censo en proceso</strong>
                        </div>
                        <div class="card-body">
                            <p>Censo de Gobiernos Estatales actual. Este censo fue iniciado el <strong>{{ $historico->inicio }}</strong></p>
                            <form id="finalizarCensoForm" action="{{ route('historico.finalizar') }}" method="POST">
                                @csrf
                                <input type="hidden" name="userId" value="{{ $historico->id }}">
                                <button type="submit" class="m-0 btn btn-danger">Finalizar censo</button>
                            </form>
                        </div>
                        @else
                        <div class="card-header">
                            <h5><strong><i class="fa-solid fa-check"></i> Finalizado</strong></h5>
                        </div>
                        <div class="card-body">
                            <a class="mb-3 descarga" download="{{ basename($historico->archivo) }}" href="{{ asset($historico->archivo) }}">
                                <i class="fa-solid fa-download"></i> {{ basename($historico->archivo) }}
                            </a>
                            <p>El censo fue finalizado el <strong>{{ $historico->fin }}</strong></p>
                        </div>
                        @endif
                    
                        <div class="card-footer text-body-secondary">
                            &nbsp;
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('finalizarCensoForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Previene el envío automático del formulario
        var confirmation = confirm('¿Estás seguro de que deseas finalizar el censo? Esto eliminará los archivos asignados para la encuesta de este año y generará un archivo ZIP con todos los archivos subidos por los usuarios.');
        if (confirmation) {
            // Si el usuario confirma, envía el formulario
            this.submit();
        }
    });
</script>
@endsection