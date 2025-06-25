<?php

namespace App\Transformers;

use App\constants\ArticleSources;
use App\Transformers\NewsTransformerInterface;

class GuardianTransformer implements NewsTransformerInterface
{

    public function transform(array $raw): array
    {
        $publishedAt = !empty($raw['publishedAt']) ? date('Y-m-d H:i:s', strtotime($raw['publishedAt']))
            : now()->toDateTime()->format('Y-m-d H:i:s');

        return [
            'title' => $raw['webTitle'] ?? '',
            'content' => $raw['fields']['body'] ?? '',
            'category' => $raw['sectionName'] ?? 'general',
            'source' => ArticleSources::THE_GUARDIAN_SOURCE,
            'published_at' => $publishedAt,
            'authors' => $this->extractAuthors($raw),
        ];
    }

    private function extractAuthors(array $raw): array
    {
        if (!isset($raw['tags']) || !is_array($raw['tags'])) return [];

        return collect($raw['tags'])
            ->filter(fn($tag) => $tag['type'] === 'contributor')
            ->pluck('webTitle')
            ->toArray();
    }
}
