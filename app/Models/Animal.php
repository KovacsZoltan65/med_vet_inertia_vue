<?php

namespace App\Models;

use App\Enums\AnimalGroup;
use App\Enums\AnimalSex;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Állatok nyilvántartása
 * 
 * @package App\Models
 * @author  Kovács Zoltán <zoltan1_kovacs@msn.com>
 * @version 1.0
 */
class Animal extends Model
{
    use HasFactory;
    
    protected $table = 'animals';
    protected $fillable = ['name', 'sex_id', 'group_id'];
    
    //protected $casts = [
    //    'sex' => AnimalSex::class,
    //    'group' => AnimalGroup::class,
    //];
    
    public function sex(){
        return $this->hasOne(AnimalSex::class, 'id', 'sex_id');
    }
    
    public function group(){
        return $this->hasOne(AnimalGroup::class, 'id', 'group_id');
    }
}
