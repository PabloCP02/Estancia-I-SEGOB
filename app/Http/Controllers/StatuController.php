<?php

namespace App\Http\Controllers;

use App\Models\Statu;
use App\Models\Formulario;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use ZipArchive;
use File;

class StatuController extends Controller
{
    // Subir los archivos del usuario y almacenarlos en la columna revisión de la tabla status
    public function uploadArchivos(Request $request)
    {
       
        // Recuperar el estatu existente
        $statu = Statu::find($request->input('statuId'));
        // Condición para verificar si se está cargando un nuevo archivo
        if($request->hasFile('archivo')){
            // Eliminar el archivo antiguo si existe
            if($statu->revision != ""){
                if ($statu->revision && file_exists(public_path($statu->revision))) {
                    unlink(public_path($statu->revision));
                }
            }
           
            $userId = $request->input('userId');
            // Obtener el nuevo archivo
            $file = $request->file('archivo');
            // Guardar la carpeta de destino en una variable
            $destino = 'revision/'.$userId.'/';
            // Asignar nombre al archivo
            $fileName = $file->getClientOriginalName();
            // Mover el archivo a la carpeta de destino
            $uploadSuccess = $request->file('archivo')->move($destino, $fileName);
            // Actualizar el campo en el formulario
            $statu->revision = $destino.$fileName;
        }
        // Almacenar el estatus en revisión
        $statu->completado = 3;
        // Guardar los cambios en la base de datos
        $statu->save();
    
        // Redirigir de vuelta con un mensaje de éxito
        return redirect()->back()->with('success', 'Archivo subido correctamente y está en revisión.');
    }


    public function aceptarArchivo(Request $request)
    {
        // Validar los datos recibidos
        $request->validate([
            'userId' => 'required|integer',
        ]);

        $userId = $request->input('userId');
        $statuId = $request->input('statuId');
        

        // Actualizar el estado del archivo en la base de datos para marcarlo como aceptado
        DB::table('status')
            ->where('id', $statuId)
            ->update(['completado' => 1]);

        return redirect()->back()->with('success', 'Archivo aceptado correctamente.');
    }

       


    public function rechazarArchivo(Request $request)
{
    // Validar los datos recibidos
    $request->validate([
        'userId' => 'required|integer',
    ]);

    $userId = $request->input('userId');
    $statuId = $request->input('statuId');
    

    // Actualizar el estado del archivo en la base de datos para marcarlo como aceptado
    DB::table('status')
        ->where('id', $statuId)
        ->update(['completado' => 2]);

    return redirect()->back()->with('success', 'Archivo rechazado correctamente.');
}


     
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $formularios = Formulario::all();
        return view('admin.asignacion', ['formularios' => $formularios, 'usuario'=> User::Find($id)]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Statu $statu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Statu $statu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Statu $statu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id, Request $request)
    {
        // Eliminar el registro del formulario asignado
        $statu = Statu::find($id);
        $statu->delete();

        // Recuperamos el ID del usuario desde el request
        $userId = $request->input('idUser');

        // Redirigir a la vista de la los detalles de la dependencia
        return redirect("/altaInstituciones/$userId/archivos");
    }


}
