<?php

namespace App\Observers;

use App\Models\HumanType;

class HumanTypexObserver
{
    /**
     * Handle the HumanType "created" event.
     */
    public function created(HumanType $humanType): void
    {
        //
    }

    /**
     * Handle the HumanType "updated" event.
     */
    public function updated(HumanType $humanType): void
    {
        //
    }

    /**
     * Handle the HumanType "deleted" event.
     */
    public function deleted(HumanType $humanType): void
    {
        //
    }

    /**
     * Handle the HumanType "restored" event.
     */
    public function restored(HumanType $humanType): void
    {
        //
    }

    /**
     * Handle the HumanType "force deleted" event.
     */
    public function forceDeleted(HumanType $humanType): void
    {
        //
    }
}
