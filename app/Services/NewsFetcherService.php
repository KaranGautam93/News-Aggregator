<?php

namespace App\Services;

use App\Services\Sources\SourceInterface;

class NewsFetcherService
{
    protected array $sources;

    public function __construct()
    {
        $this->sources = collect(config('news.sources'))
            ->map(fn($class) => app($class))
            ->filter(fn($source) => $source instanceof SourceInterface)
            ->toArray();
    }

    public function fetchFromAll(): array
    {
        return collect($this->sources)
            ->flatMap(fn(SourceInterface $source) => $source->fetch())
            ->toArray();
    }
}
