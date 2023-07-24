<?php

namespace App\Console\Commands;

use App\Instagram\Exceptions\NoHashtagProvided;
use App\Jobs\SynchronizeInstagramPosts;
use App\Models\SocialMedia;
use App\Models\SocialMediaAccount;
use Illuminate\Console\Command;

class SynchronizeInstagramCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'synchronize:instagram';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Inserts or updates all existing users instagram posts';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle() : void
    {
        try {
            SynchronizeInstagramPosts::dispatch(SocialMediaAccount::whereNotNull('profile_id')
                ->whereNotNull('access_token')
                ->where('social_media_id', '=', 1)
                ->get()
            );
        } catch (NoHashtagProvided $exception){
            $this->error($exception->getMessage());
        }

    }
}


//$hashtag = SocialMedia::where('id', '=', 1)->value('hashtag');
//
//if (empty($hashtag)) {
//    throw new NoHashtagProvided("No hashtags found");
//}
