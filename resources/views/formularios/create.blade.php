@extends('layouts/template')
@include('layouts/header')
@include('layouts/sidebarAdmin')
@section('contenido')
<div class="content">
    <div class="content-wrapper">
        <div class="row-md-12">
            <div class="col-md-12">
                <form action="{{ route('formularios.store') }}" method="POST" class="form-horizontal" enctype="multipart/form-data">
                    @csrf
                    <div class="card">
                        <div class="card-header card-header-primary py-4">
                            <h4 class="card-title"><i class="fa-solid fa-file-circle-plus"></i> Nuevo formulario</h4>
                        </div>
                        <div class="card-body">
                            <!-- Seleccionar archivo -->
                            <div class="pe-4">
                                <label for="formulario" class="col-form-label">
                                    <h5>Seleccionar archivo:</h5>
                                </label>
                                <input class="form-control w-100 px-2 mb-0" type="file" id="formFile" name="formulario">
                            </div>
                        </div>

                        <div class="card-footer ml-auto mr-auto">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection