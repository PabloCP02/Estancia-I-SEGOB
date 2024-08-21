@extends('layouts/template')

@include('layouts/headerUser')
@include('layouts/sidebarUser')

@section('contenido')

    <div class="content-wrapper">
        <div class="row-md-12">
            <div class="col-md-12">
                <div class="card">
                    <h3>Bienvenido  al panel de formularios </h3> 

                    @auth
                    <p> &nbsp; Bienvenido {{auth()->user()->username}} !!</p>

                    <p>Bienvenido al sitio para realizar el Censo correspondiente a este año.</p>
                    <p>En la barra lateral derecha se encuentran los formatos a llenar.</p>
                    <p>Usted podra descargarlos para hacer su respectivo llenado y subida de archivos con la informacion solicitada.</p>
                    <p></p>
                   

                    @endauth 

                    @guest
                    <p>Para ver el contenido inicie sesión <a class="link" href="/inicioSesion">Iniciar sesión</a></p>
                    @endguest
                
                </div>
                
            </div>
        </div>
    </div>

@endsection