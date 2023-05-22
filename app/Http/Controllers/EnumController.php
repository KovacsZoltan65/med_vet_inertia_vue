<?php

namespace App\Http\Controllers;

use App\Enums\OfficeType;

class EnumController extends Controller
{
    public function getOfficeTypesEnum()
    {
        $data = OfficeType::toArray();
        
        return $data;
    }
}