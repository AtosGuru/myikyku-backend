<?php

use App\Models\Feed;
use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->create_admin_data();
    }

    public function create_admin_data()
    {
        $id = User::create([
            'name' => "Administrator",
            'email' => "admin@myikyoku.com",
            'password' => bcrypt('myikyoku'),
            'role' => 'admin'
        ])->id;

        UserProfile::create([
            'user_id' => $id,
            'name_sei' => 'My医局',
            'name_mei' => 'マネージャー',
        ])->id;

        Feed::create([
            'user_id' => $id,
            'title' => '医療介護 CBnews',
            'rss_link' => 'https://www.cbnews.jp/rss/news.xml',
            'website_link' => 'https://www.cbnews.jp',
            'copyright' => 'Copyright(c)2019 CBnews Co.,Ltd. All Rights Reserved.'
        ]);

        Feed::create([
            'user_id' => $id,
            'title' => 'HealthDayJapan',
            'rss_link' => 'http://healthdayjapan.com/feed/',
            'website_link' => 'http://healthdayjapan.com',
            'copyright' => ''
        ]);
    }
}
