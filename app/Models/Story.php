<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'media_path', 'media_type'];

    // Scope to fetch only valid stories (within 24 hours)
    public function scopeActive($query)
    {
        return $query->where('created_at', '>=', now()->subHours(24));
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

