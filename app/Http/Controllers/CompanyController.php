<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use App\Models\Company;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
//use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller {

    public function __construct() {
        //$this->authorizeResource(\App\Models\User::class);
        //$this->authorizeResource(\App\Models\Company::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index() {
        //abort_if(Gate::denies('company_view'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $data = Company::query()->paginate(config('app.page_lines'));

        return Inertia::render('companies/companyIndex', [
            'companies' => $data,
            'tags' => []
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompanyRequest $request) {
        $data = $request->all();
        
        try{
            DB::beginTransaction();
            
            $company = Company::create($data);
            
            DB::commit();
        }catch(Throwable $e){
            Log::error($e);
            
            DB::rollBack();
        }
        
        return response()
            ->json([
                'company' => $company
            ], Response::HTTP_CREATED);
        
        //Company::create($request->all());

        //return redirect()->back()->with('message', 'Company created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company) {
        //Validator::make($request->all(), ['name' => 'required',])->validate();
        
        //$company->update($request->all());

        //return redirect()->back()->with('message', 'Company updated');
        
        $company->name = $request->get('name', $company->name);
        
        $company->save();
        
        return response()
            ->json([
                'company' => $company,
            ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company) {
        $company->delete();

        return redirect()->back()->with('message', 'Company deleted');
    }

    public function delete_company(Request $request)
    {
        $company = Company::find($request->get('company'));
        
        $company->delete();
        return response()->json([
            'company' => $company,
        ], Response::HTTP_OK);
        
    }
    
    public function gridData(Request $request)
    {
        $filters = $request->get('filters', []);
        $config = $request->get('config', []);

        $query = Company::query();

        //dd($filters, $config, $query);
        
        if (count($filters) > 0) {
            if ($search = ($filters['search'] ?? null)) {
                // allow alphanumeric and characters used in emails
                $terms_cleaned = preg_replace("/[^a-zA-Z0-9\(\)\-\+\_@\.]+/", " ", $search);

                $terms = array_reduce(
                    explode(" ", $terms_cleaned),
                    function ($carry, $term) {
                        $term = trim($term);

                        if (!empty($term)) {
                            $carry[] = strtolower($term);
                        }

                        return $carry;
                    },
                    []
                );

                if (count($terms) > 0) {
                    $query->where(function ($q) use ($terms) {

                        $whereType = 'where';
                        foreach ($terms as $term) {

                            $q->{$whereType}('name', 'LIKE', '%' . $term . '%');

                            //$whereType = 'orWhere';

                            //$q->{$whereType}('name_last', 'LIKE', '%' . $term . '%');
                            //$q->{$whereType}('email', 'LIKE', '%' . $term . '%');
                            //$q->{$whereType}('description', 'LIKE', '%' . $term . '%');
                        }
                    });
                }
            }
            
            if ($tags = ($filters['tags'] ?? null)) {
                $whereType = $search ? 'orWhere' : 'where';

                $query->{$whereType}(function ($query) use ($tags) {
                    $query->whereHas('tags', function ($q) use ($tags) {
                        $q->whereIn('tags.id', $tags);
                    });
                });
            }
        }
        
        $companies = $query->paginate( $config['per_page'] ?? 10 );
        
        return response()
            ->json(['companies' => $companies], Response::HTTP_OK);
    }

}
