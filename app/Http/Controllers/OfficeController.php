<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOfficeRequest;
use App\Http\Requests\UpdateOfficeRequest;
use App\Models\Office;
use App\Models\OfficeType as OfficeType2;
use Illuminate\Http\Response;
use Inertia\Inertia;

class OfficeController extends Controller {

    public function __construct() {
        //$this->authorizeResource(\App\Models\User::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index() {
        //abort_if(Gate::denies('office_view'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $types = OfficeType2::query()->get();
        $params = [
            'types' => $types,
        ];

        //$offices = Office::query()
        //    ->with('type')
        //    ->paginate(config('app.page_lines'));
        //$params = [
        //    'filters' => 'filters',
        //    'data' => $offices
        //];

        return Inertia::render('offices/officeIndex', $params);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOfficeRequest $request) {
        Office::create($request->all());

        return redirect()->back()
                        ->with('message', 'Office created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Office $office) {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOfficeRequest $request, Office $office) {
        $office->update($request->all());

        return redirect()->back()
                        ->with('message', 'Office updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Office $office) {
        $office->delete();

        return redirect()->back()->with('message', 'Office deleted');
    }

    public function gridData(Request $request) {
        $filters = $request->get('filters', []);
        $config = $request->get('config', []);

        $query = Office::with('type');

        if (count($filters) > 0) {
            if ($search = ($filters['search'] ?? null)) {
                $terms_cleaned = preg_replace("/[^a-zA-Z0-9\(\)\-\+\_@\.]+/", " ", $search);

                $terms = array_reduce(
                        explode(' ', $terms_cleaned),
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

        $offices = $query->paginate(config['per_page']);

        return response()->json(
                        ['offices' => $offices],
                        Response::HTTP_OK
        );
    }

    //public function get_offices()
    //{
    //    $offices = Office::query()->paginate(config('app.page_lines'));
    //    foreach($offices as $office){
    //        $office->type_name = OfficeType::from($office->type_id)->getLabelText();
    //        $office->type_color = OfficeType::from($office->type_id)->getLabelColor();
    //        $office->type_label = OfficeType::from($office->type_id)->getLabelHTML();
    //    }
    //    return $offices;
    //}
}
