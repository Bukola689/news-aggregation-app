<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Source;
use App\Models\Category;
use App\Models\Author;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class NewsApiService
{
    protected $apiKey;
    protected $baseUrl = 'https://newsapi.org/v2';

    public function __construct()
    {
        $this->apiKey = config('services.newsapi.key');
    }

    public function fetchArticles()
    {
        $response = Http::get("{$this->baseUrl}/top-headlines", [
            'apiKey' => $this->apiKey,
            'pageSize' => 100,
            'country' => 'us',
        ]);

        if ($response->successful()) {
            $articles = $response->json()['articles'];
            $this->processArticles($articles);
        }
    }

    protected function processArticles(array $articles)
    {
        foreach ($articles as $articleData) {
            if (!$articleData['title'] || !$articleData['url']) {
                continue;
            }

            $source = Source::firstOrCreate(
                ['name' => $articleData['source']['name']],
                ['slug' => \Str::slug($articleData['source']['name'])]
            );

            $article = Article::updateOrCreate(
                ['url' => $articleData['url']],
                [
                    'source_id' => $source->id,
                    'title' => $articleData['title'],
                    'slug' => \Str::slug($articleData['title']),
                    'description' => $articleData['description'],
                    'content' => $articleData['content'],
                    'url' => $articleData['url'],
                    'image_url' => $articleData['urlToImage'],
                    'published_at' => Carbon::parse($articleData['publishedAt']),
                ]
            );

            // Process categories if available
            if (isset($articleData['category'])) {
                $category = Category::firstOrCreate(
                    ['name' => $articleData['category']],
                    ['slug' => \Str::slug($articleData['category'])]
                );
                $article->categories()->syncWithoutDetaching($category->id);
            }
        }
    }
}