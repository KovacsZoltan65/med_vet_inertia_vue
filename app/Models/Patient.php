<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    
    protected $table = 'patients';
    protected $fillable = [
        'user_id','doctor_id','animal_id',
        'office_id','treatment_id','start_time','final_time'
    ];
    
    // Beteghez kapcsolt ordos lekérése
    public function doctor(){
        return $this->hasOne(Human::class, 'id', 'doctor_id');
    }
    
    // Kapcsolt állat lekérése
    public function animal(){
        return $this->hasOne(Animal::class, 'id', 'animal_id');
    }
}
