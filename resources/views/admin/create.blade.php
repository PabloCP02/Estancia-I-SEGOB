@extends('layouts/template')
@include('layouts/header')
@include('layouts/sidebarAdmin')
@section('contenido')
<div class="content">
    <div class="content-wrapper">
        <div class="row-md-12">
            <div class="col-md-12">
                <form action="{{ route('usuario.store') }}" method="post" class="form-horizontal">
                    @csrf
                    <div class="card">
                        
                        <div class="card-header card-header-primary">
                            <h4 class="pt-2 card-title"><i class="fw-bold fa-solid fa-plus"></i> Agregar dependencia</h4>
                            <p class="card-category">Ingresar datos</p>
                        </div>
                        <div class="card-body">
                            <!-- Institución -->
                            <div class="row">
                                <label for="username" class="col-sm-2 col-form-label">Nombre de la dependencia*:</label>
                                <div class="col-sm-7">
                                    <input type="text" name="username" class="form-comtrol" placeholder="Nombre de la dependencia" autofocus>
                                </div>
                            </div>
                            <!-- Responsable -->
                            <div class="row">
                                <label for="name" class="col-sm-2 col-form-label">Nombre del responsable*:</label>
                                <div class="col-sm-7">
                                    <input type="text" name="name" class="form-comtrol" placeholder="Nombre del responsable" autofocus>
                                </div>
                            </div>
                            <!-- Correo -->
                            <div class="row">
                                <label for="name" class="col-sm-2 col-form-label">Correo electrónico*:</label>
                                <div class="col-sm-7">
                                    <input type="email" name="email" class="form-comtrol" placeholder="Correo electrónico" autofocus>
                                </div>
                            </div>
                            <!-- Contraseña -->
                            <div class="row">
                                <label for="name" class="col-sm-2 col-form-label">Contraseña*:</label>
                                <div class="col-sm-7">
                                    <input type="password" name="password" class="form-comtrol" placeholder="Contraseña" autofocus>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer ml-auto mr-auto">
                            <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk"></i> Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection