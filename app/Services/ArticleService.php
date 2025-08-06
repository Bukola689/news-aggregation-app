<?php

namespace App\Services;

use App\Dtos\ArticleDto;
use App\Models\Article;
use App\Interfaces\ArticleServiceInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use App\Exceptions\ModelNotFoundException;

class ArticleService implements ArticleServiceInterface
{
    public function create(ArticleDto $dto): Model
    {
        return Article::create($dto->toArray());
    }

    public function update(int $id, ArticleDto $dto): Model
    {
        $article = $this->getById($id);
        $article->update($dto->toArray());
        return $article;
    }

    public function delete(int $id): void
    {
        $article = $this->getById($id);
        $article->delete();
    }

    public function getAll(): Collection
    {
        return Article::latest()->get();
    }

    public function getById(int $id): Model
    {
        return Article::findOrFail($id);
    }
}
