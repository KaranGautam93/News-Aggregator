<?php

namespace App\Transformers;

use App\constants\ArticleSources;
use App\Transformers\NewsTransformerInterface;

class NewsApiTransformer implements NewsTransformerInterface
{

    public function transform(array $raw): array
    {
        $category = $raw['categories'][0]['label'] ?? 'general';
        $category = explode('/', $category)[1] ?? 'general';

        $publishedAt = !empty($raw['dateTime']) ? date('Y-m-d H:i:s', strtotime($raw['dateTime']))
            : now()->toDateTime()->format('Y-m-d H:i:s');

        return [
            'title' => $raw['title'] ?? '',
            'content' => $raw['body'] ?? '',
            'category' => $category,
            'source' => ArticleSources::NEWS_API_SOURCE,
            'published_at' => $publishedAt,
            'authors' => $this->extractAuthors($raw),
        ];
    }

    private function extractAuthors(array $raw): array
    {
        return isset($raw['authors']) && is_array($raw['authors'])
            ? array_map(fn($a) => $a['name'], $raw['authors'])
            : [];
    }

}
