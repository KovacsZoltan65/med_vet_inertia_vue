<?php

namespace App\Http\Controllers;

use App\Enums\AddressType;
use App\Http\Requests\StoreAddressesRequest;
use App\Http\Requests\UpdateAddressesRequest;
use App\Models\Addresses;
use App\Models\Company;
use App\Models\Human;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AddressController extends Controller
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
        
        $data = Addresses::query()
            ->paginate(config('app.page_lines'));
        
        foreach($data as $address){
            
            if($address->company_id != 0){
                //dd($address->company);
                $address->company_name = $address->company->name;
                $address->human_name = '';
            }else{
                $address->company_name = '';
                $address->human_name = $address->human->name;
            }
            
            $address->type_name = AddressType::from($address->type_id)->getLabelText();
            $address->type_color = AddressType::from($address->type_id)->getLabelColor();
            $address->type_label = AddressType::from($address->type_id)->getLabelHTML();
        }
        
        //dd($data);
        
        $companies = Company::toSelect();
        
        $humans = Human::toSelect();
        
        $addressTypes = AddressType::toArray();

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
