<?php

namespace App\Models;

use App\Enums\HumanType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Human extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type_id', 'image'];
    
    public static function doctors(){
        
        // FodMap::where('name','=',$name)->where('category','=',$category)->get()
        $data = Human::where('type_id', '=', HumanType::ORVOS)->get();
        
        return $data;
    }
}
