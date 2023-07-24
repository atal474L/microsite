<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

/**
 * @mixin IdeHelperPhoto
 */
class Photo extends Model
{
    use HasFactory, SoftDeletes;

    public function getPathAttribute(string $path): string
    {
        return public_path("posts/$path");
    }

    public function getUrlAttribute(): string
    {
        return Storage::disk('posts')->url($this->attributes['path']);
    }

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
