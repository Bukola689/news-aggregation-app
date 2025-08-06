<?php

namespace App\Interfaces;

use App\Dtos\ArticleDto;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface ArticleServiceInterface
{
    public function create(ArticleDto $dto): Model;
    public function update(int $id, ArticleDto $dto): Model;
    public function delete(int $id): void;
    public function getAll(): Collection;
    public function getById(int $id): Model;
}
