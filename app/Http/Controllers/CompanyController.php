<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Company::query()->paginate(20);
        //dd($data);
        return Inertia::render('companies/index', [
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
}
