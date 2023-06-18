<?php

namespace App\Observers;

use App\Models\AddressType;

class AddressTypeObserver
{
    /**
     * Handle the AddressType "created" event.
     */
    public function created(AddressType $addressType): void
    {
        //
    }

    /**
     * Handle the AddressType "updated" event.
     */
    public function updated(AddressType $addressType): void
    {
        //
    }

    /**
     * Handle the AddressType "deleted" event.
     */
    public function deleted(AddressType $addressType): void
    {
        //
    }

    /**
     * Handle the AddressType "restored" event.
     */
    public function restored(AddressType $addressType): void
    {
        //
    }

    /**
     * Handle the AddressType "force deleted" event.
     */
    public function forceDeleted(AddressType $addressType): void
    {
        //
    }
}
