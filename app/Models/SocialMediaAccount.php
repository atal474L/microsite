<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperSocialMediaAccount
 */
class SocialMediaAccount extends Model
{
    protected $fillable = [
        'user_id',
        'social_media_id',
        'profile_id',
        'access_token',
        'name',
    ];

    protected $hidden = [
        'profile_id',
        'access_token'
    ];

    use HasFactory, SoftDeletes;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function socialMedia(): BelongsTo
    {
        return $this->belongsTo(SocialMedia::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
