<?php

namespace App\Jobs;

use App\Actions\ResizePhotoAction;
use App\Instagram\Exceptions\InstagramClientException;
use App\Instagram\Exceptions\NoHashtagProvided;
use App\Instagram\InstagramClient;
use App\Models\Photo;
use App\Models\Post;
use App\Models\SocialMedia;
use App\Models\SocialMediaAccount;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\File;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Image\Exceptions\InvalidManipulation;

class SynchronizeInstagramPosts
{
    use Dispatchable, SerializesModels;

    /**
     * @var Collection<SocialMediaAccount>
     */
    protected Collection $socialMediaAccounts;

    protected InstagramClient $client;

    protected ResizePhotoAction $resizePhotoAction;

    /**
     * @param Collection<SocialMediaAccount> $socialMediaAccounts
     */
    public function __construct(Collection $socialMediaAccounts)
    {
        $this->socialMediaAccounts = $socialMediaAccounts;
    }

    /**
     * @throws InvalidManipulation
     * @throws NoHashtagProvided
     * @throws InstagramClientException
     * @throws GuzzleException
     */
    public function handle(InstagramClient $client, ResizePhotoAction $resizePhotoAction)
    {
        $this->client = $client;
        $this->resizePhotoAction = $resizePhotoAction;

        $hashtags = SocialMedia::where('id', '=', 1)->value('hashtags');

        if (empty($hashtags)) {
            throw new NoHashtagProvided('No hashtags found for social media [Instagram]', 3);
        }

        $hashtags = explode(' ', trim($hashtags));

        $this->socialMediaAccounts->each(function (SocialMediaAccount $account) use ($hashtags) {
            $medias = $this->client->media($account)->getRecentMedia() ?? [];

            collect($medias)->map(function (object $media) use ($account, $hashtags)
            {
                if (! $this->hasValidCaption($media, $hashtags)) {
                    return true;
                }

                /** @var Post $post */
                $post = $account->posts()->updateOrCreate(
                    ['external_id' => (int)$media->id],
                    [
                        'type' => $media->media_type,
                        'caption' => $media->caption,
                        'posted_at' => (new Carbon($media->timestamp))->format('Y-m-d H:i:s'),
                    ]);

                $post = $this->handlePhotos($account, $post, $media);

                $post->loadMissing('photos')->photos
                    ->each(fn (Photo $photo) => ($this->resizePhotoAction)($photo));

                return $post;
            });
        });
    }

    private function hasValidCaption(object $media, array $hashtags): bool
    {
        if (empty($media->caption)) {
            return false;
        }

        return Str::contains($media->caption, $hashtags);
    }

    /**
     * @throws InstagramClientException
     * @throws GuzzleException
     */
    protected function handlePhotos(SocialMediaAccount $account, Post $post, object $media): Post
    {
        if($post->type !== 'CAROUSEL_ALBUM')
        {
            $post->photos()->upsert(
                [[
                    'post_id' => $post->id,
                    'path' => $this->processInstagramPhoto($media, $account),
                    'thumbnail_url' => $media->thumbnail_url ?? '',
                    'external_id' => (int)$media->id,
                ]],
                ['external_id']
            );

            return $post;
        }

        $mediaChildren = $this->client->media($account)->getMediaChildren($media->id)->data ?? [];

        $post->photos()->upsert(
            collect($mediaChildren)
                ->map(fn(object $mediaChild) => [
                    'post_id' => $post->id,
                    'path' => $this->processInstagramPhoto($mediaChild, $account),
                    'thumbnail_url' => $mediaChild->thumbnail_url ?? null,
                    'external_id' => (int)$mediaChild->id,
                ])
                ->toArray(),
            ['external_id']
        );

        return $post;
    }

    protected function processInstagramPhoto(object $media, SocialMediaAccount $account): string
    {
        $tempFileName = tempnam('', time());
        $tempFile = fopen($tempFileName, 'w+');
        fputs($tempFile, file_get_contents($media->media_url));
        fclose($tempFile);

        $file = new File($tempFileName);
        $fileName = "{$account->socialMedia->name}_{$account->name}_$media->id." . $file->extension();

        return Storage::disk('posts')->putFileAS('', $file,  $fileName);
    }
}
