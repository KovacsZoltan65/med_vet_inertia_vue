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
        
        $types = \App\Enums\OfficeType::toArray();
        
        //dd(
        //    $types, 
        //    $this->type_id, 
        //    \App\Enums\OfficeType::toArray()[$this->type_id - 1]
        //);
        
        return \App\Enums\OfficeType::toArray()[$this->type_id - 1];
    }
}
