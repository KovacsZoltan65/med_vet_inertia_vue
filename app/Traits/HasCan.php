<?php

namespace App\Traits;

trait HasCan
{
    public function getCanAttribute(): array
    {
        $currentUser = request()->user();
        dd('getCanAttribute', $currentUser);
        return [];
    }
}