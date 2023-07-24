<?php


namespace Database\Seeders;


use App\Models\SocialMedia;
use Illuminate\Database\Seeder;

class SocialMediaSeeder extends Seeder
{
    public function run()
    {
        SocialMedia::create([
            'name' => 'Instagram',
            'hashtags' => '#dubai #dubai2022'
        ]);
    }
}
