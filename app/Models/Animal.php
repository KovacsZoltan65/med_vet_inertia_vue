<?php

namespace App\Models;

use App\Enums\AnimalGroup;
use App\Enums\AnimalSex;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;
    
    protected $table = 'animals';
    protected $fillable = ['name', 'sex', 'group'];
    
    //protected $casts = [
    //    'sex' => AnimalSex::class,
    //    'group' => AnimalGroup::class,
    //];
}
