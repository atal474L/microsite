<?php

namespace App\Dtos;

use App\Models\Photo;
use App\Models\Post;
use Illuminate\Support\Carbon;
use Spatie\DataTransferObject\DataTransferObject;

class PostDto extends DataTransferObject
{
    public int $id;

    public string $type;

    public ?string $author;

    public ?string $caption;

    public Carbon $posted_at;
    public string $date;
    public string $time;

    /** @var array|PhotoDto[] */
    public array $photos;

    /**
     * @param Post $post
     * @return static
     */
    public static function fromPost(Post $post): self
    {
        return new static([
            'date' => $post->posted_at->format('d/m/Y'),
            'time' => $post->posted_at->format('H:i'),
            'id' => $post->id,
            'type' => $post->type,
            'author' => $post->user->first_name ?? null,
            'caption' => $post->caption,
            'posted_at' => $post->posted_at,
            'photos' => $post->photos->map(fn (Photo $photo) => PhotoDto::fromPhoto($photo))->toArray(),
        ]);
    }
}
