<?php

namespace App\Http\Controllers;

use App\Models\Formulario;
use App\Models\User;
use App\Models\Archivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use ZipArchive;
use File;


class FormularioController extends Controller
{
    // Método para descargar en un archivo comprimido los formularios asignados
    public function downloadAll()
    {
        $zip = new ZipArchive;
        $fileName = 'formulario-archivos.zip';
        $filePath = public_path($fileName);

        if ($zip->open($filePath, ZipArchive::CREATE) === TRUE) {
            // Obtén los archivos a incluir en el zip
            $formularios = \App\Models\Statu::where('dependencia_id', auth()->user()->id)->get();

            foreach ($formularios as $formulario) {
                $file = public_path($formulario->formulario);
                if (file_exists($file)) {
                    $relativeName = basename($file);
                    $zip->addFile($file, $relativeName);
                }
            }

            $zip->close();
        }

        return response()->download($filePath)->deleteFileAfterSend(true);
    }
    // Controla la asignación de archivos a un usuario
    public function asignarArchivos(Request $request, $id)
    {
        $usuario = User::findOrFail($id);
        $archivosSeleccionados = $request->input('archivos', []);

        // Elimina las asignaciones anteriores
        //DB::table('archivos_asignados_v2')->where('user_id', $usuario->id)->delete();

        // Inserta las nuevas asignaciones
        foreach ($archivosSeleccionados as $archivo) {
            DB::table('status')->insert([
                'dependencia_id' => $usuario->id,
                'formulario' => $archivo,
            ]);
        }

        // Redirigir a la vista de la los detalles de la dependencia
        return redirect("/altaInstituciones/$usuario->id/archivos");
    }


    public function index(Request $request)
    {
        $formulario = trim($request->get('formulario'));
        $formularios=DB::table('formularios')
                    ->select('id', 'formulario')
                    ->where('formulario', 'LIKE', '%'.$formulario.'%' )
                    ->orderBy('formulario', 'asc')
                    ->get(); // Ejecutar la consulta y obtener los resultados;
        //Retornar vista de inicio
        // Obtener el usuario autenticado, si hay alguno
        $usuario = auth()->user();
        return view('formularios.subir',['usuario' => $usuario] ,compact(['formulario', 'formularios'])); // En ruta alumnos, busca la vista
    } 


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $usuarios = User::all();
        // Obtener el usuario autenticado, si hay alguno
        $usuario = auth()->user();
        return view('formularios.create', ['usuarios' => $usuarios, 'usuario' => $usuario]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $formularios = Formulario::all();
        $usuarios = User::all();
        // Obtener el usuario autenticado, si hay alguno
        $usuario = auth()->user();
        // Crear objeto para guardar los datos en la BD
        $formulario = new Formulario();

        // Condicion para verificar si se esta cargando la img del formulario
        if($request->hasFile('formulario')){
            // Obtener el archivo
            $file = $request->file('formulario');
            // Guardar la carpeta de destino en una variable para después concatenar con la img
            $destino = 'uploads/';
            // Asignar nombre a la imagen
            $fileName = $file->getClientOriginalName();
            // Mover la imagen a la carpeta de destino
            $uploadSuccess = $request->file('formulario')->move($destino, $fileName);
            $formulario->formulario = $destino.$fileName;
        }

        // Si todos los datos son correctos entonces se guarda en la tabla de la BD
        // (nombre del campo de la tabla) -> (name del input)
        $formulario->save(); // Guardar registro en la BD
        // cuando guarde, presentar un mensaje en la vista mensaje
        return redirect()->route('formularios.index')->with(['usuarios' => $usuarios, 'usuario' => $usuario, 'formularios' => $formularios]);

    }

    /**
     * Display the specified resource.
     */
    public function show(Formulario $formulario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Recuperar los datos del id que se va a modificar y enviarlo a la vista edit
        $formulario = Formulario::find($id); // Buscar el id del formulario
        // Ahora enviamos a la vista de edit de los datos
        return view('formularios.edit', ['formulario' => $formulario]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Recuperar el formulario existente
        $formulario = Formulario::find($id);
        if (!$formulario) {
            // Manejar el caso en el que no se encuentra el formulario
            return redirect()->back()->with('error', 'Formulario no encontrado');
        }
    
        // Condición para verificar si se está cargando un nuevo archivo
        if($request->hasFile('formulario')){
            // Eliminar el archivo antiguo si existe
            if ($formulario->formulario && file_exists(public_path($formulario->formulario))) {
                unlink(public_path($formulario->formulario));
            }
    
            // Obtener el nuevo archivo
            $file = $request->file('formulario');
            // Guardar la carpeta de destino en una variable
            $destino = 'uploads/';
            // Asignar nombre al archivo
            $fileName = $file->getClientOriginalName();
            // Mover el archivo a la carpeta de destino
            $uploadSuccess = $request->file('formulario')->move($destino, $fileName);
            // Actualizar el campo en el formulario
            $formulario->formulario = $destino.$fileName;
        }
    
        // Guardar los cambios en la base de datos
        $formulario->save();
    
        // Obtener todos los formularios y usuarios para pasar a la vista
        $formularios = Formulario::all();
        $usuarios = User::all();
        $usuario = auth()->user();
    
        // Redirigir a la vista de formularios con un mensaje de éxito
        return view('formularios.subir', ['usuarios' => $usuarios, 'usuario' => $usuario, 'formularios' => $formularios])
               ->with('success', 'Formulario actualizado correctamente');
    }
    


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    // Buscar el formulario por su ID
    $formulario = Formulario::find($id);

    if (!$formulario) {
        // Manejar el caso en el que el formulario no se encuentre
        return redirect()->back()->with('error', 'Formulario no encontrado');
    }

    // Obtener la ruta del archivo físico y eliminarlo si existe
    $archivo = public_path($formulario->formulario);
    if (file_exists($archivo)) {
        unlink($archivo);
    }

    // Eliminar el registro de la base de datos
    $formulario->delete();

    // Redirigir con un mensaje de éxito o cargar la vista según tus necesidades
    $formularios = Formulario::all();
    $usuario = auth()->user();
    return view('formularios.subir', ['formularios' => $formularios, 'usuario' => $usuario])->with('success', 'Formulario eliminado correctamente');
}

}
