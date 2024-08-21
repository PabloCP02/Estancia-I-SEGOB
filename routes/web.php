<?php

use App\Http\Controllers\FormularioController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\SesionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\StatuController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\HistoricoController;
use App\Http\Controllers\MensajeController;
use App\Models\User;
use App\Models\Statu;
use App\Models\Formulario;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/inicioSesion');
});

Route::resource('/formularios', FormularioController::class);
Route::resource('/status', StatuController::class);

Route::get('/formularios', [FormularioController::class, 'index'])
->name('formularios.index');

Route::post('/formularios/progreso', [FormularioController::class, 'update'])
->name('formularios.update');

Route::get('/inicioUsuario', [UserController::class, 'index'])
->name('usuario.index');

Route::get('/inicioUsuario', function () {
    return view('/usuario.index');
});

Route::get('/status/{id}/create', [StatuController::class, 'create']);

Route::get('/usuario/create', [UserController::class, 'create']);
Route::post('/usuario', [UserController::class, 'store'])->name('usuario.store');

/************************************************/
Route::get('/usuario/{id}/edit', [UserController::class, 'edit'])->name('usuario.edit');
Route::put('/usuario/{id}', [UserController::class, 'update'])->name('usuario.update');

Route::get('/usuario/{id}', function ($id) {
    return view('formularios.index', ['usuario'=> User::Find($id), 'status'=> Statu::orderBy('formulario', 'asc')->get()]);
});



Route::get('usuario/{id}/descargar', function ($id) {
    $usuario = auth()->user();
    $status= Statu::orderBy('formulario', 'asc')->get();
    return view('formularios.indexxx', ['usuario' => User::Find($id), 'status' => $status]);
});

Route::get('/admin', [AdminController::class, 'index'])
->middleware('auth.admin') /*verifica si iniciamos sesion como admin*/
->name('admin.index');




// Habilitar la vista de inicio de sesión en el formulario de registro.
Route::get('usuario/create', function () {
    $status = Statu::all();
    return view('/admin.create',['status' => $status]);
});

// Habilitar la vista del historico.
Route::resource('/historico', HistoricoController::class);

/* RUTA PARA MOSTRAR EL LISTADO DE INSTITUVIONES (cRUD) */
Route::get('/altaInstituciones', function (Request $request) {
    $username = trim($request->get('username'));
    $usuarios=DB::table('users')
            ->select('id', 'username', 'role')
            ->where('username', 'LIKE', '%'.$username.'%' )
            ->orderBy('username', 'asc')
            ->get(); // Ejecutar la consulta y obtener los resultados;
    //Retornar vista de inicio
    // Obtener el usuario autenticado, si hay alguno
    $usuario = auth()->user();
    $status = Statu::all();
    return view('/admin.instituciones',['usuario' => $usuario, 'status' => $status] ,compact(['username', 'usuarios'])); // En ruta alumnos, busca la vista
});

// Route::get('/inicioUsuario', function () {
//     return view('/usuario.index');
// });



/* Vistas de registro e incio de sesion de usuarios */

Route::get('/registro', [RegisterController::class, 'show']);

Route::post('/registro', [RegisterController::class, 'register']);

Route::get('/inicioSesion', [LoginController::class, 'show']);

Route::post('/inicioSesion', [LoginController::class, 'login']);

Route::get('/index', [FormularioController::class, 'index']);

Route::get('/logout', [LogoutController::class, 'logout']);


// // // Habilitar la vista de inicio de sesión en el formulario de registro.
// Route::get('/formularios/inicioSesion', function () {
//     return view('/formularios.inicioSesion');
// });
Route::get('/generar-excel', [ExcelController::class, 'generarExcel']);
Route::post('/upload', 'UploadController@upload')->name('upload');



Route::resource('/users', UserController::class)->name('users.index', '/users');




Route::get('/formularios/{id}', 'FormularioController@index');


Route::get('/altaInstituciones/{id}/archivos', function ($id) {
    return view('/admin.archivos', ['usuario'=> User::Find($id), 'status' => Statu::orderBy('formulario', 'asc')->get()]);
});

Route::post('formularios/asignar/{id}', [FormularioController::class, 'asignarArchivos'])->name('asignar.archivos');
// Ruta para subir archivos 
Route::post('usuario/{id}/upload', [StatuController::class, 'uploadArchivos'])->name('upload');

Route::get('/descargar-todos', [FormularioController::class, 'downloadAll'])->name('downloadAll');

//mensajes
Route::post('/mensajes/enviar', [MensajeController::class, 'enviarMensaje'])->name('mensajes.enviar');
Route::get('/mensajes/conversacion/{user_id}', [MensajeController::class, 'verConversacion'])->name('mensajes.conversacion');

//rechazar o aceptar archivo 
Route::post('/status/aceptar-archivo', [StatuController::class, 'aceptarArchivo'])->name('status.aceptar-archivo');
Route::post('/status/rechazar-archivo', [StatuController::class, 'rechazarArchivo'])->name('status.rechazar-archivo');

// Fecha de inicio del censo
Route::post('/historico/store', [HistoricoController::class, 'store'])->name('historico.store');
// Finalizar censo
Route::post('/historico/finalizar', [HistoricoController::class, 'finalizar'])->name('historico.finalizar');


