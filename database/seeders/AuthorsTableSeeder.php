<?php

namespace Database\Seeders;

use App\Models\Author;
use Illuminate\Database\Seeder;

class AuthorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $authors = [
            ['name' => 'John Smith', 'slug' => 'john-smith'],
            ['name' => 'Sarah Johnson', 'slug' => 'sarah-johnson'],
            ['name' => 'Michael Brown', 'slug' => 'michael-brown'],
            ['name' => 'Emily Davis', 'slug' => 'emily-davis'],
            ['name' => 'Robert Wilson', 'slug' => 'robert-wilson'],
        ];

        foreach ($authors as $author) {
            Author::create($author);
        }

        // Create additional random authors
        Author::factory()->count(15)->create();
    }
}
