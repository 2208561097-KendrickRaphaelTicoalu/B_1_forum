<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use app\Models\posts;
class Comments extends Model
{
    use HasFactory;
    protected $fillable = ['writer','post_id', 'body'];


    public function post()
    {
        return $this->belongsTo(posts::class, 'post_id', 'post_id');
    }

}
