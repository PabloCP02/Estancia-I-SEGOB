@extends('layouts/template')

@include('layouts/headerUser')

@section('contenido')

 <div class="contenidoInicio">
<div class="row">
<!--     <div class="col-md-11">
        <div class="card">  -->

            @if($errors->any())
            <div class="alert alert-warning" role="alert">
                <!-- Datos incompletos -->
                <ul>
                    @foreach($errors->all() as $error)
                    <li> {{ $error}} </li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="inicios">
            <form class="inicioSesion" action="/inicioSesion" method="post" >
            @csrf
                <h1>INICIAR SESIÓN</h1>
                <hr>
                <i class="fa-regular fa-user"></i>
                <label class="text-white"> Correo electrónico </label>
                <input class="text-black" type="text" name="username" placeholder="Correo electrónico">

                <i class="fa-solid fa-lock"></i>
                <label class="text-white"> Contraseña </label>
                <input class="text-black" type="password" name="password"  placeholder="Contraseña">
                <hr>
                <button class="btnIS" type="submit" value="Login">Iniciar sesión</button>
                <!--<a class="sesion"  href="{{ url('/registro') }}">Crear una cuenta</a>-->
            </form>
</div>

<!-- </div>
</div>-->
</div> 
</div> 

    

@endsection