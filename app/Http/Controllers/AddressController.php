<?php

namespace App\Http\Controllers;

use App\Models\Addresses;
use App\Http\Requests\StoreAddressesRequest;
use App\Http\Requests\UpdateAddressesRequest;
use Inertia\Inertia;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Addresses::query()
            ->paginate(config('app.page_lines'));
        
        //echo '<pre>';
        foreach($data as $address){
            
            //print_r($address->company_id . PHP_EOL);
            //print_r($address->human_id);
            
            if($address->company_id != 0){
                //dd($address->company);
                $address->company_name = $address->company->name;
                $address->human_name = '';
            }else{
                $address->company_name = '';
                $address->human_name = $address->human->name;
            }
        }
        //echo '</pre>';
        
        //dd($data);
        
        $companies = \App\Models\Company::toSelect();
        
        $humans = \App\Models\Human::toSelect();
        
        $addressTypes = \App\Enums\AddressType::toArray();

        //dd($companies, $humans, $addressTypes);
        
        return Inertia::render('addresses/addressIndex', [
            'data' => $data,
            'companies' => $companies,
            'humans' => $humans,
            'addressTypes' => $addressTypes,
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
    public function store(StoreAddressesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Addresses $addresses)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Addresses $addresses)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAddressesRequest $request, Addresses $addresses)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Addresses $addresses)
    {
        //
    }
}
