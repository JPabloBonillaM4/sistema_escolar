<?php

namespace App\Http\Controllers;

use App\Models\Period;
use Illuminate\Http\Request;

class PeriodsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.admin.periods_index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * getAll
     */
    public function getAll() {
        $request = request();
        $data    = Period::query();
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
