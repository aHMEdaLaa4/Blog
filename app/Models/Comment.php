<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = ['body','user_id','post_id'];
    
    protected function user(){
        return $this->belongsTo(User::class);
    }    
    protected function post(){
        return $this->belongsTo(Post::class);
    }    
}
