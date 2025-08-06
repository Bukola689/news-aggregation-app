<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Author;
use App\Models\Source;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ArticleResource;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
       $articles = Article::with(['source', 'categories', 'authors'])
            ->withFilters($request->all())
            ->orderBy('published_at', 'desc')
            ->paginate($request->per_page ?? 20);

        return ArticleResource::collection($articles);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): JsonResponse
    {
        $dto = ArticleDto::fromRequest($request);
        $article = $this->articleService->create($dto);
        return response()->json(['data' => $article], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {

         $article = $article->load(['source', 'categories', 'authors']);

        return new ArticleResource($article);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
     public function personalizedFeed(Request $request)
    {
        $user = $request->user();
        
        $articles = Article::with(['source', 'categories', 'authors'])
            ->when($user->preferredSources->count() > 0, function ($query) use ($user) {
                $query->whereIn('source_id', $user->preferredSources->pluck('id'));
            })
            ->when($user->preferredCategories->count() > 0, function ($query) use ($user) {
                $query->whereHas('categories', function ($q) use ($user) {
                    $q->whereIn('id', $user->preferredCategories->pluck('id'));
                });
            })
            ->when($user->preferredAuthors->count() > 0, function ($query) use ($user) {
                $query->whereHas('authors', function ($q) use ($user) {
                    $q->whereIn('id', $user->preferredAuthors->pluck('id'));
                });
            })
            ->orderBy('published_at', 'desc')
            ->paginate($request->per_page ?? 20);

        return ArticleResource::collection($articles);
    }

    public function update(Request $request, Article $article)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        //
    }

     public function sources()
    {
        return Source::all();
    }

    public function categories()
    {
        return Category::all();
    }

    public function authors()
    {
        return Author::all();
    }

}
