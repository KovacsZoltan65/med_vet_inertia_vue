<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSpeciesRequest;
use App\Http\Requests\UpdateSpeciesRequest;
use App\Models\Species;
use Inertia\Inertia;

class SpeciesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Species::query()->paginate(10);
        //dd($data);
        return Inertia::render('species/index', [
            'data' => $data,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSpeciesRequest $request)
    {
        Species::create($request->all());
        
        return redirect()->back()
            ->with('message', 'Species created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Species $species){}

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSpeciesRequest $request, Species $species)
    {
        $species->update($request->all());
        
        return redirect()->back()->with('message', 'Species updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Species $species)
    {
        $species->delete();
        
        return redirect()->back()->with('message', 'Species deleted');
    }
}
