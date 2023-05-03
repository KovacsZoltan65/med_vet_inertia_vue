<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function humans(){
        return $this->hasMany(Post::class, 'id', 'post_id');
    }
}
