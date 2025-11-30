<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    protected $with = [
        'user:id,name,username,avatar',
    ];

    protected $withCount = [
        'likes',
        'bookmarks',
        'reposts',
        'replies',
    ];

    protected $fillable = [
        'message',
        'image',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Reply::class);
    }

    public function likes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'post_like')->withTimestamps();
    }

    public function bookmarks(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'post_bookmark')->withTimestamps();
    }

    public function reposts(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'post_repost')->withTimestamps();
    }
}
