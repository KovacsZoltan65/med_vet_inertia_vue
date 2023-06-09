<?php

namespace App\Observers;

use App\Models\Examination;

class ExaminationObserver
{
    /**
     * Handle the Examination "created" event.
     */
    public function created(Examination $examination): void
    {
        //
    }

    /**
     * Handle the Examination "updated" event.
     */
    public function updated(Examination $examination): void
    {
        //
    }

    /**
     * Handle the Examination "deleted" event.
     */
    public function deleted(Examination $examination): void
    {
        //
    }

    /**
     * Handle the Examination "restored" event.
     */
    public function restored(Examination $examination): void
    {
        //
    }

    /**
     * Handle the Examination "force deleted" event.
     */
    public function forceDeleted(Examination $examination): void
    {
        //
    }
}
