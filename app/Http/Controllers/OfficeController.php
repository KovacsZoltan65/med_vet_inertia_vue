<?php

namespace App\Http\Controllers;

use App\Enums\OfficeType;
use App\Http\Requests\StoreOfficeRequest;
use App\Http\Requests\UpdateOfficeRequest;
use App\Models\Office;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Inertia\Inertia;

class OfficeController extends Controller
{
    public function __construct()
    {
        //$this->authorizeResource(\App\Models\User::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //abort_if(Gate::denies('office_view'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $offices = Office::query()->paginate(config('app.page_lines'));

        foreach($offices as $office){
            $office->type_name = OfficeType::from($office->type_id)->getLabelText();
            $office->type_color = OfficeType::from($office->type_id)->getLabelColor();
            $office->type_label = OfficeType::from($office->type_id)->getLabelHTML();
        }
        
        $officeTypes = OfficeType::toArray();
        
        //dd($offices, $officeTypes);
        
        //echo '<pre>';
        foreach($offices as $office)
        {
            //print_r($office->type()['name']);
            $office->type_name = $office->type()['label'];
        }
        //echo '</pre>';
        
        //dd($office, $types);
        $params = [
            'filters' => 'filters',
            'data' => $offices, 
            'types' => $officeTypes
        ];
        
        return Inertia::render('offices/officeIndex', $params);
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
    
    public function get_offices()
    {
        $offices = Office::query()->paginate(config('app.page_lines'));
        
        foreach($offices as $office){
            $office->type_name = OfficeType::from($office->type_id)->getLabelText();
            $office->type_color = OfficeType::from($office->type_id)->getLabelColor();
            $office->type_label = OfficeType::from($office->type_id)->getLabelHTML();
        }
        
        return $offices;
    }
}
