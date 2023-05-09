<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use Inertia\Inertia;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Patient::query()->paginate(config('app.page_lines'));
        $doctors = \App\Models\Human::doctors();
        $animals = \App\Models\Animal::all();
        $offices = \App\Models\Office::all();
        
        //dd($doctors);
        
        foreach( $data as $patient ){
            $patient->doctor_name = $patient->doctor->name;
        }
        
        return Inertia::render('patients/patientIndex', [
            'data' => $data,
            'doctors' => $doctors,
            'offices' => $offices,
            'animals' => $animals,
        ]);
        
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
    public function store(StorePatientRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePatientRequest $request, Patient $patient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        //
    }
}
