<?php

namespace App\Observers;

use App\Models\AnimalGroup;

class AnimalGroupObserver
{
    /**
     * Handle the AnimalGroup "created" event.
     */
    public function created(AnimalGroup $animalGroup): void
    {
        //
    }

    /**
     * Handle the AnimalGroup "updated" event.
     */
    public function updated(AnimalGroup $animalGroup): void
    {
        //
    }

    /**
     * Handle the AnimalGroup "deleted" event.
     */
    public function deleted(AnimalGroup $animalGroup): void
    {
        //
    }

    /**
     * Handle the AnimalGroup "restored" event.
     */
    public function restored(AnimalGroup $animalGroup): void
    {
        //
    }

    /**
     * Handle the AnimalGroup "force deleted" event.
     */
    public function forceDeleted(AnimalGroup $animalGroup): void
    {
        //
    }
}
