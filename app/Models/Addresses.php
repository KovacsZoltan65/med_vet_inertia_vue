<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Addresses extends Model
{
    use HasFactory;
    
    protected $table = 'addresses';
    protected $fillable = ['company_id', 'human_id', 'type_id', 'city', 'address'];
    
    public function human()
    {
        return $this->hasOne(Human::class, 'id', 'human_id');
    }
    
    public function company()
    {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }
    
}
