<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name'     => 'Admin',
            'email'    => 'admin@cms.local',
            'password' => bcrypt('password'),
        ]);

        $cats = [
            ['name'=>'Du lịch',   'slug'=>'du-lich',   'type'=>'memory', 'color'=>'#c9847a'],
            ['name'=>'Tình yêu',  'slug'=>'tinh-yeu',  'type'=>'memory', 'color'=>'#c97a9e'],
            ['name'=>'Lifestyle', 'slug'=>'lifestyle', 'type'=>'blog',   'color'=>'#7a9ec9'],
            ['name'=>'Review',    'slug'=>'review',     'type'=>'blog',   'color'=>'#9ec97a'],
            ['name'=>'Thông báo', 'slug'=>'thong-bao',  'type'=>'news',   'color'=>'#7ac97a'],
            ['name'=>'Chung',     'slug'=>'chung',      'type'=>'general','color'=>'#a0a0a0'],
        ];
        foreach ($cats as $c) \App\Models\Category::create($c);
    }
}
