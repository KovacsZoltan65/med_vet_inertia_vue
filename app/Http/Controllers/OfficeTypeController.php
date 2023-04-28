<?php

namespace App\Http\Controllers;

use App\Models\OfficeType;
use App\Http\Requests\StoreOfficeTypeRequest;
use App\Http\Requests\UpdateOfficeTypeRequest;
use Inertia\Inertia;

class OfficeTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = OfficeType::query()->paginate(10);

        return Inertia::render('office_types/index', [
            'data' => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOfficeTypeRequest $request)
    {
        OfficeType::create($request->all());

        return redirect()
            ->back()
            ->with('message', 'Office Type created');
    }

    /**
     * Display the specified resource.
     */
    public function show(OfficeType $office){}

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOfficeTypeRequest $request, OfficeType $office_type)
    {
        $office_type->update($request->all());

        return redirect()
            ->back()
            ->with('message', 'Office Type updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OfficeType $office)
    {
        $office->delete();

        return redirect()
            ->back()
            ->with('message', 'Office Type deleted');
    }
}
