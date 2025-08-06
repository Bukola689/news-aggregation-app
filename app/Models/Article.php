<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $guarded = [];

     protected $fillable = [
        'source_id',
        'title',
        'slug',
        'description',
        'content',
        'url',
        'image_url',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function source()
    {
        return $this->belongsTo(Source::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class);
    }

      // app/Models/Article.php
    public function scopeRecent($query)
    {
      return $query->orderBy('published_at', 'desc');
    }

    public function scopePopular($query)
    {
       return $query->orderBy('views', 'desc');
    }

     public function getExcerptAttribute(): string
     {
        return Str::limit($this->description, 150);
     }

    public function scopeWithFilters($query, $filters)
    {
        return $query->when(isset($filters['search']), function ($query) use ($filters) {
            $query->where(function ($q) use ($filters) {
                $q->where('title', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('description', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('content', 'like', '%' . $filters['search'] . '%');
            });
        })
        ->when(isset($filters['date_from']), function ($query) use ($filters) {
            $query->where('published_at', '>=', $filters['date_from']);
        })
        ->when(isset($filters['date_to']), function ($query) use ($filters) {
            $query->where('published_at', '<=', $filters['date_to']);
        })
        ->when(isset($filters['source']), function ($query) use ($filters) {
            $query->whereHas('source', function ($q) use ($filters) {
                $q->where('slug', $filters['source']);
            });
        })
        ->when(isset($filters['category']), function ($query) use ($filters) {
            $query->whereHas('categories', function ($q) use ($filters) {
                $q->where('slug', $filters['category']);
            });
        });
    }
     
}
