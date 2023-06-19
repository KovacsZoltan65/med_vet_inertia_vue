<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Cím típusok
 * 
 * @category    Típusok
 * @package     App\Models
 * @author      Kovács Zoltán <zolta1_kovacs@msn.com>
 * @version     1.0
 */
class AddressType extends Model
{
    use HasFactory, 
        SoftDeletes;

    protected $table = 'address_types';
    protected $fillable = ['name', 'label'];
    
    public function addresses(){
        // Ez a kód a modellben található. 
        // A hasMany kapcsolat azt jelenti, hogy az adott modellhez több másik 
        // modell is tartozhat. A hasMany kapcsolatban az első argumentum a 
        // kapcsolódó modell osztályának neve.
        return $this->hasMany(Address::class, 'type_id', 'id');
    }
}
