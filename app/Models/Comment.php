<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['name', 'comment', 'reply_to', 'comment_level'];

    // Get all replies using recursion
    public function replies()
    {
        return $this->hasMany('App\Models\Comment', 'reply_to', 'id')->with('replies');
    }
}
