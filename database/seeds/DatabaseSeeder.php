<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('feeds')->insert([
            'name'     => 'Webcomic Name',
            'url'      => 'http://webcomicname.com/rss',
            'site_url' => 'http://webcomicname.com/',
            'parse_rule' => 'description',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('feeds')->insert([
            'name'     => 'Commit Strip',
            'url'      => 'http://www.commitstrip.com/en/feed/',
            'site_url' => 'http://www.commitstrip.com/',
            'parse_rule' => 'content',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('feeds')->insert([
            'name'     => 'Strange Planet',
            'url'      => 'https://queryfeed.net/instagram?q=nathanwpylestrangeplanet',
            'site_url' => 'https://www.instagram.com/p/BvHAYK2ARcT/',
            'parse_rule' => 'enclosure',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('feeds')->insert([
            'name'     => 'Things In Squares',
            'url'      => 'https://www.thingsinsquares.com/feed/',
            'site_url' => 'https://www.thingsinsquares.com/',
            'parse_rule' => 'description',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('feeds')->insert([
            'name'     => 'xkcd',
            'url'      => 'https://www.xkcd.com/rss.xml',
            'site_url' => 'https://www.xkcd.com/',
            'parse_rule' => 'description',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
