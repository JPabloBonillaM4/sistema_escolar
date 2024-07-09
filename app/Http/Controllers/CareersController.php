<?php

namespace App\Http\Controllers;

use App\Models\Career;
use Illuminate\Http\Request;

class CareersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.admin.careers_index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $error   = false;
        $message = null;

        $code = $this->generateUniqueCodeCareers($request->name);
        $created = Career::create([
            'name' => $request->name,
            'service_id' => $request->service_id,
            'code' => $code
        ]);

        if($created) {
            $message = 'Carrera generada exitosamente';
        } else {
            $error   = true;
            $message = 'Error al generar la carrera, intente nuevamente';
        }

        return ['error' => $error, 'message' => $message];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $error   = false;
        $message = null;

        $record  = Career::find($id);
        if($record){
            $updated = $record->update(['name' => $request->name, 'service_id' => $request->service_id]);
            if($updated) {
                $message = 'Carrera editada exitosamente';
            } else {
                $error   = true;
                $message = 'Error al editar la carrera, intente nuevamente';
            }
        } else {
            $message = 'Carrera no encontrada';
        }

        return ['error' => $error, 'message' => $message];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $error   = false;
        $message = null;

        $record  = Career::find($id);
        if($record){
            $deleted = $record->delete();
            if($deleted) {
                $message = 'Carrera eliminada exitosamente';
            } else {
                $error   = true;
                $message = 'Error al eliminar la carrera, intente nuevamente';
            }
        } else {
            $message = 'Carrera no encontrada';
        }

        return ['error' => $error, 'message' => $message];
    }

    /**
     * Get all data
     */
    public function getAll(){
        $request = request();
        $data    = Career::with('service');
        // FILTERS
        if(!is_null($request->filters)){
            $filters = is_string($request->filters) ? json_decode($request->filters) : (object)$request->filters;
            if(isset($filters->text) && !is_null($filters->text) && $filters->text != ''){ // By text
                $text = trim($filters->text);
                $data->where('name','LIKE',"%$text%");
            }
            if(isset($filters->services_ids) && is_array($filters->services_ids) && count($filters->services_ids) > 0){
                $services_ids = $filters->services_ids;
                $data->whereIn('service_id',$services_ids);
            }
        }
        return $request->paginated ? $data->paginate(5) : $data->get();
    }

    /**
     * Generate unique code - Careers
     */
    public function generateUniqueCodeCareers($string, $primera_posicion = 0){
        $string           = strtoupper(str_replace(' ','',trim($string)));
        $ultima_posicion  = $primera_posicion + 1;
        $prefijo_generado = false;
        // Obtener los primeros dos caracteres de la palabra
        $primer_caracter  = substr($string, $primera_posicion, 1);
        $segundo_caracter = substr($string, $ultima_posicion, 1);
        $prefijo          = $primer_caracter.$segundo_caracter;
        // Obtener los codigos existentes ya registrados
        $actual_codes = Career::get()->pluck('code');
        $size_maximo  = strlen($string) - 1;
        if(count($actual_codes) > 0){
            // Verificar si el prefijo ya existe y si es así, ajustarlo
            if($actual_codes->contains($prefijo)){ // Si el prefijo ya existe, cambiar el 2do caracter y verificar nuevamente
                if($ultima_posicion <= $size_maximo){
                    $ultima_posicion++;
                    $segundo_caracter = substr($string, $ultima_posicion , 1);
                    $prefijo          = $primer_caracter.$segundo_caracter;
                } else {
                    if($ultima_posicion > $size_maximo){

                    } else {
                        $prefijo_generado = true;
                    }
                }
            } else {
                $prefijo_generado = true;
            }
        } else {
            $prefijo_generado = true;
        }
        if(!$prefijo_generado){ // Si el prefijo continua sin ser único, se ejecuta nuevamente la funcion pero obteniendo caracteres mas adelante del primero
            $primera_posicion++;
            if($primera_posicion <= $size_maximo){
                return $this->generateUniqueCodeCareers($string,$primera_posicion);
            } else {
                return $prefijo;
            }
        } else {
            return $prefijo;
        }
    }
}
