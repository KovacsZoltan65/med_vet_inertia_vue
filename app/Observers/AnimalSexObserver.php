<?php

namespace App\Observers;

use App\Models\AnimalSex;

class AnimalSexObserver
{
    /**
     * Handle the AnimalSex "created" event.
     */
    public function created(AnimalSex $animalSex): void
    {
        //
    }

    /**
     * Handle the AnimalSex "updated" event.
     */
    public function updated(AnimalSex $animalSex): void
    {
        //
    }

    /**
     * Handle the AnimalSex "deleted" event.
     */
    public function deleted(AnimalSex $animalSex): void
    {
        //
    }

    /**
     * Handle the AnimalSex "restored" event.
     */
    public function restored(AnimalSex $animalSex): void
    {
        //
    }

    /**
     * Handle the AnimalSex "force deleted" event.
     */
    public function forceDeleted(AnimalSex $animalSex): void
    {
        //
    }
}
