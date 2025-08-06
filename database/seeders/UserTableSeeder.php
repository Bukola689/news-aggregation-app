<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         User::factory()->count(15)->create();
          // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        // Create test user
        $testUser = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        // Attach some preferences to test user
        $testUser->preferredSources()->attach([1, 3, 5]); // BBC, NY Times, Reuters
        $testUser->preferredCategories()->attach([1, 3, 6]); // Politics, Technology, Sports
        $testUser->preferredAuthors()->attach([1, 4]); // John Smith, Emily Davis

        // Create additional random users
        User::factory()->count(10)->create()->each(function ($user) {
            // Attach random preferences to each user
            $user->preferredSources()->attach(
                \App\Models\Source::inRandomOrder()->limit(rand(2, 5))->pluck('id')
            );
            $user->preferredCategories()->attach(
                \App\Models\Category::inRandomOrder()->limit(rand(2, 4))->pluck('id')
            );
            $user->preferredAuthors()->attach(
                \App\Models\Author::inRandomOrder()->limit(rand(1, 3))->pluck('id')
            );
        });
    
    }
}
