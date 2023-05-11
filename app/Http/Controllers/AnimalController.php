<?php

namespace App\Http\Controllers;

use App\Enums\AnimalGroup;
use App\Enums\AnimalSex;
use App\Http\Requests\StoreAnimalRequest;
use App\Http\Requests\UpdateAnimalRequest;
use App\Models\Animal;
use Inertia\Inertia;

class AnimalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Animal::query()->paginate( config('app.page_lines') );
        
        foreach($data as $animal){
            
            $animal->sex_name = AnimalSex::from($animal->sex)->getLabelText();
            $animal->sex_color = AnimalSex::from($animal->sex)->getLabelColor();
            $animal->sex_label = AnimalSex::from($animal->sex)->getLabelHTML();
            
            $animal->group_name = AnimalGroup::from($animal->group)->getLabelText();
            $animal->group_color = AnimalGroup::from($animal->group)->getLabelColor();
            $animal->group_label = AnimalGroup::from($animal->group)->getLabelHTML();
        }
        
        $animalSex = AnimalSex::toArray();
        $animalGroup = AnimalGroup::toArray();
        
        return Inertia::render('animals/animalIndex', [
            'data' => $data,
            'animalSex' => $animalSex,
            'animalGroup' => $animalGroup,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAnimalRequest $request)
    {
        Animal::create($request->all());
        
        return redirect()->back()
            ->with('message', 'Animal created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Animal $animal){}

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAnimalRequest $request, Animal $animal)
    {
        $animal->update($request->all());
        
        return redirect()->back()
            ->with('message', 'Animal updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Animal $animal)
    {
        $animal->delete();
        
        return redirect()->back()
            ->with('message', 'Animal deleted');
    }
}
