<?php

namespace App\Http\Controllers;

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

        $created = Subject::create(['name' => $request->name]);

        if($created) {
            $message = 'Materia generada exitosamente';
        } else {
            $error   = true;
            $message = 'Error al crear la materia, intente nuevamente';
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
            $updated = $record->update(['name' => $request->name]);
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
        $data    = Subject::query();
        // FILTERS
        if(!is_null($request->filters)){
            $filters = is_string($request->filters) ? json_decode($request->filters) : (object)$request->filters;
            if(isset($filters->text) && !is_null($filters->text) && $filters->text != ''){ // By text
                $text = trim($filters->text);
                $data->where('name','LIKE',"%$text%");
            }
        }
        return $request->paginated ? $data->paginate(5) : $data->get();
    }
}
