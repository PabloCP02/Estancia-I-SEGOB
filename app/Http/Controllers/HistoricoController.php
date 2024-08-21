<?php

namespace App\Http\Controllers;

use App\Models\Historico;
use App\Models\Statu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use File;

class HistoricoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $historicos = Historico::orderBy('created_at', 'desc')->get();

        return view('admin.historico', ['historicos' => $historicos]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Historico::create([
            'inicio' => now(), // Asigna la fecha actual a la columna `inicio`
        ]);

        return redirect()->back()->with('success', 'Censo iniciado.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Historico $historico)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Historico $historico)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Historico $historico)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Historico $historico)
    {
        //
    }


    // Método para descargar en un archivo comprimido los formularios asignados
    public function finalizar(Request $request)
{
    $historicoId = $request->input('userId');
    $historico = Historico::find($historicoId);

    // Establece la fecha actual en la columna 'fin'
    $historico->fin = now();
    
    $zip = new ZipArchive;

    // Genera un nombre de archivo seguro
    // $fileName = 'historico_' . now()->format('Ymd_His') . '.zip';
    $fileName = 'historico_' . now()->format('Y-m-d') . '.zip';
    $filePath = public_path('completado/' . $fileName);


    if ($zip->open($filePath, ZipArchive::CREATE) === TRUE) {
        // Obtén los archivos a incluir en el zip
        $status = Statu::all();
        foreach ($status as $statu) {
            if($statu->revision != "" && $statu->completado == 1){
                $file = public_path($statu->revision);
                if (file_exists($file)) {
                    $relativeName = basename($file);
                    $zip->addFile($file, $relativeName);
                }
            }
        }

        $zip->close();

        // Guarda la ruta del archivo ZIP en el registro de la tabla `historicos`
        $historico->archivo = 'completado/' . $fileName;
        $historico->save();

        // Opcional: Elimina los archivos en `public/revision` después de comprimirlos
        // foreach ($status as $statu) {
        //     File::delete(public_path($statu->revision));
        // }

        // Limpia las tablas `formularios` y `status`
        \DB::table('formularios')->truncate();
        \DB::table('status')->truncate();

        return response()->download($filePath);
    }

    return redirect()->back()->with('error', 'No se pudo crear el archivo ZIP.');
}

}
