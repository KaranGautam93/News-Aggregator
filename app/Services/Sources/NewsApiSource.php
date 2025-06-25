<?php

namespace App\Services\Sources;

use App\Services\Sources\SourceInterface;
use App\Transformers\NewsApiTransformer;
use App\Transformers\NewsTransformerInterface;
use Illuminate\Support\Facades\Http;

class NewsApiSource implements SourceInterface
{
    const BASE_URL = 'https://eventregistry.org';
    protected $transformer;

    public function __construct(NewsApiTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function fetch(): array
    {
        $res = Http::get(self::BASE_URL . '/api/v1/article/getArticles', [
            'lang' => 'eng',
            'sortBy' => 'date',
            'articlesPage' => 1,
            'articlesCount' => 10,
            'apiKey' => config('news.newsapi.key'),
            'includeArticleCategories' => true
        ]);
        $articles = $res->json('articles.results') ?? [];

        return collect($articles)
            ->map(fn($article) => $this->transformer->transform($article))
            ->toArray();
    }
}
