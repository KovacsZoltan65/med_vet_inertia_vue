<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;

class Human extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'post_id', 'image'];

    public function post(){
        return $this->hasOne(Post::class, 'id', 'post_id');
    }
}
