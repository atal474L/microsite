<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @mixin IdeHelperSocialMedia
 */
class SocialMedia extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'social_medias';

    public function accounts(): HasMany
    {
        return $this->hasMany(SocialMediaAccount::class);
    }
}
