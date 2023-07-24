<?php


namespace Database\Seeders;


use App\Models\Photo;
use App\Models\Post;
use App\Models\SocialMedia;
use App\Models\SocialMediaAccount;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    private const USERS = [
        'atal' => [
            'first_name' => 'Atal',
            'last_name' => 'Ab',
            'email' => 'atal@webatvantage.be',
        ],
        'tom' => [
            'first_name' => 'Tom',
            'last_name' => 'Six',
            'email' => 'tom@webatvantage.be',
        ],
        'jarno' => [
            'first_name' => 'Jarno',
            'last_name' => 'Lasseel',
            'email' => 'jarno@webatvantage.be',
        ],
        'jeffrey' => [
            'first_name' => 'Jeffrey',
            'last_name' => 'Lermyte',
            'email' => 'jeffrey@webatvantage.be',
        ],
        'sam' => [
            'first_name' => 'Sam',
            'last_name' => 'Van de Steen',
            'email' => 'sam@webatvantage.be',
        ],
        'robert' => [
            'first_name' => 'Robert',
            'last_name' => 'Nurijanyan',
            'email' => 'robert@webatvantage.be',
        ],
        'simon' => [
            'first_name' => 'Simon',
            'last_name' => 'Vanden Haesevelde',
            'email' => 'simon@webatvantage.be',
        ],
        'wim' => [
            'first_name' => 'Wim',
            'last_name' => 'Puissant',
            'email' => 'wim@webatvantage.be',
        ],
        'wouter' => [
            'first_name' => 'Wouter',
            'last_name' => 'Standaert',
            'email' => 'wouter@webatvantage.be',
        ]
    ];


    public function run()
    {
        foreach (self::USERS as $name => $user)
        {
            User::factory([
               'first_name' => $user['first_name'],
                'last_name' => $user['last_name'],
                'email' => $user['email'],
                'password' => bcrypt($name)
            ])
                ->has(SocialMediaAccount::factory()
                    ->count(1)
                    ->state(new Sequence(
                        ...SocialMedia::all('id')
                        ->map(fn (SocialMedia $socialMedia) => ['social_media_id' => $socialMedia->id])
                        ->toArray()
                    ))
                    ->has(Post::factory()
                        ->count(5)
                        ->has(Photo::factory()
                            ->count(3)
                        )
                    )
                )
                ->create();
        }
    }
}
