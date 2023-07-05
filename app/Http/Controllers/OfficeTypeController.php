<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\OfficeType;
use App\Http\Requests\StoreOfficeTypeRequest;
use App\Http\Requests\UpdateOfficeTypeRequest;
use Inertia\Inertia;

class OfficeTypeController extends Controller
{
    public function __construct() {
        //$this->authorizeResource(OfficeType::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //$types = OfficeType::query()->paginate(config('app.page_lines'));
        
        $params = [
            'tags' => [],
        ];
        
        return Inertia::render('office_types/typeIndex', $params);
    }
    
    public function gridData(Request $request){
        $filters = $request->get('filter', []);
        $config = $request->get('config', []);
        
        $query = OfficeType::query();
        /*
        if( count($filters) > 0 ){
        
            if( $search = ($filters['search'] ?? null) ){
                $terms_cleaned = preg_replace("/[^a-zA-Z0-9\(\)\-\+\_@\.]+/", " ", $search);
                $terms = array_reduce(
                    explode(' ', $terms_cleaned), 
                    function($carry, $term){
                        $term = trim($term);
                        if( !empty($term) ){
                            $carry[] = strtolower($term);
                        }
                        return $carry;
                    }, 
                    []
                );
                if( count($terms) > 0 ){
                    $query->where(function($q) use($terms) {
                        $whereType = 'where';
                        foreach( $terms as $term ){
                            $q->{$whereType}('name', 'LIKE', '%' . $term . '%');
                        }
                    });
                }
            }

            if( $tags = ($filters['tags'] ?? null) ){
                $whereType = $search ? 'whereOr' : 'where';

                $query->{$whereType}(function($query) use($tags) {
                    $query->whereHas('tags', function($q) use($tags) {
                        $q->whereIn('tags.id', $tags);
                    });
                });
            }
        }
        */
        //$officeTypes = $query->paginate($config['per_page'])->get();
        $officeTypes = $query->paginate($config['per_page']);
        return response()
            ->json([
                'office_types' => $officeTypes,
            ], Response::HTTP_OK);
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
    public function store(StoreOfficeTypeRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(OfficeType $officeType)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OfficeType $officeType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOfficeTypeRequest $request, OfficeType $officeType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OfficeType $officeType)
    {
        //
    }
}
