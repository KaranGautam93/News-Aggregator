<?php

namespace App\Services\Sources;

use App\Services\Sources\SourceInterface;
use App\Transformers\NYTTransformer;
use Illuminate\Support\Facades\Http;

class NYTSource implements SourceInterface
{
    const BASE_URL = 'https://api.nytimes.com';
    protected $transformer;

    public function __construct(NYTTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function fetch(): array
    {
        $response = Http::get(self::BASE_URL . '/svc/search/v2/articlesearch.json', [
            'api-key' => config('news.nytapi.key'),
            'sort'    => 'newest',
            'page'    => 0,
        ]);

        if (!$response->successful()) {
            logger()->error('NYTimes fetch failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            return [];
        }

        $articles = $response->json('response.docs') ?? [];

        return collect($articles)
            ->map(fn($item) => $this->transformer->transform($item))
            ->toArray();
    }
}
