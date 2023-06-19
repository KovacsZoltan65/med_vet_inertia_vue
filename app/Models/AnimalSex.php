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
    
    public function animals(){
        // Ez a kód a modellben található. 
        // A hasMany kapcsolat azt jelenti, hogy az adott modellhez több másik 
        // modell is tartozhat. A hasMany kapcsolatban az első argumentum a 
        // kapcsolódó modell osztályának neve.
        return $this->hasMany(Animal::class, 'group_id', 'id');
    }
}
