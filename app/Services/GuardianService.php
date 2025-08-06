<?php

namespace App\Services;

use App\Models\Article;
use App\Models\Source;
use App\Models\Category;
use App\Models\Author;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class GuardianService
{
    protected $apiKey;
    protected $baseUrl = 'https://content.guardianapis.com';

    public function __construct()
    {
        $this->apiKey = config('services.guardian.key');
    }

    public function fetchArticles()
    {
        $response = Http::get("{$this->baseUrl}/search", [
            'api-key' => $this->apiKey,
            'page-size' => 100,
            'show-fields' => 'all',
        ]);

        if ($response->successful()) {
            $articles = $response->json()['response']['results'];
            $this->processArticles($articles);
        }
    }

    protected function processArticles(array $articles)
    {
        $source = Source::firstOrCreate(
            ['name' => 'The Guardian'],
            ['slug' => 'the-guardian']
        );

        foreach ($articles as $articleData) {
            $fields = $articleData['fields'] ?? [];
            
            $article = Article::updateOrCreate(
                ['url' => $articleData['webUrl']],
                [
                    'source_id' => $source->id,
                    'title' => $articleData['webTitle'],
                    'slug' => \Str::slug($articleData['webTitle']),
                    'description' => $fields['trailText'] ?? null,
                    'content' => $fields['body'] ?? null,
                    'url' => $articleData['webUrl'],
                    'image_url' => $fields['thumbnail'] ?? null,
                    'published_at' => Carbon::parse($articleData['webPublicationDate']),
                ]
            );

            // Process section as category
            if (isset($articleData['sectionId'])) {
                $category = Category::firstOrCreate(
                    ['name' => $articleData['sectionName']],
                    ['slug' => $articleData['sectionId']]
                );
                $article->categories()->syncWithoutDetaching($category->id);
            }

            // Process authors if available
            if (isset($fields['byline'])) {
                $authorNames = explode(',', $fields['byline']);
                foreach ($authorNames as $authorName) {
                    $authorName = trim(str_replace('and', '', $authorName));
                    if (!empty($authorName)) {
                        $author = Author::firstOrCreate(
                            ['name' => $authorName],
                            ['slug' => \Str::slug($authorName)]
                        );
                        $article->authors()->syncWithoutDetaching($author->id);
                    }
                }
            }
        }
    }
}