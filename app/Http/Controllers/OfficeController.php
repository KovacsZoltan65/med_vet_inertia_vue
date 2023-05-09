<?php

namespace App\Http\Controllers;

use App\Enums\OfficeType;
use App\Http\Requests\StoreOfficeRequest;
use App\Http\Requests\UpdateOfficeRequest;
use App\Models\Office;
use Inertia\Inertia;

class OfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Office::query()->paginate(10);
        
        //$types = OfficeType::all();

        foreach($data as $office){
            $office->type_name = OfficeType::from($office->type_id)->getLabelText();
            $office->type_color = OfficeType::from($office->type_id)->getLabelColor();
            $office->type_label = OfficeType::from($office->type_id)->getLabelHTML();
        }
        
        $types = OfficeType::toArray();
        
        //foreach($data as $office){
        //    $office->type_name = $office->type->name;
        //}
        
        return Inertia::render('offices/officeIndex', [
            'filters' => 'filters',
            'data' => $data, 
            'types' => $types
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOfficeRequest $request)
    {
        Office::create($request->all());

        return redirect()->back()
            ->with('message', 'Office created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Office $office){}

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOfficeRequest $request, Office $office)
    {
        $office->update($request->all());

        return redirect()->back()
            ->with('message', 'Office updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Office $office)
    {
        $office->delete();

        return redirect()->back()->with('message', 'Office deleted');
    }
}
