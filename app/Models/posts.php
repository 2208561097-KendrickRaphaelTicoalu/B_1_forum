<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class posts extends Model
{
    use HasFactory;
    protected $fillable = ['writer', 'title', 'body', 'image', 'likes'];
    public function comments()
    {
        return $this->hasMany(Comments::class, 'post_id');
    }

}
