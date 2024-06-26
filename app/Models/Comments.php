<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use app\Models\posts;
class Comments extends Model
{
    use HasFactory;
    protected $fillable = ['post_id', 'user_id', 'body'];

    public function post()
    {
        return $this->belongsTo(posts::class, 'post_id');
    }
}
