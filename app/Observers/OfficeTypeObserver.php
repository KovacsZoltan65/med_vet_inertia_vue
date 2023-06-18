<?php

namespace App\Observers;

use App\Models\OfficeType;

class OfficeTypeObserver
{
    /**
     * Handle the OfficeType "created" event.
     */
    public function created(OfficeType $officeType): void
    {
        //
    }

    /**
     * Handle the OfficeType "updated" event.
     */
    public function updated(OfficeType $officeType): void
    {
        //
    }

    /**
     * Handle the OfficeType "deleted" event.
     */
    public function deleted(OfficeType $officeType): void
    {
        //
    }

    /**
     * Handle the OfficeType "restored" event.
     */
    public function restored(OfficeType $officeType): void
    {
        //
    }

    /**
     * Handle the OfficeType "force deleted" event.
     */
    public function forceDeleted(OfficeType $officeType): void
    {
        //
    }
}
