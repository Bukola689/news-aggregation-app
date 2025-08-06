<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'content' => $this->content,
            'url' => $this->url,
            'image_url' => $this->image_url,
            'published_at' => $this->published_at->toIso8601String(),
            'created_at' => $this->created_at->toIso8601String(),
            'updated_at' => $this->updated_at->toIso8601String(),
            
            // Relationships
            'source' => $this->whenLoaded('source', function () {
                return [
                    'id' => $this->source->id,
                    'name' => $this->source->name,
                    'slug' => $this->source->slug,
                    'url' => $this->source->url,
                    'logo_url' => $this->source->logo_url,
                ];
            }),
            
            'categories' => $this->whenLoaded('categories', function () {
                return $this->categories->map(function ($category) {
                    return [
                        'id' => $category->id,
                        'name' => $category->name,
                        'slug' => $category->slug,
                    ];
                });
            }),
            
            'authors' => $this->whenLoaded('authors', function () {
                return $this->authors->map(function ($author) {
                    return [
                        'id' => $author->id,
                        'name' => $author->name,
                        'slug' => $author->slug,
                    ];
                });
            }),
            
            // Meta data
            'meta' => [
                'type' => 'article',
                'version' => '1.0',
            ],
        ];
    }

     /**
     * Add additional meta data to the resource response.
     *
     * @return array<string, mixed>
     */
    public function with($request): array
    {
        return [
            'links' => [
                'self' => route('/articles/{article:slug}', $this->slug),
                'source' => $this->whenLoaded('source', function () {
                    return route('api.sources.show', $this->source->slug);
                }),
            ],
        ];
    }
}
