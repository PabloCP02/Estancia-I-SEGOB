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
                    <div class="py-3 mt-2 mb-3 bg-light d-flex justify-content-around">
                      
                        <form action="{{ route('historico.store') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary">Iniciar censo</button>
                        </form>

                        <!-- <button class="btn btn-danger">Finalizar censo</button> -->
                    </div>

                    @foreach($historicos as $historico)
                    <div class="card text-center mb-3">
                        <div class="card-header">
                           {{ $historico->inicio}}
                        </div>
                        <div class="card-body">
                            @if($historico->fin == "")
                            <form id="finalizarCensoForm" action="{{ route('historico.finalizar') }}" method="POST">
    @csrf
    <input type="hidden" name="userId" value="{{ $historico->id }}">
    <button type="submit" class="m-0 btn btn-danger">Finalizar censo</button>
</form>



                            @else
                                <a class="descarga" download="{{ basename($historico->archivo) }}" href="{{ asset($historico->archivo) }}">
                                      <i class="fa-solid fa-download"></i> {{ basename($historico->archivo) }}
                                  </a>
                            @endif
                        </div>
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