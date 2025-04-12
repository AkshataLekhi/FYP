<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
        'content',
    ];

    /**
     * Each comment belongs to a post.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Each comment belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
