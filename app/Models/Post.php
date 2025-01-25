<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = ['body','user_id'];

    protected function user(){
        return $this->belongsTo(User::class);
    }
    protected function comment(){
        return $this->hasMany(comment::class);
    }
}
