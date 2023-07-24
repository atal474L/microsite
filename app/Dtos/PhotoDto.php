<?php

namespace App\Dtos;

use App\Models\Photo;
use Illuminate\Support\Facades\Storage;
use Spatie\DataTransferObject\DataTransferObject;

class PhotoDto extends DataTransferObject
{
    public int $id;

    public string $url;

    public ?string $thumbnail_url;

    /**
     * @param Photo $photo
     * @return static
     */
    public static function fromPhoto(Photo $photo): self
    {
       return new static([
            'id' => $photo->id,
            'url' => $photo->url,
            'thumbnail_url' => $photo->thumbnail_url,
        ]);
    }
}
