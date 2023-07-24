<?php

namespace App\Actions;

use App\Models\Photo;
use Spatie\Image\Exceptions\InvalidManipulation;
use Spatie\Image\Image;
use Spatie\Image\Manipulations;

class ResizePhotoAction
{
    /**
     * @param Photo $photo
     * @return void
     * @throws InvalidManipulation
     */
    public function __invoke(Photo $photo)
    {
        Image::load($photo->path)
            ->crop(Manipulations::CROP_CENTER, 750, 750)
            ->save();
    }
}
