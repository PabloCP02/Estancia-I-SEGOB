@extends('layouts/template')
@include('layouts/headerUser')
@include('layouts/sidebarUser')
@section('contenido')

<div class="content-wrapper">
    <div class="row-md-12">
        <div class="col-md-12">
            <div class="card px-2">
                <!-- Título -->
                <title>Descargar archivos</title>
                <!-- Nombre institución -->
                @auth
                  <h1 class="username text-center mt-2"> {{auth()->user()->username}} </h1>
                @endauth
                <!-- Responsable de la dependencia -->
                <p class="ps-4"><strong>Responsable: </strong>{{ $usuario->name }}</p>
                <!-- Instrucciones de descarga -->
                <p class="text-center mt-2">En esta sección, puedes descargar los formularios correspondientes al censo actual. Cuando finalices con el llenado de estos, subelos en el apartado de subida formularios.</p>
                <!-- Descargar todo -->
                <a class="btn bg-success text-white mt-1" href="{{ route('downloadAll') }}">
                    <i class="fa-solid fa-download"></i> Descargar todos los formularios
                </a>
                <!-- Tabla de descarga -->
                <table class="table table-hover mt-3 text-center">
                  <!-- Encabezado tabla -->
                  <tr>
                      <th scope="col">&nbsp;</th>
                      <th scope="col">Nombre del Archivo</th>
                      <th scope="col">&nbsp;</th>
                      <th scope="col">&nbsp;</th>
                  </tr>
                  <!-- Formularios asignados-->
                  @foreach($status as $statu)
                      @if(auth()->user()->id == $statu->dependencia_id)
                      <tbody>
                          <tr>
                              <td>&nbsp;</td>
                              <td class="col-4">{{ basename($statu->formulario) }}</td>
                              <td>
                                  <a class="descarga" download="{{ $statu->formulario }}" href="{{ asset($statu->formulario) }}">
                                      <i class="fa-solid fa-download"></i>
                                  </a>
                              </td>
                              <td>&nbsp;</td>
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

<!-- JS -->

<script>
// Obtener todos los formularios y agregar un evento de envío a cada uno
document.querySelectorAll('.formularioArchivo').forEach(form => {
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        var archivoInput = this.querySelector('.archivo');
        var archivo = archivoInput.files[0];
        var formData = new FormData();
        formData.append('archivo', archivo);
        formData.append('userId', this.querySelector('.userId').value); // Agregar userId al formData

        fetch(this.getAttribute('action'), { // Obtener la URL del formulario
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                alert(data.message);
                if (data.success && archivo) {
                    this.querySelector('.botonArchivo').style.display = 'none';
                    updateProgressBar();
                }
            })
            .catch(error => console.error('Error:', error));
    });
});
</script>



<!-- Carga de archivos -->
<!-- <script>
// Archivo 1
document.getElementById('formularioArchivo').addEventListener('submit', function(event) {
    event.preventDefault();
    var archivoInput = document.getElementById('archivo');
    var archivo = archivoInput.files[0];
    var formData = new FormData();
    formData.append('archivo', archivo);
    formData.append('userId', document.getElementById('userId').value); // Agregar userId al formData

    fetch('/guardar_archivo.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.success && archivo) {
                document.getElementById('botonArchivo').style.display = 'none';
                updateProgressBar();
            }
        })
        .catch(error => console.error('Error:', error));
});

// Archivo 2
document.getElementById('formularioArchivo2').addEventListener('submit', function(event) {
    event.preventDefault();
    var archivoInput2 = document.getElementById('archivo2');
    var archivo = archivoInput2.files[0];
    var formData = new FormData();
    formData.append('archivo2', archivo);
    formData.append('userId2', document.getElementById('userId2').value); // Agregar userId al formData

    fetch('/guardar_archivo2.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            if (data.success && archivo) {
                document.getElementById('botonArchivo2').style.display = 'none';
                updateProgressBar();
            }
        })
        .catch(error => console.error('Error:', error));
});
</script> -->


@endsection


