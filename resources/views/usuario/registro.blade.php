@extends('layouts/template')


@include('layouts/headerUser')

@section('contenido')
 <div class="contenidoRegistro">
<div class="row"> 
   <!-- <div class="col-md-11">
        <div class="card"> -->

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


            <form class="registro" action="/registro" method="post" >
            @csrf
                <h1>REGISTRO</h1>
                <hr>
                <i class="fa-regular fa-user"></i>
                <label class="text-white"> Usuario </label>
                <input type="text" name="username" placeholder="Nombre de usuario">

                <i class="fa-regular fa-envelope"></i>
                <label class="text-white"> Correo Electronico </label>
                <input type="email" name="email"  placeholder="Correo Electronico">


                <i class="fa-solid fa-lock"></i>
                <label class="text-white"> Contraseña </label>
                <input type="password" name="password"  placeholder="Contraseña">
               
                <i class="fa-solid fa-lock"></i>
                <label class="text-white"> Confirmar contraseña </label>
                <input type="password" name="password_confirmation"  placeholder="Contraseña">

                <hr>
                <button class="btnIS" type="submit" value="Registrarse">Registrarse</button>
                <a class="sesion" href="{{ url('/inicioSesion') }}">Ya tienes una cuenta?  Inicia sesion</a>
            </form>

</div>
</div>
<!-- </div>
</div> -->

    

@endsection