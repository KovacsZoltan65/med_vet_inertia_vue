<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnimalSex extends Model
{
    use HasFactory,
        SoftDeletes;

    protected $table = 'animal_sex';
    protected $fillable = ['name', 'label'];
}
