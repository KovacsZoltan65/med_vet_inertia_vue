<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class CompanyController extends Controller
{
    public function __construct()
    {
        //$this->authorizeResource(\App\Models\User::class);
        $this->authorizeResource(\App\Models\Company::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //abort_if(Gate::denies('company_view'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        
        $data = Company::query()->paginate(config('app.page_lines'));
        
        return Inertia::render('companies/companyIndex', [
            'data' => $data,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request)
    {
        Company::create($request->all());

        return redirect()->back()->with('message', 'Company created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company){}

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, Company $company)
    {
        //Validator::make($request->all(), ['name' => 'required',])->validate();

        $company->update($request->all());

        return redirect()->back()->with('message', 'Company updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $company->delete();

        return redirect()->back()->with('message', 'Company deleted');
    }
    
    public function get_companies()
    {
        $companies = [];
        
        $tmp = Company::query()->orderBy('name', 'asc')->get();
        
        foreach($tmp as $company)
        {
            array_push($companies, (object)['value' => $company->id, 'label' => $company->name]);
        }
        
        return $companies;
    }
}
