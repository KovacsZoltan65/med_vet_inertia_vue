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
        
        //$data = Human::where('type_id', '=', HumanType::ORVOS)->get();
        $data = \DB::table('view_humans')
            ->where('type_id', '=', HumanType::ORVOS)
            ->get();
        
        return $data;
    }
    
    public static function toSelect() : array{
        $humans = [];
        
        $d = self::query()->select(['id', 'name'])->orderBy('name', 'asc')->get();
        
        foreach($d as $a){
            $obj = (object)['id' => $a->id, 'name' => $a->name,];
            
            array_push($humans, $obj);
        }
        
        //dd($humans);
        
        return $humans;
    }
}
