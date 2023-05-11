<?php

namespace App\Observers;

use App\Models\Addresses;

class AddressesObserver
{
    /**
     * Handle the Addresses "created" event.
     */
    public function created(Addresses $addresses): void
    {
        //
    }

    /**
     * Handle the Addresses "updated" event.
     */
    public function updated(Addresses $addresses): void
    {
        //
    }

    /**
     * Handle the Addresses "deleted" event.
     */
    public function deleted(Addresses $addresses): void
    {
        //
    }

    /**
     * Handle the Addresses "restored" event.
     */
    public function restored(Addresses $addresses): void
    {
        //
    }

    /**
     * Handle the Addresses "force deleted" event.
     */
    public function forceDeleted(Addresses $addresses): void
    {
        //
    }
}
