<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Állatok csoportosítása
 * 
 * @category    Típusok
 * @package     App\Models
 * @author      Kovács Zoltán <zoltan1_kovacs@msn.com>
 * @version     1.0
 */
class AnimalGroup extends Model
{
    use HasFactory,
        SoftDeletes;

    protected $table = 'animal_groups';
    protected $fillable = ['name', 'label'];
    
    public function animals(){
        return $this->hasMany(Animal::class, 'group_id', 'id');
    }
}
