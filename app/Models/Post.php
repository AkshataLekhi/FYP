<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'links',
        'picture',
        'user_id',
    ];

    // ✅ Post belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ✅ Post has one poll
    public function poll()
    {
        return $this->hasOne(Poll::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes')->withTimestamps();
    }

    // app/Models/Post.php
public function savedByUsers()
{
    return $this->belongsToMany(User::class, 'saved_posts')->withTimestamps();
}

}
