<?php

namespace Database\Seeders;

use App\Models\Source;
use Illuminate\Database\Seeder;

class SourcesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $sources = [
            ['name' => 'BBC News', 'slug' => 'bbc-news'],
            ['name' => 'CNN', 'slug' => 'cnn'],
            ['name' => 'The New York Times', 'slug' => 'the-new-york-times'],
            ['name' => 'The Guardian', 'slug' => 'the-guardian'],
            ['name' => 'Reuters', 'slug' => 'reuters'],
            ['name' => 'Associated Press', 'slug' => 'associated-press'],
            ['name' => 'Al Jazeera', 'slug' => 'al-jazeera'],
        ];

        foreach ($sources as $source) {
            Source::create($source + [
                'url' => 'https://' . str_replace(' ', '', strtolower($source['name'])) . '.com',
                'logo_url' => 'https://logo.clearbit.com/' . str_replace(' ', '', strtolower($source['name'])) . '.com',
            ]);
        }

        // Create additional random sources
        Source::factory()->count(5)->create();
    
    }
}
