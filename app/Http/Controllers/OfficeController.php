<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Http\Requests\StoreOfficeRequest;
use App\Http\Requests\UpdateOfficeRequest;
use Inertia\Inertia;

class OfficeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Office::query()->paginate(10);

        return Inertia::render('offices/index', [
            'data' => $data
        ]);
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
}
