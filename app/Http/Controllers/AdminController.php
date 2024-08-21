<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Admin;
use App\Models\Statu;
use Illuminate\Http\Request;

class AdminController extends Controller
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
        return view('admin.index', ['usuarios' => $usuarios, 'usuario' => $usuario, 'status' => $status]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
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
            'password' => 'required|min:8',
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
        }
    
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        //
    }
}



    