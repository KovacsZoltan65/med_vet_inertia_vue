<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Role;
use Illuminate\Http\Response;

class RoleController extends Controller
{
    public function __construct() {
        $this->authorizeResource(Role::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request->get('filters', ['' => '', '' => '']);
        $config = $request->get('config', []);
        
        $config['per_page'] = config('app.page_lines');
        $config['lang'] = app()->getLocale();
        
        return Inertia::render('roles/rolesIndex', [
            'roles' => [],
            'filters' => $filters,
            'config' => $config,
        ]);
        /*
        $roles = Role::query()->paginate(config('app.page_lines'));
        
        return Inertia::render('roles/rolesIndex', [
            'roles' => $roles,
            'tags' => [
                'tags' => [
                    ['id' => 1,'name' => 'tag 1'],
                    ['id' => 2,'name' => 'tag 2'],
                ]
            ],
        ]);
        */
    }

    public function getRoles(Request $request)
    {
        $filters = $request->get('filters', []);
        $config = $request->get('config', []);
        
        $config['page_lines'] = config('app.page_lines');
        $config['lang'] = app()->getLocale();
        
        $query = Role::query();
        
        if( count($filters) > 0 ){
            if( $search = ($filters['search'] ?? null) ){
                // az e-mailekben használt alfanumerikus és karakterek engedélyezése
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
                    $query->where(function($q) use($terms){
                        $whereType = 'where';
                        foreach($terms as $term){
                            $q->{$whereType}('title', 'LIKE', '%' . $term . '%');
                        }
                    });
                }
            }
            
            if( $tags = ($filters['tags'] ?? null) ){
                $whereType = $search ? 'orWhere' : 'where';
                
                $query->{$whereType}(function($query) use($tags){
                    $query->whereHas('tags', function($q) use($tags){
                        $query->whereIn('tags.id', $tags);
                    });
                });
            }
        }
        
        $roles = $query->paginate( $config['page_lines']);
        
        return response()->json([
            'roles' => $roles,
            'filters' => $filters,
            'config' => $config,
        ], Response::HTTP_OK);
        
        //$roles = Role::query()->paginate(config('app.page_lines'));
        //$roles = \App\Models\Permission::query()->paginate(10);
        
        //dd('getRoles', $filters['search']);
        
        //if( count($filters) > 0 )
        //{
            //$roles = Role::query()->where('title', '=', $filters['search'])->paginate(config('app.page_lines'));
        //    $roles = Role::where('title', $filters['search'])->get();
        //}
        //else
        //{
            //$roles = Role::query()->paginate(config('app.page_lines'));
        //    $roles = Role::all();
        //}
        
        //echo '<pre>';
        
        //foreach($roles as $role)
        //{
        //    print_r($role->title . PHP_EOL);
        //}
        //echo '</pre>';
        
        //return [
        //    'data' => $roles,
        //    'tags' => [
        //        'tags' => [
        //            ['id' => 1,'name' => 'tag 1'],
        //            ['id' => 2,'name' => 'tag 2'],
        //        ]
        //    ],
        //];
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
    public function store(StoreRoleRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        //
    }
}
