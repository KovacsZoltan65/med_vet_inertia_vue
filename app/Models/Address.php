<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Cégek és személyek címei
 * 
 * @package App\Models
 * @author  Kovács Zoltán <zoltan1_kovacs@msn.com>
 * @version 1.0
 */
class Address extends Model
{
    use HasFactory;
    
    protected $table = 'address';
    protected $fillable = ['company_id', 'human_id', 'type_id', 'city', 'address'];
    
    public function human()
    {
        // A hasOne kapcsolat egy az egyhez kapcsolatot jelent az Eloquent ORM-ben. 
        // Ez azt jelenti, hogy az adott modellnek pontosan egy kapcsolódó modellje van. 
        // A kapcsolatot az adott modellben definiáljuk a hasOne metódussal. 
        // A kapcsolatot a kapcsolódó táblában lévő idegen kulcs határozza meg. 
        // Az idegen kulcs neve alapértelmezés szerint a kapcsolódó tábla neve és a “_id” szóösszetételével jön létre. 
        // Például, ha a User modellnek van egy Phone modellhez tartozó hasOne kapcsolata, 
        // akkor az idegen kulcs neve alapértelmezés szerint “phone_id” lesz.
        return $this->hasOne(Human::class, 'id', 'human_id');
    }
    
    public function company()
    {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }
    
}
