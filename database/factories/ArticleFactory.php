<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Source;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
     protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
         $title = $this->faker->sentence();

        return [
             'source_id' => Source::factory(),
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => $this->faker->paragraph(),
            'content' => $this->faker->text(2000),
            'url' => $this->faker->url(),
            'image_url' => $this->faker->imageUrl(800, 400),
            'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }

       public function configure()
    {
        return $this->afterCreating(function (Article $article) {
            // Attach 1-3 random categories
            $categories = \App\Models\Category::inRandomOrder()
                ->limit(rand(1, 3))
                ->pluck('id');
            $article->categories()->attach($categories);

            // Attach 1-2 random authors
            $authors = \App\Models\Author::inRandomOrder()
                ->limit(rand(1, 2))
                ->pluck('id');
            $article->authors()->attach($authors);
        });
    }
}
