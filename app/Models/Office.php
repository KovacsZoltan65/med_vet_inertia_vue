<?php

namespace App\Models;

use App\Models\OfficeType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Office extends Model
{
    use HasFactory;

    protected $table = 'offices';
    protected $fillable = ['name', 'type_id'];

    public function type(){
        return $this->hasOne(OfficeType::class, 'id', 'type_id');
    }
}
