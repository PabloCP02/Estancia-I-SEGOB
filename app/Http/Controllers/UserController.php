<?php

namespace App\Http\Controllers;
use App\Http\ArchivoController;
use App\Models\Archivo;
use App\Models\User;
use App\Models\Statu;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // Obtener todos los usuarios de la BD
        $usuarios = User::all();
        
        // Obtener el usuario autenticado, si hay alguno
        $usuario = auth()->user();

        $status = Statu::all();
        
        // Retornar la vista con la lista de usuarios y el usuario autenticado (si está definido)
        return view('usuario.index', ['usuarios' => $usuarios, 'usuario' => $usuario, 'status' => $status]);
    
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('usuario.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'username' => 'required|max:255',
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|min:8'
        ]);

        // Crear un nuevo objeto usuario para almacenar los datos en la BD
        $usuario = new User();

        // Almacenar los datos del formulario en el objeto usuario
        $usuario->username = $request->input('username');
        $usuario->name = $request->input('name');
        $usuario->email = $request->input('email');
        $usuario->password = $request->input('password');
        $usuario->save();

        // Obtener todas las instituciones de la BD (incluida la recién creada)
        $usuarios = User::all();
        $status = Statu::all();

        // Redirigir a la vista principal con la lista actualizada de instituciones
        return view('admin.instituciones', ['usuarios' => $usuarios, 'status' => $status]);
    }



    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        // Obtener todos los usuarios de la BD
        $usuarios = User::all();

        // Obtener la institucion con el id especificado
        $usuario = User::find($id);

        // Crear variable el id que se selecciono
        $institucion = $usuario;

        // Redirigir a la vista donde se mostraran los datos de la institucion y su progreso
        return view('admin.showInstituciones', ['usuarios' => $usuarios]);
        // $terminos = Termino::all();
        // $termino = Termino::find($id);
        // // Crear variable el id que se selecciono
        // $concepto = Termino::find($id);
        // //Retornar vista del concepto
        // return view('glosario.show', ['terminos' => $terminos, 'termino' => $termino], compact('concepto')); // El compact() sirve para enviar la variable a la vista
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Recuperar los datos del id que se va a modificar y enviarlo a la vista edit
        $usuario = User::find($id); // Buscar el id del usuario en la BD
        // Ahora enviamos a la vista de edit de los datos
        return view('usuario.editar', ['usuario' => $usuario]);
    }

    public function update(Request $request, $id)
    {
         // Validar los datos del formulario
         $request->validate([
            'username' => 'required|max:255',
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'password' => 'required|min:8',
        ]);

        // Crear un nuevo objeto usuario para almacenar los datos en la BD
        $usuario = User::find($id);

        // Almacenar los datos del formulario en el objeto usuario
        $usuario->username = $request->input('username');
        $usuario->name = $request->input('name');
        $usuario->email = $request->input('email');
        $usuario->password = $request->input('password');
        $usuario->save();

        // Redirigir a la vista principal con la lista actualizada de instituciones
        return view('usuario.editar', ['usuario' => $usuario])
        ->with('mensaje', 'Datos actualizados exitosamente');

    }

    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
