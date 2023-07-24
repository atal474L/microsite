<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Znck\Eloquent\Traits\BelongsToThrough;

/**
 * @mixin IdeHelperPost
 */
class Post extends Model
{
    use HasFactory, SoftDeletes, BelongsToThrough;

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i',
        'updated_at'=> 'datetime:Y-m-d H:i',
        'posted_at' => 'datetime',
        'date' => 'datetime:d/m/Y',
        'time' => 'datetime:H:i',
    ];


    public function socialMediaAccount(): BelongsTo
    {
        return $this->belongsTo(SocialMediaAccount::class);
    }

    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class);
    }

    public function user(): \Znck\Eloquent\Relations\BelongsToThrough
    {
        return $this->belongsToThrough(User::class, SocialMediaAccount::class);
    }
}
