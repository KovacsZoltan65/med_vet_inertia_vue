<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    
    protected $table = 'clients';

    protected $guarded = [];

    public function tags(){
        // A Laravelben a belongsToMany kapcsolat lehetővé teszi, 
        // hogy sok-sok kapcsolatot hozzunk létre két tábla között. 
        // A kapcsolatot egy harmadik táblában tároljuk, 
        // amelynek az elsődleges kulcsa a két tábla idegen kulcsait tartalmazza. 
        // A kapcsolatot a withTimestamps metódussal lehet frissíteni.
        return $this->belongsToMany(Tag::class);
    }
}
