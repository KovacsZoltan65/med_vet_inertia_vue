<?php

namespace App\Observers;

use App\Models\Human;

class HumanObserver {

    /**
     * Handle the Human "created" event.
     */
    public function created(Human $human): void {
        //
    }

    /**
     * Handle the Human "updated" event.
     */
    public function updated(Human $human): void {
        //
    }

    /**
     * Handle the Human "deleted" event.
     */
    public function deleted(Human $human): void {
        if (file_exists(public_path($human->image))) {
            unlink(public_path($human->image));
        }
    }

    /**
     * Handle the Human "restored" event.
     */
    public function restored(Human $human): void {
        //
    }

    /**
     * Handle the Human "force deleted" event.
     */
    public function forceDeleted(Human $human): void {
        //
    }

}
