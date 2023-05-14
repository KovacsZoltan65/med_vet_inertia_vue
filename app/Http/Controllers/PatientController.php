<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Models\Animal;
use App\Models\Human;
use App\Models\Office;
use App\Models\Patient;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if( $request->has('param') ){
            $query = $request->query('param');
            //dd($query);
        }
        
        $data = Patient::query()->paginate(config('app.page_lines'));
        
        $doctors = Human::doctors();
        //dd($doctors);
        //$doctors = \DB::table('view_doctors')->select(['id', 'name'])->get();
        //dd($d);
        
        $animals = Animal::all();
        $offices = Office::all();
        
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
    
    public function getPatients(Request $request)
    {
        if( $request->has('param') ){
            $query = $request->query('param');
            //dd($query);
        }
        
        $patients = Patient::query()->paginate(config('app.page_lines'));
        
        foreach( $patients as $patient ){
            $patient->doctor_name = $patient->doctor->name;
        }
        
        //dd($patients);
        return $patients;
    }
}
