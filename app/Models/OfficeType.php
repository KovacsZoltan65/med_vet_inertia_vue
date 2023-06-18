<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OfficeType extends Model
{
    use HasFactory,
        SoftDeletes;

    protected $table = 'office_types';
    protected $fillable = ['name', 'label'];
}
