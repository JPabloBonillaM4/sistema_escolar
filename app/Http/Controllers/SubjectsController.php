<?php

namespace App\Http\Controllers;

use App\Models\Career;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.admin.subjects_index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $error   = false;
        $message = null;
        $name    = trim($request->name);
        if(Subject::where(['name' => $name,'career_id' => $request->career_id])->first()) {
            $error   = true;
            $message = 'La materia ya se encuentra registrada, intente con una diferente';
        } else {
            $career = Career::find($request->career_id);
            $code = $this->generateUniqueCodeCareers($name, $career->code);
            $created = Subject::create([
                'name' => $name,
                'description' => trim($request->description),
                'type' => $request->type,
                'career_id' => $request->career_id,
                'code' => $code
            ]);

            if($created) {
                $message = 'Materia generada correctamente';
            } else {
                $error   = true;
                $message = 'Error al crear la materia, intente nuevamente';
            }
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
        $record  = Subject::find($id);
        if($record){
            $name = trim($request->name);
            if($record->name != $name || $record->career_id != $request->career_id){ // If the name or career is different from the current one, check if already exists
                if(Subject::where(['name' => $name,'career_id' => $request->career_id])->first()){
                    $error   = true;
                    $message = 'La materia ya se encuentra registrada, intente con una diferente';
                    return ['error' => $error, 'message' => $message];
                }
            }
            $updated = $record->update([
                'name' => $name,
                'description' => trim($request->description),
                'type' => $request->type,
                'career_id' => $request->career_id
            ]);
            if($updated) {
                $message = 'Materia editada exitosamente';
            } else {
                $error   = true;
                $message = 'Error al editar la materia, intente nuevamente';
            }
        } else {
            $message = 'Materia no encontrada';
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

        $record  = Subject::find($id);
        if($record){
            $deleted = $record->delete();
            if($deleted) {
                $message = 'Materia eliminada exitosamente';
            } else {
                $error   = true;
                $message = 'Error al eliminar la materia, intente nuevamente';
            }
        } else {
            $message = 'Materia no encontrada';
        }

        return ['error' => $error, 'message' => $message];
    }

    /**
     * Get all data
     */
    public function getAll(){
        $request = request();
        $data    = Subject::with('career');
        // FILTERS
        if(!is_null($request->filters)){
            $filters = is_string($request->filters) ? json_decode($request->filters) : (object)$request->filters;
            if(isset($filters->text) && !is_null($filters->text) && $filters->text != ''){ // By text
                $text = trim($filters->text);
                $data->where('name','LIKE',"%$text%");
            }
            if(isset($filters->careers_ids) && is_array($filters->careers_ids) && count($filters->careers_ids) > 0){
                $careers_ids = $filters->careers_ids;
                $data->whereIn('career_id',$careers_ids);
            }
        }
        return $request->paginated ? $data->paginate(5) : $data->get();
    }

    /**
     * Generate unique code - Subjects
     */
    public function generateUniqueCodeCareers($string, $code_career, $primera_posicion = 0){
        $string           = strtoupper(str_replace(' ','',trim($string)));
        $ultima_posicion  = $primera_posicion + 1;
        $prefijo_generado = false;
        // Obtener los primeros dos caracteres de la palabra
        $primer_caracter  = substr($string, $primera_posicion, 1);
        $segundo_caracter = substr($string, $ultima_posicion, 1);
        $prefijo          = $code_career.'-'.$primer_caracter.$segundo_caracter;
        // Obtener los codigos existentes ya registrados
        $actual_codes = Subject::get()->pluck('code');
        $size_maximo  = strlen($string) - 1;
        if(count($actual_codes) > 0){
            // Verificar si el prefijo ya existe y si es así, ajustarlo
            if(!$actual_codes->contains($prefijo)){ // Si el prefijo ya existe, cambiar el 2do caracter y verificar nuevamente
                $prefijo_generado = true;
            }
        } else {
            $prefijo_generado = true;
        }
        if(!$prefijo_generado){ // Si el prefijo continua sin ser único, se ejecuta nuevamente la funcion pero obteniendo caracteres mas adelante del primero
            $primera_posicion++;
            if($primera_posicion <= $size_maximo){
                return $this->generateUniqueCodeCareers($string, $code_career, $primera_posicion);
            } else {
                return $prefijo;
            }
        } else {
            return $prefijo;
        }
    }
}
