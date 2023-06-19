<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'companies';
    
    protected $fillable = ['name'];
    
    public static function toSelect(){
        $companies = [];
        
        //$d = self::query()->select(['id', 'name'])->orderBy('name', 'asc')->get();
        //foreach($d as $a){
        //    array_push($companies, (object)['id' => $a->id,'name' => $a->name,]);
        //}
        
        $d = self::query()->select(['id', 'name'])->orderBy('name', 'asc')->get()->toArray();

        return $companies;
    }
    
}
