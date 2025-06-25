<?php

namespace App\Services\Sources;

use App\Services\Sources\SourceInterface;
use App\Transformers\GuardianTransformer;
use Illuminate\Support\Facades\Http;

class GuardianSource implements SourceInterface
{

    const BASE_URL = 'https://content.guardianapis.com';
    protected $transformer;

    public function __construct(GuardianTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    public function fetch(): array
    {
        $res = Http::get(self::BASE_URL . '/search?api-key=' . config('news.guardian.key') . '&show-fields=all&show-tags=contributor');

        $articles = $res->json('response.results') ?? [];

        return collect($articles)
            ->map(fn($article) => $this->transformer->transform($article))
            ->toArray();
    }
}
