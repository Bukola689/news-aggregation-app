<?php

namespace App\Dtos;

use App\Interfaces\DtoInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRequest;

Class ArticleDto implements DtoInterface
{
    private int $id;
    private string $title;
    private ?string $content;
    private ?string $author;
    private string $source;
    private ?string $category;
    private string $url;
    private \Carbon\Carbon $published_at;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;
        return $this;
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(?string $author): self
    {
        $this->author = $author;
        return $this;
    }

    public function getSource(): string
    {
        return $this->source;
    }

    public function setSource(string $source): self
    {
        $this->source = $source;
        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(?string $category): self
    {
        $this->category = $category;
        return $this;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;
        return $this;
    }

   public function getPublishedAt(): \Carbon\Carbon
   {
       return $this->published_at;
   }

   public function setPublishedAt(\Carbon\Carbon $published_at): self
   {
       $this->published_at = $published_at;
       return $this;
   }


    public static function fromApiFormRequest(UserRequest $request): DtoInterface
    {
        $dto = new self();
        $dto->setTitle($request->input('title'))
            ->setContent($request->input('content'))
            ->setAuthor($request->input('author'))
            ->setSource($request->input('source'))
            ->setCategory($request->input('category'))
            ->setUrl($request->input('url'))
            ->setPublishedAt(\Carbon\Carbon::parse($request->input('published_at')));

        return $dto;
    }

    public static function fromModel(Model $model): DtoInterface
    {
        $dto = new self();
        $dto->setId($model->id)
            ->setTitle($model->title)
            ->setContent($model->content)
            ->setAuthor($model->author)
            ->setSource($model->source)
            ->setCategory($model->category)
            ->setUrl($model->url)
            ->setPublishedAt($model->published_at);

        return $dto;
    }

    public static function toArray(Model $model): array
    {
        return [
            'id' => $model->id,
            'title' => $model->title,
            'content' => $model->content,
            'author' => $model->author,
            'source' => $model->source,
            'category' => $model->category,
            'url' => $model->url,
            'published_at' => $model->published_at,
        ];
    }
}