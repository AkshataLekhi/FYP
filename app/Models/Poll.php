<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poll extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'option_one',
        'option_two',
        'votes_one',
        'votes_two',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
